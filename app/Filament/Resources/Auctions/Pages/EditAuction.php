<?php

namespace App\Filament\Resources\Auctions\Pages;

use App\Filament\Resources\Auctions\AuctionResource;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditAuction extends EditRecord
{
    protected static string $resource = AuctionResource::class;

    public function mount(string|int $record): void
    {
        parent::mount($record);

        if ($this->record->status === 'live') {
            Notification::make()
                ->title('Lelang sedang live')
                ->warning()
                ->body('Lelang yang sudah live tidak bisa diedit.')
                ->send();

            $this->redirect(static::getResource()::getUrl('index'));
        }
    }


    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($this->record->status === 'live') {
            abort(403, 'Lelang yang sudah live tidak dapat diubah.');
        }

        $data['type'] = AuctionResource::determineType($data['lots'] ?? []);
        $data['status'] = AuctionResource::determineStatus($data['start_at'] ?? null, $data['end_at'] ?? null, $this->record->status);

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
