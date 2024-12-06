<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bid;
use App\Models\Koi;
use App\Models\Cart;
use App\Events\PlaceBid;
use App\Events\AuctionWon;
use App\Models\Achievement;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\ExtraTimeAdded;
use Xendit\Invoice\InvoiceApi;
use App\Models\UserAchievement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Xendit\Invoice\CreateInvoiceRequest;

class BidController extends Controller
{
    public function userBids()
    {
        $userId = Auth::id();

        // Ambil semua bid yang dilakukan oleh user yang sedang login untuk lelang yang statusnya "on going"
        $bids = Bid::with([
            'koi.auction',        // Load relasi auction untuk koi
            'koi.bids' => function ($query) use ($userId) {
                $query->where('user_id', $userId)->orderBy('created_at', 'desc'); // Urutkan bid user yang sedang login berdasarkan waktu
            },
            'koi.media' => function ($query) {
                $query->where('media_type', 'photo'); // Hanya ambil media dengan tipe photo
            }
        ])
            ->where('user_id', $userId) // Filter hanya bid yang dibuat oleh user yang sedang login
            ->orderBy('created_at', 'desc')
            ->get();


        // Ambil semua bid terakhir dari setiap koi yang sedang berlangsung dan urutkan dari yang terbaru
        $latestBids = Bid::with([
            'koi.auction',  // Load relasi auction untuk koi
            'user'          // Load relasi user untuk bid
        ])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('koi_id') // Kelompokkan berdasarkan koi_id
            ->map(function ($koiBids) {
                return $koiBids->sortByDesc('created_at')->first(); // Ambil bid terakhir untuk setiap koi
            });

        // Cek apakah setiap koi sudah ada pemenang (is_win = true)
        $winners = $latestBids->map(function ($latestBid) {
            return $latestBid && $latestBid->is_win ? $latestBid : null; // Tandai pemenang
        });

        // Ambil hanya bid terakhir yang dibuat oleh user untuk setiap koi yang diikuti oleh user
        $kois = $bids->filter(function ($bid) {
            return $bid->koi && $bid->koi->auction; // Pastikan koi dan auction ada
        })->groupBy('koi_id')->map(function ($koiBids) {
            return $koiBids->sortByDesc('created_at')->first(); // Ambil bid terbaru dari masing-masing koi
        });

        return view('bids.index', compact(['kois', 'latestBids', 'winners']));
    }

    public function confirmPin(Request $request)
    {
        $request->validate([
            'koi_id' => 'required|exists:kois,id',
            'pin' => 'required|numeric|digits:4',
        ]);

        $user = Auth::user();
        $koiId = $request->input('koi_id');
        $inputPin = $request->input('pin');

        // Verifikasi PIN pengguna
        if ($user->pin !== $inputPin) {
            return response()->json(['success' => false, 'message' => 'PIN salah'], 400);
        }

        return response()->json(['success' => true, 'message' => 'PIN valid']);
    }

    // BinController
    // Di dalam BidController.php

    public function confirmBIN(Request $request)
    {
        $request->validate([
            'koi_id' => 'required|exists:kois,id',
        ]);

        $koi = Koi::with(['bids', 'auction'])->findOrFail($request->input('koi_id'));
        $user = Auth::user();

        // Cek threshold 80% dari harga BIN
        $latestBid = $koi->bids->last();
        $threshold = 0.8 * $koi->buy_it_now;

        if ($latestBid && $latestBid->amount >= $threshold) {
            return response()->json([
                'success' => false,
                'message' => 'BIN tidak valid, bid telah mencapai 80% dari nilai BIN',
            ], 400);
        }

        // Simpan bid sebagai BIN
        $bid = new Bid();
        $bid->koi_id = $koi->id;
        $bid->user_id = $user->id;
        $bid->amount = $koi->buy_it_now;
        $bid->is_win = true;
        $bid->is_bin = true;
        $bid->save();

        // Hitung biaya tambahan (disimpan untuk referensi transaksi nanti)
        $baseAmount = $koi->buy_it_now * 1000; // Harga BIN dikonversi ke Rupiah

        // Tambahkan koi ke keranjang
        $cart = new Cart();
        $cart->user_id = $user->id;
        $cart->koi_id = $koi->id;
        $cart->auction_name = $koi->auction->title;
        $cart->price = $baseAmount;
        $cart->save();

        // Broadcast untuk notifikasi ke semua pengguna di halaman lelang
        broadcast(new AuctionWon($bid))->toOthers();

        // Trigger Achievement terkait BIN
        $this->checkAchievement($user, $bid);

        return response()->json([
            'success' => true,
            'message' => 'BIN berhasil, koi telah dimasukkan ke keranjang',
            'cart' => $cart,
        ]);
    }

    // Tambahkan fungsi untuk evaluasi achievement terkait BIN
    private function checkAchievement($user, $bid)
    {
        // Ambil jumlah BIN yang sudah dilakukan oleh user
        $binCount = Bid::where('user_id', $user->id)->where('is_bin', true)->count();

        // Achievement terkait BIN
        $achievements = Achievement::whereIn('condition', ['bin_rookie', 'bin_pro', 'bin_master'])->get();

        foreach ($achievements as $achievement) {
            switch ($achievement->condition) {
                case 'bin_rookie': // ID 70
                    if ($binCount >= 10) {
                        UserAchievement::firstOrCreate([
                            'user_id' => $user->id,
                            'achievement_id' => $achievement->id,
                        ]);
                    }
                    break;

                case 'bin_pro': // ID 71
                    if ($binCount >= 50) {
                        UserAchievement::firstOrCreate([
                            'user_id' => $user->id,
                            'achievement_id' => $achievement->id,
                        ]);
                    }
                    break;

                case 'bin_master': // ID 72
                    if ($binCount >= 100) {
                        UserAchievement::firstOrCreate([
                            'user_id' => $user->id,
                            'achievement_id' => $achievement->id,
                        ]);
                    }
                    break;
            }
        }
    }

    public function checkBid(Request $request)
    {
        $koi = Koi::with('bids')->findOrFail($request->koi_id);

        $latestBid = $koi->bids->last();
        $minimumBid = $latestBid ? $latestBid->amount + $koi->kelipatan_bid : $koi->open_bid;

        $bidAmount = $request->bid_amount;

        if ($bidAmount < $minimumBid) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal bid harus ' . number_format($minimumBid, 0, ',', '.') . ' atau lebih tinggi',
                'minimumBid' => $minimumBid
            ]);
        }

        if (($bidAmount - $koi->open_bid) % $koi->kelipatan_bid != 0) {
            return response()->json([
                'success' => false,
                'message' => 'Nilai bid harus sesuai kelipatan bid ' . number_format($koi->kelipatan_bid, 0, ',', '.'),
                'minimumBid' => $minimumBid
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Bid valid']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'koi_id' => 'required|exists:kois,id',
            'bid_amount' => 'required|numeric|min:1',
        ]);

        $koi = Koi::with('auction')->findOrFail($request->input('koi_id'));
        $auction = $koi->auction;

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login untuk melakukan bid.',
            ], 401);
        }

        $sellerId = $auction->user_id;
        if (Auth::id() == $sellerId) {
            return response()->json([
                'success' => false,
                'message' => 'Seller tidak dapat melakukan bid di lelang mereka sendiri.'
            ], 403);
        }

        if ($auction->status !== 'on going') {
            return response()->json([
                'success' => false,
                'message' => 'Auction is not active'
            ], 400);
        }

        $end_time = Carbon::parse($auction->end_time)->addMinutes($auction->extra_time);
        $remainingTime = $end_time->diffInMinutes(Carbon::now(), false);

        //tambah variable untuk setting sniping threshold (1 jam) (admin panel)
        $isSniping = $remainingTime >= -60 && $remainingTime <= 0;

        if ($isSniping) {
            // tambahkan variable untuk setting sniping time (admin panel)
            $auction->extra_time += 10;
            $auction->save();

            broadcast(new ExtraTimeAdded($auction->auction_code, $auction->extra_time))->toOthers();
        }

        $bid = new Bid();
        $bid->koi_id = $request->input('koi_id');
        $bid->user_id = Auth::id();
        $bid->amount = $request->input('bid_amount');
        $bid->is_sniping = $isSniping;
        $bid->is_win = 0;

        if ($bid->save()) {
            broadcast(new PlaceBid($bid, $isSniping))->toOthers();

            return response()->json([
                'success' => true,
                'message' => 'Bid successfully placed',
                'bid' => $bid,
                'end' => $end_time,
                'isSniping' => $isSniping,
                'remainingTime' => $remainingTime,
                'extraTime' => $auction->extra_time
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to place bid'
            ]);
        }
    }
}
