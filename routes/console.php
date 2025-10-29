<?php

use App\Models\Auction;
use App\Jobs\UpdateAuctionStatus;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

 
Schedule::call(function () {
    Auction::query()
        ->whereIn('status', ['ready', 'on going'])
        ->each(function (Auction $auction) {
            UpdateAuctionStatus::dispatch($auction->auction_code);
        });
})->everyMinute();
