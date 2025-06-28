<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Auction;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AuctionResource\Pages;

class AuctionResource extends Resource
{
    protected static ?string $model = Auction::class;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Manajemen Lelang';
    protected static ?string $navigationLabel = 'Lelang';
    protected static ?string $slug = 'Lelang';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Lelang')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('jenis')
                            ->label('Jenis Lelang')
                            ->options([
                                'reguler' => 'Reguler',
                                'keeping contest' => 'Keeping Contest',
                                'grow out' => 'Grow Out',
                                'azukari' => 'Azukari',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'pending' => 'Pending',
                                'rejected' => 'Rejected',
                                'ready' => 'Ready',
                                'on going' => 'On Going',
                                'completed' => 'Completed',
                            ])
                            ->required()
                            ->native(false),
                    ]),

                Forms\Components\Section::make('Waktu Lelang')
                    ->schema([
                        Forms\Components\DateTimePicker::make('start_time')->label('Mulai')->required(),
                        Forms\Components\DateTimePicker::make('end_time')->label('Berakhir')->required(),
                        Forms\Components\TextInput::make('extra_time')->label('Tambahan Waktu (menit)')->numeric()->default(0),
                        Forms\Components\DateTimePicker::make('contest_time')->label('Waktu Kontes')->nullable(),
                    ]),

                Forms\Components\Section::make('Media & Relasi')
                    ->schema([
                        Forms\Components\FileUpload::make('banner')
                            ->label('Banner')
                            ->directory('banners/auctions')
                            ->image()
                            ->imageEditor(),

                        Forms\Components\Select::make('user_id')
                            ->label('Pemilik')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('auction_code')->label('Kode Lelang')->sortable()->searchable(),
                TextColumn::make('title')->label('Judul')->limit(30)->searchable(),
                TextColumn::make('user.name')->label('Dibuat oleh')->searchable(),

                TextColumn::make('user.latestBid.amount')
                    ->label('Bid Terakhir User')
                    ->money('IDR', true) // atau ->formatStateUsing(fn ($state) => 'Rp '.number_format($state))
                    ->sortable(),
                BadgeColumn::make('jenis')
                    ->colors([
                        'gray' => 'reguler',
                        'blue' => 'keeping contest',
                        'green' => 'grow out',
                        'purple' => 'azukari',
                    ])
                    ->label('Jenis'),

                BadgeColumn::make('status')
                    ->colors([
                        'gray' => 'draft',
                        'yellow' => 'pending',
                        'red' => 'rejected',
                        'green' => 'ready',
                        'blue' => 'on going',
                        'success' => 'completed',
                    ])
                    ->label('Status'),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuctions::route('/'),
            'create' => Pages\CreateAuction::route('/create'),
            'edit' => Pages\EditAuction::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['user'])
            ->withCount([
                'user as user_bids_count' => function ($query) {
                    $query->selectRaw('count(*)');
                }
            ]);
    }
}
