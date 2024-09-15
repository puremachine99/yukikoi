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
    $auctions = Auction::all();  // Ambil semua lelang dari database
    
    foreach ($auctions as $auction) {
        UpdateAuctionStatus::dispatch($auction->auction_code);  // Dispatch job untuk setiap auction
    }
})->everyMinute();