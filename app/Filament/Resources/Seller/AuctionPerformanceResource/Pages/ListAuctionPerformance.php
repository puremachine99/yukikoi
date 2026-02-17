<?php

namespace App\Filament\Resources\Seller\AuctionPerformanceResource\Pages;

use App\Filament\Resources\Seller\AuctionPerformanceResource;
use Filament\Resources\Pages\ListRecords;

class ListAuctionPerformance extends ListRecords
{
    protected static string $resource = AuctionPerformanceResource::class;

    protected static ?string $title = 'Performa Lelang';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
