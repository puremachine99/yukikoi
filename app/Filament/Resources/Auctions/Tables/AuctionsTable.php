<?php

namespace App\Filament\Resources\Auctions\Tables;

use App\Filament\Resources\Auctions\AuctionResource;
use App\Models\Auction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AuctionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withCount('lots'))
            ->defaultSort('start_at', 'desc')
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->wrap()
                    ->weight('semi-bold'),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => fn (?string $state, Auction $record): bool => AuctionResource::determineStatus(
                            optional($record->start_at)?->toDateTimeString(),
                            optional($record->end_at)?->toDateTimeString(),
                            $state,
                        ) === 'live',
                        'warning' => fn (?string $state, Auction $record): bool => AuctionResource::determineStatus(
                            optional($record->start_at)?->toDateTimeString(),
                            optional($record->end_at)?->toDateTimeString(),
                            $state,
                        ) === 'scheduled',
                        'danger' => fn (?string $state, Auction $record): bool => AuctionResource::determineStatus(
                            optional($record->start_at)?->toDateTimeString(),
                            optional($record->end_at)?->toDateTimeString(),
                            $state,
                        ) === 'completed',
                        'gray' => fn (?string $state, Auction $record): bool => AuctionResource::determineStatus(
                            optional($record->start_at)?->toDateTimeString(),
                            optional($record->end_at)?->toDateTimeString(),
                            $state,
                        ) === 'draft',
                    ])
                    ->formatStateUsing(fn (?string $state, Auction $record): string => ucfirst(AuctionResource::determineStatus(
                        optional($record->start_at)?->toDateTimeString(),
                        optional($record->end_at)?->toDateTimeString(),
                        $state,
                    )))
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? ucfirst($state) : '-')
                    ->sortable(),
                TextColumn::make('start_at')
                    ->label('Mulai')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                TextColumn::make('end_at')
                    ->label('Selesai')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                TextColumn::make('duration')
                    ->label('Durasi')
                    ->state(fn (Auction $record): string => ($record->start_at && $record->end_at)
                        ? $record->start_at->diffForHumans($record->end_at, true)
                        : '-')
                    ->toggleable(),
                TextColumn::make('lots_count')
                    ->label('Jumlah Lot')
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                TextColumn::make('buy_now_price')
                    ->label('Buy Now')
                    ->numeric()
                    ->formatStateUsing(fn (?string $state): string => filled($state)
                        ? 'Rp ' . number_format((float) $state, 0, ',', '.')
                        : '-')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'scheduled' => 'Scheduled',
                        'live' => 'Live',
                        'completed' => 'Completed',
                    ]),
                SelectFilter::make('type')
                    ->label('Tipe')
                    ->options([
                        'single' => 'Single Lot',
                        'multi' => 'Multi Lot',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
