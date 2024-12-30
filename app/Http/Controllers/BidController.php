<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bid;
use App\Models\Koi;
use App\Models\Cart;
use App\Events\PlaceBid;
use App\Events\AuctionWon;
use Illuminate\Http\Request;
use App\Events\ExtraTimeAdded;
use App\Models\UserAchievement;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BidController extends Controller
{
    // ========================== CONFIGURATION ==========================
    const BIN_THRESHOLD = 0.8; // 80% dari harga BIN
    const SNIPING_THRESHOLD_MINUTES = -60; // Sniping threshold (-60 menit)
    const EXTRA_TIME_MINUTES = 10; // Tambahan waktu untuk sniping
    const BIN_CONVERSION_RATE = 1000; // Konversi harga BIN ke Rupiah

    // ========================== USER BIDS ==========================
    public function userBids()
    {
        $userId = Auth::id();

        // Ambil semua bid user yang sedang login
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

        // Ambil bid terakhir dari setiap koi
        $latestBids = Bid::with(['koi.auction', 'user'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('koi_id')
            ->map(fn($koiBids) => $koiBids->sortByDesc('created_at')->first());

        // Tandai pemenang jika ada
        $winners = $latestBids->filter(fn($latestBid) => $latestBid && $latestBid->is_win);

        return view('bids.index', compact(['bids', 'latestBids', 'winners']));
    }

    // ========================== PIN CONFIRMATION ==========================
    public function confirmPin(Request $request)
    {
        try {
            $request->validate([
                'koi_id' => 'required|exists:kois,id',
                'pin' => 'required|numeric|digits:4',
            ]);

            $user = Auth::user();

            if (!Hash::check($request->input('pin'), $user->pin)) {
                return response()->json(['success' => false, 'message' => 'PIN salah'], 400);
            }

            return response()->json(['success' => true, 'message' => 'PIN valid']);
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error in confirmPin: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }


    // ========================== BIN CONFIRMATION ==========================
    public function confirmBIN(Request $request)
    {
        $request->validate(['koi_id' => 'required|exists:kois,id']);
        $koi = Koi::with(['bids', 'auction'])->findOrFail($request->input('koi_id'));
        $user = Auth::user();

        $latestBid = $koi->bids->last();
        $threshold = self::BIN_THRESHOLD * $koi->buy_it_now;

        if ($latestBid && $latestBid->amount >= $threshold) {
            return response()->json([
                'success' => false,
                'message' => 'BIN tidak valid, bid telah mencapai 80% dari nilai BIN',
            ], 400);
        }

        // Simpan bid sebagai BIN
        $bid = Bid::create([
            'koi_id' => $koi->id,
            'user_id' => $user->id,
            'amount' => $koi->buy_it_now,
            'is_win' => true,
            'is_bin' => true,
        ]);

        // Tambahkan koi ke keranjang
        $cart = Cart::create([
            'user_id' => $user->id,
            'koi_id' => $koi->id,
            'auction_name' => $koi->auction->title,
            'price' => $koi->buy_it_now * self::BIN_CONVERSION_RATE,
        ]);

        broadcast(new AuctionWon($bid))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'BIN berhasil, koi telah dimasukkan ke keranjang',
            'cart' => $cart,
        ]);
    }

    // ========================== BID CHECK ==========================
    public function checkBid(Request $request)
    {
        $koi = Koi::with('bids')->findOrFail($request->input('koi_id'));
        $latestBid = $koi->bids->last();
        $minimumBid = $latestBid ? $latestBid->amount + $koi->kelipatan_bid : $koi->open_bid;

        if ($request->bid_amount < $minimumBid) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal bid harus ' . number_format($minimumBid, 0, ',', '.'),
                'minimumBid' => $minimumBid,
            ]);
        }

        if (($request->bid_amount - $koi->open_bid) % $koi->kelipatan_bid != 0) {
            return response()->json([
                'success' => false,
                'message' => 'Nilai bid harus sesuai kelipatan bid ' . number_format($koi->kelipatan_bid, 0, ',', '.'),
                'minimumBid' => $minimumBid,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Bid valid']);
    }

    // ========================== BID STORE ==========================
    public function store(Request $request)
    {
        $request->validate([
            'koi_id' => 'required|exists:kois,id',
            'bid_amount' => 'required|numeric|min:1',
        ]);

        $koi = Koi::with('auction')->findOrFail($request->input('koi_id'));
        $auction = $koi->auction;

        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Anda harus login untuk melakukan bid.'], 401);
        }

        if (Auth::id() === $auction->user_id) {
            return response()->json(['success' => false, 'message' => 'Seller tidak dapat melakukan bid di lelang mereka sendiri.'], 403);
        }

        if ($auction->status !== 'on going') {
            return response()->json(['success' => false, 'message' => 'Auction tidak aktif'], 400);
        }

        $endTime = Carbon::parse($auction->end_time)->addMinutes($auction->extra_time);
        $remainingTime = $endTime->diffInMinutes(Carbon::now(), false);
        $isSniping = $remainingTime >= self::SNIPING_THRESHOLD_MINUTES && $remainingTime <= 0;

        if ($isSniping) {
            $auction->extra_time += self::EXTRA_TIME_MINUTES;
            $auction->save();

            broadcast(new ExtraTimeAdded($auction->auction_code, $auction->extra_time))->toOthers();
        }

        $bid = Bid::create([
            'koi_id' => $koi->id,
            'user_id' => Auth::id(),
            'amount' => $request->input('bid_amount'),
            'is_sniping' => $isSniping,
        ]);

        broadcast(new PlaceBid($bid, $isSniping))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'Bid berhasil dipasang',
            'bid' => $bid,
        ]);
    }
}
