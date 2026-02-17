<?php

namespace App\Filament\Resources\Seller;

use App\Filament\Resources\Seller\SellerOrderResource\Pages;
use App\Models\Order;
use BackedEnum;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use UnitEnum;

class SellerOrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static string|UnitEnum|null $navigationGroup = 'Seller';

    protected static ?string $navigationLabel = 'Pesanan Masuk';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canForceDelete($record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                TextColumn::make('id')
                    ->label('Order')
                    ->formatStateUsing(fn (string $state): string => Str::upper(Str::substr($state, 0, 8)))
                    ->searchable(),
                TextColumn::make('buyer.profile.display_name')
                    ->label('Pembeli')
                    ->state(fn (Order $record): string => $record->buyer?->profile?->display_name ?? $record->buyer?->name ?? '—')
                    ->searchable(['buyer.name', 'buyer.profile.display_name']),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'pending_payment' => 'warning',
                        'paid' => 'success',
                        'shipped' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    ])
                    ->formatStateUsing(fn (string $state): string => self::statusLabel($state)),
                TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR')
                    ->alignRight(),
                TextColumn::make('expires_at')
                    ->label('Batas Bayar')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Update Terakhir')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(self::statusOptions()),
                Filter::make('needs_shipment')
                    ->label('Perlu Dikirim')
                    ->query(fn (Builder $query): Builder => $query->whereIn('status', ['paid']))
                    ->indicator('Perlu dikirim'),
            ])
            ->actions([
                ViewAction::make()
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Detail Pesanan')
                    ->modalWidth('4xl')
                    ->infolist(fn (Infolist $infolist) => $infolist->schema(self::infolistSchema()))
                    ->modalSubmitAction(false),
            ])
            ->bulkActions([])
            ->recordUrl(fn (Order $record): string => static::getUrl('view', ['record' => $record]));
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('seller_id', auth()->id())
            ->with(['buyer.profile', 'items.item', 'payments']);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema(self::infolistSchema());
    }

    protected static function infolistSchema(): array
    {
        return [
            Section::make('Ringkasan Pesanan')
                ->columns(3)
                ->schema([
                    TextEntry::make('id')
                        ->label('Order')
                        ->formatStateUsing(fn (string $state): string => Str::upper(Str::substr($state, 0, 8))),
                    TextEntry::make('status')
                        ->label('Status')
                        ->badge()
                        ->color(fn (string $state): string => self::statusColor($state))
                        ->formatStateUsing(fn (string $state): string => self::statusLabel($state)),
                    TextEntry::make('buyer.profile.display_name')
                        ->label('Pembeli')
                        ->formatStateUsing(fn ($state, Order $record): string => $record->buyer?->profile?->display_name ?? $record->buyer?->name ?? '—'),
                    Grid::make(3)
                        ->schema([
                            TextEntry::make('subtotal')->label('Subtotal')->money('IDR'),
                            TextEntry::make('fee_total')->label('Biaya Platform')->money('IDR'),
                            TextEntry::make('total')->label('Total Tagihan')->money('IDR'),
                        ])
                        ->columnSpan(3),
                    TextEntry::make('created_at')
                        ->label('Tanggal Order')
                        ->dateTime('d M Y H:i'),
                    TextEntry::make('expires_at')
                        ->label('Batas Pembayaran')
                        ->dateTime('d M Y H:i')
                        ->visible(fn (Order $record): bool => filled($record->expires_at)),
                ]),
            Section::make('Item Lelang')
                ->schema([
                    RepeatableEntry::make('items')
                        ->columns(3)
                        ->schema([
                            TextEntry::make('item.title')->label('Koi'),
                            TextEntry::make('qty')->label('Qty'),
                            TextEntry::make('price')->label('Harga')->money('IDR'),
                            TextEntry::make('fee')->label('Fee')->money('IDR'),
                        ]),
                ])
                ->visible(fn (Order $record): bool => $record->items->isNotEmpty()),
            Section::make('Pembayaran')
                ->schema([
                    RepeatableEntry::make('payments')
                        ->columns(3)
                        ->schema([
                            TextEntry::make('method')->label('Metode'),
                            TextEntry::make('status')
                                ->label('Status')
                                ->badge()
                                ->color(fn (?string $state): string => match ($state) {
                                    'paid', 'settled' => 'success',
                                    'pending' => 'warning',
                                    'failed', 'cancelled' => 'danger',
                                    default => 'gray',
                                })
                                ->formatStateUsing(fn (?string $state): string => $state ? Str::of($state)->replace('_', ' ')->title() : 'Tidak diketahui'),
                            TextEntry::make('amount')->label('Nominal')->money('IDR'),
                            TextEntry::make('paid_at')
                                ->label('Dibayar Pada')
                                ->dateTime('d M Y H:i')
                                ->columnSpan(3),
                        ]),
                ])
                ->visible(fn (Order $record): bool => $record->payments->isNotEmpty()),
        ];
    }

    protected static function statusOptions(): array
    {
        return [
            'pending_payment' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Dibayar',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
    }

    protected static function statusColor(string $status): string
    {
        return match ($status) {
            'pending_payment' => 'warning',
            'paid' => 'success',
            'shipped' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'gray',
        };
    }

    protected static function statusLabel(string $status): string
    {
        return self::statusOptions()[$status] ?? Str::of($status)->replace('_', ' ')->title();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSellerOrders::route('/'),
            'view' => Pages\ViewSellerOrder::route('/{record}'),
        ];
    }
}

