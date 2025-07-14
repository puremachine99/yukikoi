<?php

namespace App\Filament\Control\Resources;

use App\Models\Koi;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Control\Resources\KoiResource\Pages;
use App\Filament\Control\Resources\KoiResource\RelationManagers;

class KoiResource extends Resource
{
    protected static ?string $model = Koi::class;
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('auction', function ($query) {
                $query->where('user_id', Auth::id());
            });
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereHas('auction', function ($query) {
            $query->where('user_id', Auth::id());
        })->count();
    }
    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Jumlah Koi';
    }
    protected static ?string $navigationGroup = 'Seller';
    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('auction_code')
                    ->label('Lelang')
                    ->options(function () {
                        return \App\Models\Auction::where('user_id', Auth::id())
                            ->pluck('title', 'auction_code')
                            ->map(function ($title, $code) {
                                return "{$code} - {$title}";
                            });
                    })
                    ->searchable()
                    ->required(),

                TextInput::make('kode_ikan')
                    ->required()
                    ->maxLength(255),

                TextInput::make('judul')
                    ->label('Judul Ikan')
                    ->maxLength(255),

                TextInput::make('jenis_koi')
                    ->label('Jenis Koi')
                    ->required(),

                TextInput::make('ukuran')
                    ->numeric()
                    ->required(),

                Select::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'unchecked' => 'Unchecked',
                    ])
                    ->required(),

                TextInput::make('open_bid')
                    ->numeric()
                    ->required(),

                TextInput::make('kelipatan_bid')
                    ->numeric()
                    ->required(),

                TextInput::make('buy_it_now')
                    ->numeric()
                    ->label('Buy It Now (Optional)')
                    ->nullable(),

                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->nullable(),

                TextInput::make('breeder')
                    ->label('Breeder')
                    ->nullable()
                    ->maxLength(255),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('judul')
                    ->label('Judul')
                    ->limit(30)
                    ->searchable(),
                TextColumn::make('auction.auction_code')
                    ->label('Kode Lelang')
                    ->sortable(),

                TextColumn::make('auction.title')
                    ->label('Judul Lelang')
                    ->limit(30),
                TextColumn::make('kode_ikan')
                    ->label('Kode Ikan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jenis_koi')
                    ->label('Jenis Koi')
                    ->sortable(),

                BadgeColumn::make('gender')
                    ->colors([
                        'primary' => 'unchecked',
                        'info' => 'male',
                        'warning' => 'female',
                    ])
                    ->label('Gender'),

                TextColumn::make('ukuran')
                    ->label('Size (cm)')
                    ->sortable(),

                TextColumn::make('open_bid')
                    ->label('OB')
                    ->money('IDR', true),

                TextColumn::make('kelipatan_bid')
                    ->label('KB')
                    ->money('IDR', true),

                TextColumn::make('buy_it_now')
                    ->label('BIN')
                    ->money('IDR', true)
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if (
                                    $record->auction &&
                                    in_array($record->auction->status, ['on going', 'ready'])
                                ) {
                                    throw new \Exception("Beberapa koi tidak dapat dihapus karena sedang dalam lelang aktif.");
                                }
                            }
                        }),
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
            'index' => Pages\ListKois::route('/'),
            'create' => Pages\CreateKoi::route('/create'),
            'edit' => Pages\EditKoi::route('/{record}/edit'),
        ];
    }
}
