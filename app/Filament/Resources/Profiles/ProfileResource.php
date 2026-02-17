<?php

namespace App\Filament\Resources\Profiles;

use BackedEnum;
use UnitEnum;
use App\Filament\Resources\Profiles\Pages\CreateProfile;
use App\Filament\Resources\Profiles\Pages\EditProfile;
use App\Filament\Resources\Profiles\Pages\ListProfiles;
use App\Models\Profile;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Builder;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static ?string $navigationLabel = 'Profil Saya';

    protected static string | UnitEnum | null $navigationGroup = 'Pengaturan';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('username')
                ->label('Username')
                ->disabled()
                ->maxLength(50),
            TextInput::make('display_name')
                ->label('Nama Tampilan')
                ->maxLength(150),
            TextInput::make('farm_name')
                ->label('Nama Farm')
                ->maxLength(150),
            Textarea::make('address')
                ->label('Alamat')
                ->rows(3),
            Textarea::make('bio')
                ->label('Bio')
                ->rows(4),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('username')->label('Username'),
                TextColumn::make('display_name')->label('Nama'),
                TextColumn::make('farm_name')->label('Nama Farm'),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProfiles::route('/'),
            'create' => CreateProfile::route('/create'),
            'edit' => EditProfile::route('/{record}/edit'),
        ];
    }
}

