<?php

namespace App\Filament\Resources\Items\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(150),
                // Species → dropdown (relasi ke tabel fish_species)
                Select::make('species_id')
                    ->label('Species')
                    ->relationship('species', 'name')
                    ->searchable()
                    ->preload(),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(4)
                    ->columnSpanFull(),

                // Gender → select simple
                Select::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'unknown' => 'Unknown',
                    ])
                    ->default('unknown')
                    ->required(),

                // Size (cm) → numeric
                TextInput::make('size_cm')
                    ->label('Size (cm)')
                    ->numeric()
                    ->minValue(1),

                TextInput::make('open_bid')
                    ->label('Open Bid')
                    ->numeric()
                    ->prefix('Rp'),

                TextInput::make('bid_step')
                    ->label('Bid Step')
                    ->numeric()
                    ->prefix('Rp'),

                TextInput::make('buy_now_price')
                    ->label('Buy Now Price')
                    ->numeric()
                    ->prefix('Rp'),

                // Upload foto/video
                FileUpload::make('media')
                    ->label('Media')
                    ->multiple()
                    ->image()
                    ->maxSize(2048)
                    ->directory('items/media'),

                // Status → select (lebih enak daripada text bebas)
                Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Active',
                        'sold' => 'Sold',
                        'archived' => 'Archived',
                    ])
                    ->default('draft')
                    ->required(),

                TextInput::make('sku')
                    ->label('SKU')
                    ->unique(ignoreRecord: true),
            ]);
    }
}
