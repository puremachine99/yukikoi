<?php

namespace App\Filament\Resources\FishSpecies;

use BackedEnum;
use UnitEnum;
use App\Filament\Resources\FishSpecies\Pages\CreateFishSpecies;
use App\Filament\Resources\FishSpecies\Pages\EditFishSpecies;
use App\Filament\Resources\FishSpecies\Pages\ListFishSpecies;
use App\Models\FishSpecies;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FishSpeciesResource extends Resource
{
    protected static ?string $model = FishSpecies::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedSwatch;
    protected static string | UnitEnum | null $navigationGroup = 'Master Data';

    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nama Spesies')
                ->required()
                ->maxLength(150),
            Textarea::make('description')
                ->label('Deskripsi')
                ->rows(4),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->wrap()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFishSpecies::route('/'),
            'create' => CreateFishSpecies::route('/create'),
            'edit' => EditFishSpecies::route('/{record}/edit'),
        ];
    }
}
