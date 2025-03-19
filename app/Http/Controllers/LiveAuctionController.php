<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Koi;
use App\Models\User;
use App\Models\Event;
use App\Models\Wishlist;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LiveAuctionController extends Controller
{

    public function index(Request $request)
    {
        $userId = Auth::id(); // ID user yang sedang login

        // Ambil parameter pencarian dari request
        $search = $request->input('q');
        $gender = $request->input('gender');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // **Hitung Preferensi User Berdasarkan Aktivitas**
        $userPreferences = DB::table('activities')
            ->selectRaw('
            koi_id,
            SUM(CASE WHEN activity_type = "view" THEN 1 ELSE 0 END) * 1 +
            SUM(CASE WHEN activity_type = "like" THEN 3 ELSE 0 END) * 3 +
            SUM(CASE WHEN activity_type = "bid" THEN 5 ELSE 0 END) * 5 AS weight
        ')
            ->where('user_id', $userId)
            ->groupBy('koi_id');

        // **Query utama untuk mengambil koi yang sedang dilelang (jenis reguler)**
        $query = Koi::with([
            'auction',
            'media' => function ($query) {
                $query->where('media_type', 'photo');
            },
            'bids' => function ($query) {
                $query->latest();
            }
        ])
            ->leftJoinSub($userPreferences, 'user_pref', function ($join) {
                $join->on('kois.id', '=', 'user_pref.koi_id');
            })
            ->whereHas('auction', function ($query) {
                $query->where('jenis', 'reguler')->where('status', 'on going');
            });

        // **Filter berdasarkan pencarian judul atau jenis koi**
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%")
                    ->orWhere('jenis_koi', 'like', "%$search%");
            });
        }

        // **Filter berdasarkan gender**
        if (!empty($gender)) {
            $query->where('gender', $gender);
        }

        // **Filter berdasarkan harga minimum**
        if (!empty($minPrice)) {
            $query->where('open_bid', '>=', $minPrice);
        }

        // **Filter berdasarkan harga maksimum**
        if (!empty($maxPrice)) {
            $query->where('open_bid', '<=', $maxPrice);
        }

        // **Ambil data dengan sorting berdasarkan weight dari preferensi user**
        $kois = $query
            ->orderByDesc('user_pref.weight')
            ->orderByDesc('created_at') // Jika tidak ada preferensi, urutkan berdasarkan terbaru
            ->select('kois.*') // Pastikan hanya kolom dari `kois` yang diambil
            ->paginate(30);

        // **Ambil wishlist user**
        $wishlist = Wishlist::where('user_id', $userId)
            ->pluck('koi_id')
            ->toArray();

        // **Ambil jumlah like untuk setiap koi**
        $likes = UserActivity::whereIn('koi_id', $kois->pluck('id'))
            ->where('activity_type', 'like')
            ->selectRaw('koi_id, COUNT(*) as likes_count')
            ->groupBy('koi_id')
            ->get()
            ->keyBy('koi_id');

        // Hitung total bids dan ambil data pemenang jika ada
        $totalBids = Bid::whereIn('koi_id', $kois->pluck('id'))
            ->selectRaw('koi_id, COUNT(*) as total_bids, MAX(amount) as latest_bid')
            ->groupBy('koi_id')
            ->get()
            ->keyBy('koi_id');

        // Ambil data pemenang dari transaction_items (karena sudah pasti ada setelah menang)
        $winners = TransactionItem::whereIn('koi_id', $kois->pluck('id'))
            ->whereNotNull('transaction_id') // Pastikan sudah masuk transaksi
            ->with('transaction.user') // Ambil nama user pemenang
            ->get()
            ->keyBy('koi_id');

        // Tambahkan informasi pemenang ke dalam totalBids
        foreach ($kois as $koi) {
            $koiId = $koi->id;
            $koi->total_bids = $totalBids[$koiId]->total_bids ?? 0;
            $koi->latest_bid = $totalBids[$koiId]->latest_bid ?? 0;

            // Cek apakah ada pemenang dari transaction_items
            if (isset($winners[$koiId])) {
                $koi->has_winner = true;
                $koi->winner_name = $winners[$koiId]->transaction->user->name ?? 'N/A';
            } else {
                $koi->has_winner = false;
                $koi->winner_name = null;
            }
        }


        // **Tambahkan data likes dan bids ke koleksi**
        foreach ($kois as $koi) {
            $koi->likes_count = $likes[$koi->id]->likes_count ?? 0;
            $koi->user_liked = UserActivity::where('koi_id', $koi->id)
                ->where('user_id', $userId)
                ->where('activity_type', 'like')
                ->exists();
        }

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
