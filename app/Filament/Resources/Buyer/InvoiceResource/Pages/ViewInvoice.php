<?php

namespace App\Filament\Resources\Buyer\InvoiceResource\Pages;

use App\Filament\Resources\Buyer\InvoiceResource;
use Filament\Resources\Pages\ViewRecord;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    protected static ?string $title = 'Detail Tagihan';

    protected function getActions(): array
    {
        return [];
    }
}
