<?php

namespace App\Filament\Resources\Seller;

use App\Filament\Resources\Seller\AuctionPerformanceResource\Pages;
use App\Models\Auction;
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

class AuctionPerformanceResource extends Resource
{
    protected static ?string $model = Auction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|UnitEnum|null $navigationGroup = 'Seller';

    protected static ?string $navigationLabel = 'Performa Lelang';

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
                TextColumn::make('title')
                    ->label('Judul Lelang')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'draft' => 'gray',
                        'scheduled' => 'primary',
                        'live' => 'success',
                        'ended' => 'success',
                        'cancelled' => 'danger',
                    ])
                    ->formatStateUsing(fn (string $state): string => self::statusLabel($state)),
                TextColumn::make('lots_count')
                    ->label('Lot')
                    ->sortable(),
                TextColumn::make('bids_count')
                    ->label('Total Bid')
                    ->sortable(),
                TextColumn::make('paid_orders_count')
                    ->label('Order Dibayar')
                    ->sortable(),
                TextColumn::make('paid_orders_sum_total')
                    ->label('Omset Dibayar')
                    ->money('IDR')
                    ->alignRight(),
                TextColumn::make('start_at')
                    ->label('Mulai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('end_at')
                    ->label('Selesai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('start_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(self::statusOptions()),
            ])
            ->actions([
                ViewAction::make()
                    ->label('Detail')
                    ->icon('heroicon-o-chart-bar')
                    ->modalHeading('Rekap Lelang')
                    ->modalWidth('4xl')
                    ->infolist(fn (Infolist $infolist) => $infolist->schema(self::infolistSchema()))
                    ->modalSubmitAction(false),
            ])
            ->bulkActions([])
            ->recordUrl(fn (Auction $record): string => static::getUrl('view', ['record' => $record]));
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('seller_id', auth()->id())
            ->withCount([
                'lots',
                'bids',
                'orders as paid_orders_count' => fn (Builder $query) => $query->whereIn('status', ['paid', 'shipped', 'completed']),
            ])
            ->withSum([
                'orders as paid_orders_sum_total' => fn (Builder $query) => $query->whereIn('status', ['paid', 'shipped', 'completed']),
            ], 'total')
            ->with([
                'report',
                'orders' => fn (Builder $orderQuery) => $orderQuery
                    ->whereIn('status', ['paid', 'shipped', 'completed'])
                    ->with('buyer.profile'),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema(self::infolistSchema());
    }

    protected static function infolistSchema(): array
    {
        return [
            Section::make('Ikhtisar Lelang')
                ->columns(1)
                ->schema([
                    Grid::make(3)
                        ->schema([
                            TextEntry::make('title')->label('Judul'),
                            TextEntry::make('status')
                                ->label('Status')
                                ->badge()
                                ->color(fn (string $state): string => self::statusColor($state))
                                ->formatStateUsing(fn (string $state): string => self::statusLabel($state)),
                            TextEntry::make('lots_count')->label('Jumlah Lot'),
                            TextEntry::make('paid_orders_count')->label('Order Dibayar'),
                            TextEntry::make('bids_count')->label('Total Bid'),
                            TextEntry::make('paid_orders_sum_total')->label('Omset Dibayar')->money('IDR'),
                        ]),
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('start_at')->label('Mulai')->dateTime('d M Y H:i'),
                            TextEntry::make('end_at')->label('Selesai')->dateTime('d M Y H:i'),
                        ]),
                    TextEntry::make('description')
                        ->label('Deskripsi')
                        ->markdown()
                        ->visible(fn (Auction $record): bool => filled($record->description)),
                ]),
            Section::make('Rekap Laporan')
                ->columns(1)
                ->schema([
                    TextEntry::make('report.generated_at')
                        ->label('Diperbarui')
                        ->dateTime('d M Y H:i')
                        ->placeholder('Belum tersedia'),
                    TextEntry::make('report.stats')
                        ->label('Statistik')
                        ->json()
                        ->visible(fn (Auction $record): bool => filled($record->report?->stats)),
                ]),
            Section::make('Order Terkait')
                ->columns(1)
                ->schema([
                    RepeatableEntry::make('orders')
                        ->columns(3)
                        ->schema([
                            TextEntry::make('id')
                                ->label('Order')
                                ->formatStateUsing(fn ($state): string => Str::upper(Str::substr($state, 0, 8))),
                            TextEntry::make('buyer.profile.display_name')
                                ->label('Pembeli')
                                ->formatStateUsing(fn ($state, $record) => $record->buyer?->profile?->display_name ?? $record->buyer?->name ?? '—'),
                            TextEntry::make('status')
                                ->label('Status')
                                ->badge()
                                ->color(fn (string $state): string => self::orderStatusColor($state))
                                ->formatStateUsing(fn (string $state): string => self::orderStatusLabel($state)),
                            TextEntry::make('total')
                                ->label('Total')
                                ->money('IDR'),
                        ])
                        ->visible(fn (Auction $record): bool => $record->orders->isNotEmpty()),
                ]),
        ];
    }

    protected static function statusOptions(): array
    {
        return [
            'draft' => 'Draft',
            'scheduled' => 'Terjadwal',
            'live' => 'Sedang Berlangsung',
            'ended' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
    }

    protected static function statusColor(string $status): string
    {
        return match ($status) {
            'draft' => 'gray',
            'scheduled' => 'primary',
            'live' => 'success',
            'ended' => 'success',
            'cancelled' => 'danger',
            default => 'gray',
        };
    }

    protected static function statusLabel(string $status): string
    {
        return self::statusOptions()[$status] ?? Str::of($status)->replace('_', ' ')->title();
    }

    protected static function orderStatusColor(string $status): string
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

    protected static function orderStatusLabel(string $status): string
    {
        return [
            'pending_payment' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Dibayar',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ][$status] ?? Str::of($status)->replace('_', ' ')->title();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuctionPerformance::route('/'),
            'view' => Pages\ViewAuctionPerformance::route('/{record}'),
        ];
    }
}

