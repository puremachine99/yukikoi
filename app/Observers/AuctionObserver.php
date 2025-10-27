<?php

namespace App\Observers;

use App\Models\Auction;
use App\Support\CacheKeys;
use Illuminate\Support\Facades\Cache;

class AuctionObserver
{
    public function saved(Auction $auction): void
    {
        $this->flushHomeCache();
    }

    public function deleted(Auction $auction): void
    {
        $this->flushHomeCache();
    }

    public function restored(Auction $auction): void
    {
        $this->flushHomeCache();
    }

    private function flushHomeCache(): void
    {
        Cache::forget(CacheKeys::HOME_AUCTIONS);
    }
}
