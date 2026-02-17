<?php

namespace App\Filament\Resources\Seller\SellerOrderResource\Pages;

use App\Filament\Resources\Seller\SellerOrderResource;
use Filament\Resources\Pages\ViewRecord;

class ViewSellerOrder extends ViewRecord
{
    protected static string $resource = SellerOrderResource::class;

    protected static ?string $title = 'Detail Pesanan';

    protected function getActions(): array
    {
        return [];
    }
}
