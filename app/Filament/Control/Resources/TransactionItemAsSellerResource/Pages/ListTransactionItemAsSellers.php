<?php

namespace App\Filament\Control\Resources\TransactionItemAsSellerResource\Pages;

use App\Filament\Control\Resources\TransactionItemAsSellerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactionItemAsSellers extends ListRecords
{
    protected static string $resource = TransactionItemAsSellerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
