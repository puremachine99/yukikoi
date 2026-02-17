<?php

namespace App\Filament\Resources\FishSpecies\Pages;

use App\Filament\Resources\FishSpecies\FishSpeciesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFishSpecies extends ListRecords
{
    protected static string $resource = FishSpeciesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
