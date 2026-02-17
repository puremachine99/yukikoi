<?php

namespace App\Filament\Resources\Auctions\Schemas;

use App\Filament\Resources\Auctions\AuctionResource;
use App\Models\Auction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class AuctionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Lelang')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Lelang')
                            ->required()
                            ->maxLength(150),
                        Placeholder::make('type_info')
                            ->label('Mode Lelang')
                            ->content('Mode akan dipilih otomatis berdasarkan jumlah koi yang masuk ke lelang.'),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(4)
                            ->columnSpanFull(),
                        DateTimePicker::make('start_at')
                            ->label('Waktu Mulai')
                            ->seconds(false)
                            ->required()
                            ->timezone(config('app.timezone')),
                        DateTimePicker::make('end_at')
                            ->label('Waktu Selesai')
                            ->seconds(false)
                            ->required()
                            ->rule('after:start_at')
                            ->timezone(config('app.timezone')),
                        Placeholder::make('status_placeholder')
                            ->label('Status')
                            ->content(function (?Auction $record): string {
                                if (! $record) {
                                    return 'Status akan ditentukan otomatis dari jadwal.';
                                }

                                $status = AuctionResource::determineStatus(
                                    optional($record->start_at)?->toDateTimeString(),
                                    optional($record->end_at)?->toDateTimeString(),
                                    $record->status,
                                );

                                return ucfirst($status);
                            }),
                    ]),

                Section::make('Pengaturan')
                    ->columns(3)
                    ->schema([
                        TextInput::make('anti_snipe_window_sec')
                            ->label('Anti Snipe (detik)')
                            ->numeric()
                            ->minValue(0)
                            ->default(60)
                            ->required(),
                        TextInput::make('extend_step_sec')
                            ->label('Extend Step (detik)')
                            ->numeric()
                            ->minValue(0)
                            ->default(30)
                            ->required(),
                        TextInput::make('buy_now_price')
                            ->label('Buy Now (opsional)')
                            ->numeric()
                            ->minValue(0)
                            ->prefix('Rp'),
                    ]),

                Section::make('Lots & Koi')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('lots')
                            ->relationship()
                            ->label('Daftar Lot')
                            ->minItems(1)
                            ->defaultItems(1)
                            ->collapsed(false)
                            ->columns(2)
                            ->createItemButtonLabel('Tambah Lot')
                            ->schema([
                                TextInput::make('lot_code')
                                    ->label('Kode Lot')
                                    ->required()
                                    ->maxLength(20),
                                TextInput::make('title')
                                    ->label('Judul Lot')
                                    ->required()
                                    ->maxLength(150),
                                TextInput::make('open_bid')
                                    ->label('Open Bid')
                                    ->numeric()
                                    ->minValue(0)
                                    ->prefix('Rp')
                                    ->required(),
                                TextInput::make('min_step')
                                    ->label('Bid Step Minimal')
                                    ->numeric()
                                    ->minValue(0)
                                    ->prefix('Rp')
                                    ->required(),
                                TextInput::make('buy_now_price')
                                    ->label('Buy Now Lot')
                                    ->numeric()
                                    ->minValue(0)
                                    ->prefix('Rp')
                                    ->columnSpan(1),
                                Select::make('items')
                                    ->label('Koi di Lot ini')
                                    ->relationship(
                                        name: 'items',
                                        titleAttribute: 'title',
                                        modifyQueryUsing: function (Builder $query, $record): void {
                                            $currentAuctionId = null;

                                            if ($record instanceof \App\Models\Auction) {
                                                $currentAuctionId = $record->getKey();
                                            }

                                            if ($record instanceof \App\Models\AuctionLot) {
                                                $currentAuctionId = $record->auction_id ?? optional($record->auction)->getKey();
                                            }

                                            $query
                                                ->where('owner_id', auth()->id())
                                                ->whereRaw("media IS NOT NULL AND jsonb_typeof(media) = 'array' AND jsonb_array_length(media) > 0")
                                                ->where(function (Builder $query) use ($currentAuctionId): void {
                                                    $query->whereDoesntHave('lots.auction', function (Builder $auctionQuery) use ($currentAuctionId): void {
                                                        $auctionQuery->whereIn('status', ['draft', 'scheduled', 'live']);

                                                        if ($currentAuctionId) {
                                                            $auctionQuery->whereKeyNot($currentAuctionId);
                                                        }
                                                    });

                                                    if ($currentAuctionId) {
                                                        $query->orWhereHas('lots', function (Builder $lotQuery) use ($currentAuctionId): void {
                                                            $lotQuery->where('auction_id', $currentAuctionId);
                                                        });
                                                    }
                                                });
                                        }
                                    )
                                    ->multiple()
                                    ->preload()
                                    ->searchable()
                                    ->minItems(1)
                                    ->helperText('Pilih koi (items) yang akan dilelang dalam lot ini. Hanya koi dengan foto dan belum terlibat lelang aktif yang tersedia.'),
                            ]),
                    ]),
            ]);
    }
}
