<?php

namespace App\Filament\Control\Resources\KoiResource\Pages;

use App\Filament\Control\Resources\KoiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKoi extends EditRecord
{
    protected static string $resource = KoiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
