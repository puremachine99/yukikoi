<?php

namespace App\Observers;

use App\Models\Ad;
use App\Support\CacheKeys;
use Illuminate\Support\Facades\Cache;

class AdObserver
{
    public function saved(Ad $ad): void
    {
        $this->flushHomeCache();
    }

    public function deleted(Ad $ad): void
    {
        $this->flushHomeCache();
    }

    public function restored(Ad $ad): void
    {
        $this->flushHomeCache();
    }

    private function flushHomeCache(): void
    {
        Cache::forget(CacheKeys::HOME_CAROUSEL_ADS);
    }
}
