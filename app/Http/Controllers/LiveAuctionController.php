<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Koi;
use App\Models\Event;
use App\Models\Wishlist;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiveAuctionController extends Controller
{

    public function index(Request $request)
    {
        $userId = Auth::id(); // ID user yang sedang login

        // Ambil koi dengan jenis reguler menggunakan eager loading
        $kois = Koi::with([
            'auction',
            'media' => function ($query) {
                $query->where('media_type', 'photo');
            },
            'bids' => function ($query) {
                $query->latest();
            }
        ])
            ->whereHas('auction', function ($query) {
                $query->where('jenis', 'reguler')->where('status', 'on going');
            })
            ->get();

        // Ambil wishlist user
        $wishlist = Wishlist::where('user_id', $userId)
            ->pluck('koi_id')
            ->toArray();

        // Hitung jumlah like untuk setiap koi
        foreach ($kois as $koi) {
            $koi->likes_count = UserActivity::where('koi_id', $koi->id)
                ->where('activity_type', 'like')
                ->count(); // Hitung jumlah like
            $koi->user_liked = UserActivity::where('koi_id', $koi->id)
                ->where('user_id', $userId)
                ->where('activity_type', 'like')
                ->exists(); // Cek apakah user sudah like
        }

        // Hitung total bids
        $totalBids = Bid::whereIn('koi_id', $kois->pluck('id'))
            ->selectRaw('koi_id, COUNT(*) as total_bids, MAX(amount) as latest_bid')
            ->groupBy('koi_id')
            ->get()
            ->keyBy('koi_id');

        return view('live.index', compact('kois', 'totalBids', 'wishlist'));
    }



    protected function getKois($userId, $auctionType = null)
    {
        // Query dasar untuk mendapatkan data koi select all 
        $query = Koi::whereHas('auction', function ($query) use ($auctionType) {
            $query->whereIn('status', ['on going', 'ready']);
            if ($auctionType) {
                $query->where('jenis', $auctionType); // Filter jenis auction
            }
        });

        // Tambahkan eager loading untuk relasi table kois
        $kois = $query->with([
            'media' => function ($query) {
                $query->where('media_type', 'photo'); // Hanya media dengan tipe foto
            },
            'auction', // Relasi auction
            'activities', // Relasi aktivitas
            'bids.user', // Relasi bids dengan user
        ])
            ->withCount([
                'activities as total_interactions' => function ($query) {
                    $query->whereIn('activity_type', ['view', 'like', 'bid', 'chat']);
                },
                'activities as likes_count' => function ($query) {
                    $query->where('activity_type', 'like');
                },
                'activities as views_count' => function ($query) {
                    $query->where('activity_type', 'view');
                },
            ])
            ->get();

        // Algoritma untuk preferensi user
        $userPreferences = UserActivity::where('user_id', $userId)
            ->whereIn('activity_type', ['view', 'like', 'bid'])
            ->join('kois', 'activities.koi_id', '=', 'kois.id') // Join tabel 'activities' dengan 'kois'
            ->selectRaw('kois.jenis_koi as jenis_koi, kois.ukuran, COUNT(*) as preference_count')
            ->groupBy('kois.jenis_koi', 'kois.ukuran')
            ->orderByDesc('preference_count')
            ->get();

        // Tandai apakah koi sudah di-like oleh user
        $kois->each(function ($koi) use ($userId) {
            $koi->user_liked = $koi->activities->contains(function ($activity) {
                return $activity->activity_type === 'like';
            });

            // Tambahkan end_time ke setiap koi untuk timer
            $koi->end_time = \Carbon\Carbon::parse($koi->auction->end_time)->toIso8601String();
        });

        // Data bids
        $totalBids = $kois->mapWithKeys(function ($koi) {
            $winnerBid = $koi->bids->firstWhere('is_win', true);

            return [
                $koi->id => [
                    'total_bids' => $koi->bids->count(),
                    'latest_bid' => $koi->bids->isNotEmpty() ? $koi->bids->first()->amount : $koi->open_bid,
                    'has_winner' => $winnerBid ? true : false,
                    'winner_name' => optional(optional($winnerBid)->user)->name,
                ],
            ];
        });

        // Algoritma sorting berdasarkan prioritas
        $kois = $kois->sortByDesc(function ($koi) use ($userPreferences) {
            $popularityScore = $koi->total_interactions * 0.4;
            $priceScore = 1 / ($koi->open_bid + 1) * 0.3;
            $timeScore = 1 / (\Carbon\Carbon::parse($koi->auction->end_time)->diffInSeconds(now()) + 1) * 0.2;
            $preferenceScore = $userPreferences->firstWhere('jenis_koi', $koi->jenis_koi)?->preference_count ?? 0;

            return $popularityScore + $priceScore + $timeScore + $preferenceScore;
        });

        return compact('kois', 'totalBids');
    }
}
