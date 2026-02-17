<?php

namespace App\Filament\Resources\Buyer\OrderResource\Pages;

use App\Filament\Resources\Buyer\OrderResource;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected static ?string $title = 'Pesanan Saya';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
