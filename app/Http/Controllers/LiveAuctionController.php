<?php

namespace App\Http\Controllers;

use App\Models\Koi;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiveAuctionController extends Controller
{

    public function index(Request $request)
    {
        $userId = Auth::id(); // ID user yang sedang login

        // Ambil koi dengan jenis reguler
        $data = $this->getKois($userId, 'reguler');

        // Kirim data koi, bids, views, dan likes ke view
        return view('live.index', $data);
    }


    public function event(Request $request)
    {
        $userId = Auth::id(); // ID user yang sedang login

        // Ambil koi selain jenis reguler
        $data = $this->getKois($userId);

        // Filter u/ jenis selain reguler
        $data['kois'] = $data['kois']->filter(function ($koi) {
            return $koi->auction->jenis !== 'reguler';
        });

        // Kirim data koi, bids, views, dan likes ke view
        return view('live.index', $data);
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
