<?php

namespace App\Filament\Control\Resources\KoiResource\Pages;

use App\Filament\Control\Resources\KoiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKois extends ListRecords
{
    protected static string $resource = KoiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
