<?php

namespace App\Filament\Resources\Buyer;

use App\Filament\Resources\Buyer\OrderResource\Pages;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use UnitEnum;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingCart;

    protected static string|UnitEnum|null $navigationGroup = 'Buyer';

    protected static ?string $navigationLabel = 'Pesanan';

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
                TextColumn::make('seller.name')
                    ->label('Penjual')
                    ->searchable(),
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
                    ->label('Jatuh Tempo')
                    ->since()
                    ->sortable()
                    ->tooltip(fn (Order $record): ?string => $record->expires_at?->format('d M Y H:i')),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(self::statusOptions()),
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
            ->where('buyer_id', auth()->id())
            ->with(['seller', 'items.item', 'payments']);
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
                        ->label('Nomor Order')
                        ->formatStateUsing(fn (string $state): string => Str::upper(Str::substr($state, 0, 8))),
                    TextEntry::make('status')
                        ->label('Status')
                        ->badge()
                        ->color(fn (string $state): string => self::statusColor($state))
                        ->formatStateUsing(fn (string $state): string => self::statusLabel($state)),
                    TextEntry::make('seller.name')
                        ->label('Penjual'),
                    Grid::make(3)
                        ->schema([
                            TextEntry::make('subtotal')
                                ->label('Subtotal')
                                ->money('IDR')
                                ->columnSpan(1),
                            TextEntry::make('fee_total')
                                ->label('Biaya Platform')
                                ->money('IDR')
                                ->columnSpan(1),
                            TextEntry::make('total')
                                ->label('Total Dibayar')
                                ->money('IDR')
                                ->columnSpan(1),
                        ])
                        ->columnSpan(3),
                    TextEntry::make('created_at')
                        ->label('Dibuat Pada')
                        ->dateTime('d M Y H:i'),
                    TextEntry::make('expires_at')
                        ->label('Batas Pembayaran')
                        ->formatStateUsing(fn ($state, Order $record): string => $record->expires_at?->format('d M Y H:i') ?? '—'),
                ]),
            Section::make('Item Pesanan')
                ->schema([
                    RepeatableEntry::make('items')
                        ->columns(3)
                        ->schema([
                            TextEntry::make('item.title')
                                ->label('Koi'),
                            TextEntry::make('qty')
                                ->label('Qty'),
                            TextEntry::make('price')
                                ->label('Harga')
                                ->money('IDR'),
                            TextEntry::make('fee')
                                ->label('Fee')
                                ->money('IDR'),
                        ]),
                ])
                ->visible(fn (Order $record): bool => $record->relationLoaded('items') && $record->items->isNotEmpty()),
            Section::make('Pembayaran')
                ->schema([
                    RepeatableEntry::make('payments')
                        ->columns(3)
                        ->schema([
                            TextEntry::make('method')
                                ->label('Metode'),
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
                            TextEntry::make('amount')
                                ->label('Nominal')
                                ->money('IDR'),
                            TextEntry::make('paid_at')
                                ->label('Dibayar Pada')
                                ->dateTime('d M Y H:i')
                                ->columnSpan(3),
                        ]),
                ])
                ->visible(fn (Order $record): bool => $record->relationLoaded('payments') && $record->payments->isNotEmpty()),
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
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}

