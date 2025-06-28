<?php

namespace App\Filament\Resources;

use App\Models\Bid;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BidResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BidResource\RelationManagers;

class BidResource extends Resource
{
    protected static ?string $navigationGroup = 'Manajemen Lelang';
    protected static ?string $navigationIcon = 'heroicon-o-bolt';
    protected static ?string $navigationLabel = 'History Bid';
    protected static ?string $pluralModelLabel = 'History Bids';
    protected static ?string $modelLabel = 'History Bid';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
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
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('user.name')->label('User')->searchable(),
                TextColumn::make('koi_id')->label('Koi ID')->searchable(),
                TextColumn::make('amount')->money('IDR')->sortable(),
                IconColumn::make('is_win')->boolean()->label('Win'),
                IconColumn::make('is_bin')->boolean()->label('BIN'),
                IconColumn::make('is_sniping')->boolean()->label('Sniping'),
                TextColumn::make('created_at')->dateTime('d M Y H:i')->label('Bid Time')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListBids::route('/'),
            'create' => Pages\CreateBid::route('/create'),
            'edit' => Pages\EditBid::route('/{record}/edit'),
        ];
    }
}
