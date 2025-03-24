<?php
namespace App\Services;

use App\Models\Bid;
use App\Models\Koi;
use App\Models\Wishlist;
use App\Models\UserActivity;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KoiEnricher
{
    public function enrichCollection($kois, $userId = null)
    {
        $koiIds = $kois->pluck('id');

        // Preload data
        $bids = Bid::whereIn('koi_id', $koiIds)
            ->selectRaw('koi_id, COUNT(*) as total_bids, MAX(amount) as last_bid')
            ->groupBy('koi_id')
            ->get()
            ->keyBy('koi_id');

        $likes = UserActivity::whereIn('koi_id', $koiIds)
            ->where('activity_type', 'like')
            ->selectRaw('koi_id, COUNT(*) as likes_count')
            ->groupBy('koi_id')
            ->get()
            ->keyBy(fn($item) => (string) $item->koi_id);

        $likesUserKoiIds = UserActivity::where('user_id', $userId)
            ->where('activity_type', 'like')
            ->whereIn('koi_id', $koiIds)
            ->pluck('koi_id')
            ->map(fn($id) => (string) $id)
            ->toArray();


        $views = UserActivity::whereIn('koi_id', $koiIds)
            ->where('activity_type', 'view')
            ->selectRaw('koi_id, COUNT(*) as views_count')
            ->groupBy('koi_id')
            ->get()
            ->keyBy('koi_id');

        $wishlists = $userId
            ? Wishlist::where('user_id', $userId)->whereIn('koi_id', $koiIds)->pluck('koi_id')->toArray()
            : [];

        $winners = TransactionItem::with('transaction.user')
            ->whereIn('koi_id', $koiIds)
            ->whereNotNull('transaction_id')
            ->get()
            ->keyBy('koi_id');


        foreach ($kois as $koi) {
            $auction = $koi->auction;

            $koi->seller_name = $auction->user->name ?? '-';
            $koi->farm_name = $auction->user->farm_name ?? '-';
            $koi->seller_city = $auction->user->city ?? '-';
            $koi->seller_avatar = $auction->user->profile_photo ?? null;


            $koi->photo_url = $koi->media->first()->url ?? null;
            $koi->status_lelang = $auction->status;
            $koi->end_time = $auction->end_time;

            $koiId = (string) $koi->id;
            $koi->total_bids = $bids[$koiId]->total_bids ?? 0;
            $koi->last_bid = $bids[$koiId]->last_bid ?? null;

            $koi->likes_count = $likes[$koi->id]->likes_count ?? 0;
            $koi->views_count = $views[$koi->id]->views_count ?? 0;

            $koi->user_liked = in_array($koiId, $likesUserKoiIds, true);
            $koi->wishlisted = $userId ? in_array($koi->id, $wishlists) : false;


            if (isset($winners[$koi->id])) {
                $koi->has_winner = true;
                $koi->winner_name = $winners[$koi->id]->transaction->user->name ?? null;
            } else {
                $koi->has_winner = false;
                $koi->winner_name = null;
            }
        }

        return $kois;
    }

    public function getLiveAuctionKois(Request $request, $userId)
    {
        $search = $request->input('q');
        $gender = $request->input('gender');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $userPreferences = $this->getUserPreferences($userId);

        $query = Koi::with([
            'auction.user',
            'media' => fn($q) => $q->where('media_type', 'photo'),
            'bids' => fn($q) => $q->latest()
        ])
            ->leftJoinSub($userPreferences, 'user_pref', function ($join) {
                $join->on('kois.id', '=', 'user_pref.koi_id');
            })
            ->whereHas('auction', fn($q) => $q->where('jenis', 'reguler')->where('status', 'on going'));

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%")
                    ->orWhere('jenis_koi', 'like', "%$search%");
            });
        }

        if ($gender)
            $query->where('gender', $gender);
        if ($minPrice)
            $query->where('open_bid', '>=', $minPrice);
        if ($maxPrice)
            $query->where('open_bid', '<=', $maxPrice);

        $kois = $query
            ->select('kois.*')
            ->orderByRaw('COALESCE(user_pref.weight, 0) DESC')
            ->orderByDesc('kois.created_at')
            ->get(); // ->paginate(30);


        return $this->enrichCollection($kois, $userId);
    }

    private function getUserPreferences($userId)
    {
        return DB::table('activities')
            ->selectRaw('
            koi_id,
            SUM(CASE WHEN activity_type = "view" THEN 1 ELSE 0 END) * 1 +
            SUM(CASE WHEN activity_type = "like" THEN 3 ELSE 0 END) * 3 +
            SUM(CASE WHEN activity_type = "bid" THEN 5 ELSE 0 END) * 5 AS weight
        ')
            ->where('user_id', $userId)
            ->groupBy('koi_id');
    }

    public function getAuctionKois($auction, $userId = null)
    {
        $kois = $auction->koi()
            ->with([
                'auction.user',
                'media' => fn($q) => $q->where('media_type', 'photo'),
                'bids' => fn($q) => $q->latest()
            ])
            ->get();

        return $this->enrichCollection($kois, $userId);
    }


}