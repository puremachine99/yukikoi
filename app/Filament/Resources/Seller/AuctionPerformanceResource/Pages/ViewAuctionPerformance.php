<?php

namespace App\Filament\Resources\Seller\AuctionPerformanceResource\Pages;

use App\Filament\Resources\Seller\AuctionPerformanceResource;
use Filament\Resources\Pages\ViewRecord;

class ViewAuctionPerformance extends ViewRecord
{
    protected static string $resource = AuctionPerformanceResource::class;

    protected static ?string $title = 'Rekap Lelang';

    protected function getActions(): array
    {
        return [];
    }
}
