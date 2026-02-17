<?php

namespace App\Filament\Resources\Auctions\Pages;

use App\Filament\Resources\Auctions\AuctionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAuction extends CreateRecord
{
    protected static string $resource = AuctionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['seller_id'] = auth()->id();
        $data['type'] = AuctionResource::determineType($data['lots'] ?? []);
        $data['status'] = AuctionResource::determineStatus($data['start_at'] ?? null, $data['end_at'] ?? null);

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
