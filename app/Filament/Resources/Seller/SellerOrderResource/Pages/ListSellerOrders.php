<?php

namespace App\Filament\Resources\Seller\SellerOrderResource\Pages;

use App\Filament\Resources\Seller\SellerOrderResource;
use Filament\Resources\Pages\ListRecords;

class ListSellerOrders extends ListRecords
{
    protected static string $resource = SellerOrderResource::class;

    protected static ?string $title = 'Pesanan Masuk';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
