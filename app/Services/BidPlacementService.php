<?php

namespace App\Services;

use App\Events\AuctionWon;
use App\Events\ExtraTimeAdded;
use App\Events\PlaceBid;
use App\Models\Bid;
use App\Models\Cart;
use App\Models\Koi;
use App\Models\User;
use App\Notifications\AuctionWonNotification;
use App\Notifications\NewBidNotification;
use App\Notifications\OutbidNotification;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BidPlacementService
{
    /**
     * Process a regular bid placement.
     */
    public function placeBid(User $user, int $koiId, int $amount): array
    {
        try {
            $result = DB::transaction(function () use ($user, $koiId, $amount) {
                $koi = Koi::with(['auction.user'])
                    ->lockForUpdate()
                    ->findOrFail($koiId);

                $auction = $koi->auction;

                if (!$auction || $auction->status !== 'on going') {
                    throw ValidationException::withMessages([
                        'auction' => 'Auction tidak aktif.',
                    ]);
                }

                if ($auction->user_id === $user->id) {
                    throw new AuthorizationException('Seller tidak dapat melakukan bid di lelang sendiri.');
                }

                $previousTopBid = Bid::where('koi_id', $koi->id)
                    ->orderBy('created_at', 'desc')
                    ->lockForUpdate()
                    ->first();

                $minimumBid = $previousTopBid
                    ? $previousTopBid->amount + $koi->kelipatan_bid
                    : $koi->open_bid;

                if ($amount < $minimumBid) {
                    throw ValidationException::withMessages([
                        'bid_amount' => 'Minimal bid harus Rp ' . number_format($minimumBid, 0, ',', '.') . ' atau lebih tinggi.',
                    ]);
                }

                if (($amount - $koi->open_bid) % $koi->kelipatan_bid !== 0) {
                    throw ValidationException::withMessages([
                        'bid_amount' => 'Nilai bid harus sesuai kelipatan bid Rp ' . number_format($koi->kelipatan_bid, 0, ',', '.'),
                    ]);
                }

                $endTime = Carbon::parse($auction->end_time)->addMinutes($auction->extra_time);
                $remainingTime = $endTime->diffInMinutes(Carbon::now(), false);
                $isSniping = $remainingTime >= -60 && $remainingTime <= 0;
                $extraTimeUpdated = false;

                if ($isSniping) {
                    $auction->extra_time += 10;
                    $auction->save();
                    $extraTimeUpdated = true;
                    $endTime = Carbon::parse($auction->end_time)->addMinutes($auction->extra_time);
                    $remainingTime = $endTime->diffInMinutes(Carbon::now(), false);
                }

                $bid = Bid::create([
                    'koi_id' => $koi->id,
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'is_sniping' => $isSniping,
                    'is_win' => false,
                ]);

                $bid->load('user', 'koi');
                $previousTopBid?->load('user', 'koi');
                $auction->loadMissing('user');

                $payload = [
                    'bid' => $bid,
                    'previous_top_bid' => $previousTopBid,
                    'auction' => $auction,
                    'is_sniping' => $isSniping,
                    'remaining_time' => $remainingTime,
                    'extra_time_updated' => $extraTimeUpdated,
                    'end_time' => $endTime,
                ];

                DB::afterCommit(function () use ($payload) {
                    /** @var \App\Models\Bid $bid */
                    $bid = $payload['bid'];
                    $auction = $payload['auction'];
                    $previousTopBid = $payload['previous_top_bid'];

                    broadcast(new PlaceBid($bid, $payload['is_sniping']))->toOthers();

                    if ($payload['extra_time_updated']) {
                        broadcast(new ExtraTimeAdded($auction->auction_code, $auction->extra_time))->toOthers();
                    }

                    if ($previousTopBid && $previousTopBid->user_id !== $bid->user_id) {
                        $previousTopBid->user->notify(new OutbidNotification($previousTopBid, $bid));
                    }

                    if ($auction->user && $auction->user->id !== $bid->user_id) {
                        $auction->user->notify(new NewBidNotification($bid));
                    }
                });

                return $payload;
            });
        } catch (ModelNotFoundException $exception) {
            throw ValidationException::withMessages(['koi_id' => 'Koi tidak ditemukan.']);
        }

        return [
            'bid' => $result['bid'],
            'auction' => $result['auction'],
            'is_sniping' => $result['is_sniping'],
            'remaining_time' => $result['remaining_time'],
            'end_time' => $result['end_time'],
        ];
    }

    /**
     * Handle Buy-It-Now confirmation.
     */
    public function confirmBuyNow(User $user, int $koiId): array
    {
        try {
            $result = DB::transaction(function () use ($user, $koiId) {
                $koi = Koi::with(['auction.user', 'bids' => fn ($q) => $q->orderBy('created_at', 'desc')])
                    ->lockForUpdate()
                    ->findOrFail($koiId);

                $auction = $koi->auction;

                if (!$auction || $auction->status !== 'on going') {
                    throw ValidationException::withMessages([
                        'auction' => 'Auction tidak aktif.',
                    ]);
                }

                if ($auction->user_id === $user->id) {
                    throw new AuthorizationException('Seller tidak dapat melakukan BIN di lelang sendiri.');
                }

                if (!$koi->buy_it_now) {
                    throw ValidationException::withMessages([
                        'buy_it_now' => 'BIN tidak tersedia untuk koi ini.',
                    ]);
                }

                $previousTopBid = $koi->bids->first();
                $latestBid = $previousTopBid;

                if ($latestBid && $latestBid->amount >= 0.8 * $koi->buy_it_now) {
                    throw ValidationException::withMessages([
                        'buy_it_now' => 'BIN tidak valid, bid telah mencapai 80% dari nilai BIN.',
                    ]);
                }

                $bid = Bid::create([
                    'koi_id' => $koi->id,
                    'user_id' => $user->id,
                    'amount' => $koi->buy_it_now,
                    'is_win' => true,
                    'is_bin' => true,
                ]);

                $cart = Cart::create([
                    'user_id' => $user->id,
                    'koi_id' => $koi->id,
                    'auction_name' => $auction->title,
                    'price' => $koi->buy_it_now * 1000,
                ]);

                $bid->load('user', 'koi');
                $auction->loadMissing('user');
                $previousTopBid?->load('user', 'koi');

                DB::afterCommit(function () use ($bid, $cart, $auction, $previousTopBid) {
                    broadcast(new AuctionWon($bid))->toOthers();

                    $bid->user->notify(new AuctionWonNotification($bid));

                    if ($auction->user && $auction->user->id !== $bid->user_id) {
                        $auction->user->notify(new AuctionWonNotification($bid, true));
                    }

                    if ($previousTopBid && $previousTopBid->user_id !== $bid->user_id) {
                        $previousTopBid->user->notify(new OutbidNotification($previousTopBid, $bid));
                    }
                });

                return compact('bid', 'cart');
            });
        } catch (ModelNotFoundException $exception) {
            throw ValidationException::withMessages(['koi_id' => 'Koi tidak ditemukan.']);
        }

        return $result;
    }
}
