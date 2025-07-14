<?php

namespace App\Filament\Control\Resources\AuctionsResource\Pages;

use App\Filament\Control\Resources\AuctionsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAuctions extends EditRecord
{
    protected static string $resource = AuctionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
