<?php

namespace App\Filament\Control\Resources\TransactionItemAsSellerResource\Pages;

use App\Filament\Control\Resources\TransactionItemAsSellerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransactionItemAsSeller extends EditRecord
{
    protected static string $resource = TransactionItemAsSellerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
