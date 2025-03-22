<?php
namespace App\Services;

use App\Models\Bid;
use App\Models\Rating;
use App\Models\Wishlist;
use App\Models\UserActivity;
use App\Models\TransactionItem;

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
            ->keyBy('koi_id');

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
            $koi->seller_avatar = $auction->user->avatar_url ?? null;
            $koi->seller_rating = $auction->user->rating ?? 0;

            $koi->photo_url = $koi->media->first()->url ?? null;
            $koi->status_lelang = $auction->status;
            $koi->end_time = $auction->end_time;

            $koi->total_bids = $bids[$koi->id]->total_bids ?? 0;
            $koi->last_bid = $bids[$koi->id]->last_bid ?? null;

            $koi->likes_count = $likes[$koi->id]->likes_count ?? 0;
            $koi->views_count = $views[$koi->id]->views_count ?? 0;

            $koi->user_liked = $userId ? in_array($koi->id, $wishlists) : false;
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
}
