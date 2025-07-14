<?php

namespace App\Filament\Control\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use App\Models\TransactionItem;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Control\Resources\TransactionItemAsSellerResource\Pages;
use App\Filament\Control\Resources\TransactionItemAsSellerResource\RelationManagers;

class TransactionItemAsSellerResource extends Resource
{
    protected static ?string $model = TransactionItem::class;
    protected static ?string $navigationGroup = 'Seller';
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Pesanan Masuk';
    public static function canCreate(): bool
    {
        return false;
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('seller_id', Auth::id());
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('seller_id', Auth::id())->count();
    }
    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Jumlah Koi Harus dikirim';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('transaction.id')->label('ID Transaksi'),
                TextColumn::make('koi_id')->label('Kode Koi')->searchable(),
                TextColumn::make('buyer_id')->label('ID Buyer'),
                TextColumn::make('price')->money('IDR', true)->label('Harga'),
                TextColumn::make('shipping_fee')->money('IDR', true)->label('Ongkir'),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'secondary' => 'menunggu konfirmasi',
                        'warning' => 'karantina',
                        'info' => 'siap dikirim',
                        'primary' => 'dikirim',
                        'danger' => 'dibatalkan',
                        'gray' => 'proses pengajuan komplain',
                        'success' => 'selesai',
                    ]),
                TextColumn::make('created_at')->dateTime('d M Y')->label('Dibuat'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // tambahin modal details
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactionItemAsSellers::route('/'),
        ];
    }
}
