<?php

namespace App\Filament\Resources\Buyer\InvoiceResource\Pages;

use App\Filament\Resources\Buyer\InvoiceResource;
use Filament\Resources\Pages\ListRecords;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;

    protected static ?string $title = 'Tagihan';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
