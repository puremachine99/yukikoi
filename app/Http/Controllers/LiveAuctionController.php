<?php

namespace App\Http\Controllers;

use App\Models\Koi;
use Illuminate\Http\Request;

class LiveAuctionController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id(); // ID user yang sedang login

        // Ambil semua koi yang lelangnya berstatus 'on going' atau 'ready', beserta media, bids, views, dan likes
        $kois = Koi::whereHas('auction', function ($query) {
            $query->whereIn('status', ['on going', 'ready']);
        })->with([
            'media' => function ($query) {
                $query->where('media_type', 'photo'); // Hanya media dengan tipe foto
            },
            'bids' => function ($query) {
                $query->latest(); // Urutkan bids dari yang terbaru
            },
            'auction', // Memuat data lelang
            'likes' => function ($query) use ($userId) {
                $query->where('user_id', $userId); // Ambil hanya likes dari user yang login
            },
        ])
            ->withCount(['views', 'likes']) // Hitung jumlah likes dan views
            ->get();

        // Tandai apakah koi sudah di-like oleh user yang login
        $kois->each(function ($koi) use ($userId) {
            $koi->user_liked = $koi->likes->contains('user_id', $userId); // Cek apakah user_id ada di likes
        });

        // Buat data summary untuk bids
        $totalBids = $kois->mapWithKeys(function ($koi) {
            $winnerBid = $koi->bids->firstWhere('is_win', true); // Ambil bid yang menjadi pemenang

            return [
                $koi->id => [
                    'total_bids' => $koi->bids->count(),
                    'latest_bid' => $koi->bids->isNotEmpty() ? $koi->bids->first()->amount : $koi->open_bid,
                    'has_winner' => $winnerBid ? true : false,
                    'winner_name' => optional(optional($winnerBid)->user)->name, // Menggunakan optional() untuk menghindari error jika user null
                ],
            ];
        });

        //buat preferensi feed user, koi2 yang diminati
        // gimana caranya mengatur algoritma feed s

        // Kirim data koi, bids, views, dan likes ke view
        return view('live.index', compact('kois', 'totalBids'));
    }
}
