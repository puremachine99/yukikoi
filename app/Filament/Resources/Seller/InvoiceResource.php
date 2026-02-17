<?php

namespace App\Filament\Resources\Seller;

use App\Filament\Resources\Seller\InvoiceResource\Pages;
use App\Models\Invoice;
use BackedEnum;
use Filament\Infolists\Components\Grid;
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

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocument;

    protected static string|UnitEnum|null $navigationGroup = 'Seller';

    protected static ?string $navigationLabel = 'Tagihan Platform';

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
                    ->label('No. Tagihan')
                    ->formatStateUsing(fn (string $state): string => Str::upper(Str::substr($state, 0, 8)))
                    ->searchable(),
                TextColumn::make('purpose')
                    ->label('Keperluan')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'pending' => 'warning',
                        'awaiting_payment' => 'warning',
                        'paid' => 'success',
                        'expired' => 'danger',
                        'cancelled' => 'danger',
                    ])
                    ->formatStateUsing(fn (string $state): string => self::statusLabel($state)),
                TextColumn::make('amount')
                    ->label('Total')
                    ->money('IDR')
                    ->alignRight(),
                TextColumn::make('expires_at')
                    ->label('Jatuh Tempo')
                    ->since()
                    ->sortable()
                    ->tooltip(fn (Invoice $record): ?string => $record->expires_at?->format('d M Y H:i')),
                TextColumn::make('paid_at')
                    ->label('Dibayar')
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
                    ->modalHeading('Detail Tagihan')
                    ->modalWidth('lg')
                    ->infolist(fn (Infolist $infolist) => $infolist->schema(self::infolistSchema()))
                    ->modalSubmitAction(false),
            ])
            ->bulkActions([])
            ->recordUrl(fn (Invoice $record): string => static::getUrl('view', ['record' => $record]));
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('payer_id', auth()->id());
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema(self::infolistSchema());
    }

    protected static function infolistSchema(): array
    {
        return [
            Section::make('Detail Tagihan')
                ->columns(1)
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('id')
                                ->label('Nomor Tagihan')
                                ->formatStateUsing(fn (string $state): string => Str::upper(Str::substr($state, 0, 12))),
                            TextEntry::make('status')
                                ->label('Status')
                                ->badge()
                                ->color(fn (string $state): string => self::statusColor($state))
                                ->formatStateUsing(fn (string $state): string => self::statusLabel($state)),
                            TextEntry::make('amount')
                                ->label('Jumlah')
                                ->money('IDR'),
                            TextEntry::make('currency')
                                ->label('Mata Uang'),
                            TextEntry::make('expires_at')
                                ->label('Jatuh Tempo')
                                ->dateTime('d M Y H:i'),
                            TextEntry::make('paid_at')
                                ->label('Dibayar Pada')
                                ->dateTime('d M Y H:i'),
                        ]),
                    TextEntry::make('purpose')
                        ->label('Keperluan')
                        ->wrap(),
                    TextEntry::make('gateway')
                        ->label('Gateway')
                        ->visible(fn (Invoice $record): bool => filled($record->gateway)),
                    TextEntry::make('external_ref')
                        ->label('Referensi Eksternal')
                        ->visible(fn (Invoice $record): bool => filled($record->external_ref)),
                    TextEntry::make('metadata')
                        ->label('Metadata')
                        ->json()
                        ->visible(fn (Invoice $record): bool => ! empty($record->metadata)),
                    TextEntry::make('created_at')
                        ->label('Dibuat Pada')
                        ->dateTime('d M Y H:i'),
                ]),
        ];
    }

    protected static function statusOptions(): array
    {
        return [
            'pending' => 'Menunggu Pembayaran',
            'awaiting_payment' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Dibayar',
            'expired' => 'Kedaluwarsa',
            'cancelled' => 'Dibatalkan',
        ];
    }

    protected static function statusColor(string $status): string
    {
        return match ($status) {
            'pending', 'awaiting_payment' => 'warning',
            'paid' => 'success',
            'expired', 'cancelled' => 'danger',
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
            'index' => Pages\ListSellerInvoices::route('/'),
            'view' => Pages\ViewSellerInvoice::route('/{record}'),
        ];
    }
}

