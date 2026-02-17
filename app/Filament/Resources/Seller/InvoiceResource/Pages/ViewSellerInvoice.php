<?php

namespace App\Filament\Resources\Seller\InvoiceResource\Pages;

use App\Filament\Resources\Seller\InvoiceResource;
use Filament\Resources\Pages\ViewRecord;

class ViewSellerInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    protected static ?string $title = 'Detail Tagihan';

    protected function getActions(): array
    {
        return [];
    }
}
