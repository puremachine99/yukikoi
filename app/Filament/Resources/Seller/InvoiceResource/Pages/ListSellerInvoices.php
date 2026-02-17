<?php

namespace App\Filament\Resources\Seller\InvoiceResource\Pages;

use App\Filament\Resources\Seller\InvoiceResource;
use Filament\Resources\Pages\ListRecords;

class ListSellerInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;

    protected static ?string $title = 'Tagihan Platform';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
