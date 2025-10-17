<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bid;
use App\Models\Koi;
use App\Models\Cart;
use App\Events\PlaceBid;
use App\Models\Wishlist;
use App\Events\AuctionWon;
use Illuminate\Http\Request;
use App\Events\ExtraTimeAdded;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class BidController extends Controller
{
    public function userBids(Request $request)
    {
        $userId = Auth::id();

        // Rate limiter untuk mencegah abuse dalam melakukan request
        $key = 'user-bids:' . $userId;
        if (RateLimiter::tooManyAttempts($key, 30)) {
            return response()->json([
                'success' => false,
                'message' => 'Terlalu banyak permintaan, coba lagi dalam beberapa saat.'
            ], 429);
        }
        RateLimiter::hit($key, 60); // decay 60 detik

        // Ambil semua bid user (relasi koi.auction, koi.bids difilter ke user ini)
        $bids = Bid::with([
            'koi.auction',
            'koi.bids' => function ($query) use ($userId) {
                $query->where('user_id', $userId)->orderBy('created_at', 'desc');
            },
            'koi.media' => function ($query) {
                $query->where('media_type', 'photo');
            }
        ])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil wishlist user (tambahkan koi.bids supaya aman dipakai di view)
        $wishlists = Wishlist::with([
            'koi.auction',
            'koi.bids', // penting agar komponen tidak n+1 / null
            'koi.media' => function ($query) {
                $query->where('media_type', 'photo');
            }
        ])
            ->where('user_id', $userId)
            ->get();

        // Gabungkan bid dan wishlist berdasarkan koi_id agar tidak duplikat
        $kois = collect([...$bids, ...$wishlists])
            ->groupBy('koi_id')
            ->map(function ($items) {
                return $items->sortByDesc('created_at')->first();
            });

        // Ambil bid terakhir (global) per koi yang masih "on going"
        $latestBids = Bid::with(['koi.auction', 'user'])
            ->whereHas('koi.auction', function ($query) {
                $query->where('status', 'on going');
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('koi_id')
            ->map(fn($bids) => $bids->sortByDesc('created_at')->first());

        // Pemenang (is_win = true)
        $winners = $latestBids->filter(fn($bid) => $bid && $bid->is_win);

        return view('bids.index', compact(['kois', 'latestBids', 'winners']));
    }

    public function confirmPin(Request $request)
    {
        $request->validate([
            'koi_id' => 'required|exists:kois,id',
            'pin'    => 'required|numeric|digits:4',
        ]);

        $user = Auth::user();
        $inputPin = $request->input('pin');

        if ($user->pin !== $inputPin) {
            return response()->json(['success' => false, 'message' => 'PIN salah'], 400);
        }

        return response()->json(['success' => true, 'message' => 'PIN valid']);
    }

    public function confirmBIN(Request $request)
    {
        $request->validate([
            'koi_id' => 'required|exists:kois,id',
        ]);

        $koi = Koi::with(['bids', 'auction'])->findOrFail($request->input('koi_id'));
        $user = Auth::user();

        // Cek threshold 80% dari BIN
        $latestBid = $koi->bids->last();
        $threshold = 0.8 * (float) ($koi->buy_it_now ?? 0);

        if ($latestBid && $latestBid->amount >= $threshold) {
            return response()->json([
                'success' => false,
                'message' => 'BIN tidak valid, bid telah mencapai 80% dari nilai BIN',
            ], 400);
        }

        // Simpan bid sebagai BIN (menang)
        $bid = new Bid();
        $bid->koi_id = $koi->id;
        $bid->user_id = $user->id;
        $bid->amount = (int) $koi->buy_it_now;
        $bid->is_win = true;
        $bid->is_bin = true;
        $bid->save();

        // Simpan ke cart (contoh konversi nominal)
        $baseAmount = (int) ($koi->buy_it_now * 1000);

        $cart = new Cart();
        $cart->user_id = $user->id;
        $cart->koi_id = $koi->id;
        $cart->auction_name = optional($koi->auction)->title ?? '';
        $cart->price = $baseAmount;
        $cart->save();

        // Broadcast pemenang
        broadcast(new AuctionWon($bid))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'BIN berhasil, koi telah dimasukkan ke keranjang',
            'cart'    => $cart,
        ]);
    }

    public function store(Request $request)
    {
        $key = 'bid-action:' . Auth::id();
        $bid_attempt = 10;

        if (RateLimiter::tooManyAttempts($key, $bid_attempt)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'message' => "Anda telah mencapai batas bid. Coba lagi dalam $seconds detik.",
            ], 429);
        }

        $request->validate([
            'koi_id'     => 'required|exists:kois,id',
            'bid_amount' => 'required|numeric|min:1',
        ]);

        $koi = Koi::with('auction', 'bids')->findOrFail($request->input('koi_id'));
        $auction = $koi->auction;

        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Anda harus login untuk melakukan bid.'], 401);
        }

        if ($auction && Auth::id() == $auction->user_id) {
            return response()->json(['success' => false, 'message' => 'Seller tidak dapat melakukan bid di lelang mereka sendiri.'], 403);
        }

        if (!$auction || $auction->status !== 'on going') {
            return response()->json(['success' => false, 'message' => 'Auction tidak aktif'], 400);
        }

        $latestBid  = $koi->bids->last();
        $minimumBid = $latestBid ? ($latestBid->amount + (int) $koi->kelipatan_bid) : (int) $koi->open_bid;
        $bidAmount  = (int) $request->input('bid_amount');

        if ($bidAmount < $minimumBid) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal bid harus Rp ' . number_format($minimumBid, 0, ',', '.') . ' atau lebih tinggi',
            ], 400);
        }

        if ((($bidAmount - (int) $koi->open_bid) % (int) $koi->kelipatan_bid) != 0) {
            return response()->json([
                'success' => false,
                'message' => 'Nilai bid harus sesuai kelipatan bid Rp ' . number_format((int) $koi->kelipatan_bid, 0, ',', '.'),
            ], 400);
        }

        $end_time = Carbon::parse($auction->end_time)->addMinutes((int) $auction->extra_time);
        $remainingTime = $end_time->diffInMinutes(Carbon::now(), false);
        $isSniping = $remainingTime >= -60 && $remainingTime <= 0;

        if ($isSniping) {
            $auction->extra_time = (int) $auction->extra_time + 10;
            $auction->save();
            broadcast(new ExtraTimeAdded($auction->auction_code, $auction->extra_time))->toOthers();
        }

        $bid = new Bid();
        $bid->koi_id = $koi->id;
        $bid->user_id = Auth::id();
        $bid->amount = $bidAmount;
        $bid->is_sniping = $isSniping;
        $bid->is_win = 0;

        if ($bid->save()) {
            RateLimiter::hit($key);
            broadcast(new PlaceBid($bid, $isSniping))->toOthers();

            return response()->json([
                'success'       => true,
                'message'       => 'Bid berhasil dipasang',
                'bid'           => $bid,
                'end'           => $end_time,
                'isSniping'     => $isSniping,
                'remainingTime' => $remainingTime,
                'extraTime'     => $auction->extra_time
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal menyimpan bid'], 500);
    }
}
