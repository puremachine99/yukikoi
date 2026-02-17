<?php

namespace App\Filament\Resources\Items\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // tampilkan hanya item milik user yang login
            ->modifyQueryUsing(fn (Builder $query) => $query->where('owner_id', auth()->id()))
            ->defaultSort('created_at', 'desc')

            ->columns([
                // thumbnail dari media[0]
                ImageColumn::make('media_thumb')
                    ->label('')
                    ->getStateUsing(fn ($record) => is_array($record->media ?? null) ? ($record->media[0] ?? null) : null)
                    ->square(),

                TextColumn::make('title')
                    ->label('Title')
                    ->limit(40)
                    ->searchable()
                    ->wrap(),

                TextColumn::make('species.name')
                    ->label('Species')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('gender')
                    ->badge()
                    ->colors([
                        'primary' => fn (?string $state): bool => $state === 'male',
                        'pink' => fn (?string $state): bool => $state === 'female',
                        'gray' => fn (?string $state): bool => blank($state) || $state === 'unknown',
                    ])
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? ucfirst($state) : '-')
                    ->toggleable(),

                TextColumn::make('size_cm')
                    ->label('Size')
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? number_format((float) $state, 0, ',', '.') . ' cm' : '-')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('open_bid')
                    ->label('Open Bid')
                    ->numeric()
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? 'Rp ' . number_format((float) $state, 0, ',', '.') : '-')
                    ->sortable(),

                TextColumn::make('bid_step')
                    ->label('Bid Step')
                    ->numeric()
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? 'Rp ' . number_format((float) $state, 0, ',', '.') : '-')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('buy_now_price')
                    ->label('Buy Now')
                    ->numeric()
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? 'Rp ' . number_format((float) $state, 0, ',', '.') : '-')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => fn (?string $state): bool => $state === 'draft',
                        'success' => fn (?string $state): bool => $state === 'active',
                        'warning' => fn (?string $state): bool => $state === 'sold',
                        'danger' => fn (?string $state): bool => $state === 'archived',
                    ])
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? ucfirst($state) : '-')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                SelectFilter::make('species_id')
                    ->label('Species')
                    ->relationship('species', 'name')
                    ->preload()
                    ->searchable(),

                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Active',
                        'sold' => 'Sold',
                        'archived' => 'Archived',
                    ]),

                SelectFilter::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'unknown' => 'Unknown',
                    ]),

                // Size range
                Filter::make('size_range')
                    ->form([
                        \Filament\Forms\Components\TextInput::make('min')->label('Min (cm)')->numeric(),
                        \Filament\Forms\Components\TextInput::make('max')->label('Max (cm)')->numeric(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['min'] ?? null, fn (Builder $builder, $min) => $builder->where('size_cm', '>=', $min))
                            ->when($data['max'] ?? null, fn (Builder $builder, $max) => $builder->where('size_cm', '<=', $max));
                    }),

                // Price (Open Bid) range
                Filter::make('open_bid_range')
                    ->label('Open Bid Range')
                    ->form([
                        \Filament\Forms\Components\TextInput::make('min')->label('Min (Rp)')->numeric(),
                        \Filament\Forms\Components\TextInput::make('max')->label('Max (Rp)')->numeric(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['min'] ?? null, fn (Builder $builder, $min) => $builder->where('open_bid', '>=', $min))
                            ->when($data['max'] ?? null, fn (Builder $builder, $max) => $builder->where('open_bid', '<=', $max));
                    }),
            ])

            ->recordActions([
                EditAction::make(),
                // (nanti) Action "Lelangkan" kita tambahkan di langkah berikut
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
