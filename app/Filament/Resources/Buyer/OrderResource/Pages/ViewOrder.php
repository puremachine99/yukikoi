<?php

namespace App\Filament\Resources\Buyer\OrderResource\Pages;

use App\Filament\Resources\Buyer\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected static ?string $title = 'Detail Pesanan';

    protected function getActions(): array
    {
        return [];
    }
}
