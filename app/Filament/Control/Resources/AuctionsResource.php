<?php

namespace App\Filament\Control\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Auction;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Control\Resources\AuctionsResource\Pages;
use App\Filament\Control\Resources\AuctionsResource\RelationManagers;

class AuctionsResource extends Resource
{
    protected static ?string $model = Auction::class;
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('user_id', Auth::id())->count();
    }
    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Jumlah Lelang';
    }
    protected static ?string $navigationGroup = 'Seller';
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('auction_code')
                    ->label('Auction Code')
                    ->disabled()
                    ->dehydrated() // penting agar tetap dikirim walau disabled
                    ->required(),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->required(),

                Select::make('jenis')
                    ->options([
                        'reguler' => 'Reguler',
                        'keeping contest' => 'Keeping Contest',
                        'grow out' => 'Grow Out',
                        'azukari' => 'Azukari',
                    ])
                    ->required(),

                Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'pending' => 'Pending',
                        'rejected' => 'Rejected',
                        'ready' => 'Ready',
                        'on going' => 'On Going',
                        'completed' => 'Completed',
                    ])
                    ->required(),

                DateTimePicker::make('start_time')
                    ->required(),

                DateTimePicker::make('end_time')
                    ->required(),

                TextInput::make('extra_time')
                    ->numeric()
                    ->default(0)
                    ->required(),

                DateTimePicker::make('contest_time')
                    ->label('Contest Time')
                    ->nullable(),

                FileUpload::make('banner')
                    ->label('Banner')
                    ->image()
                    ->imageEditor()
                    ->directory('banners')
                    ->nullable(),

                // Optional, jika admin atau user panel setting user_id
                // Hidden jika auto dari auth user
                Hidden::make('user_id')
                    ->default(fn() => Auth::id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                TextColumn::make('auction_code')->sortable()->searchable(),
                TextColumn::make('title')->limit(20)->sortable()->searchable(),
                TextColumn::make('jenis')->badge(),
                BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'draft',
                        'warning' => 'pending',
                        'danger' => 'rejected',
                        'primary' => 'ready',
                        'info' => 'on going',
                        'success' => 'completed',
                    ]),
                TextColumn::make('start_time')->dateTime('d M Y H:i'),
                TextColumn::make('end_time')->dateTime('d M Y H:i'),
                TextColumn::make('extra_time')->label('Extra (min)'),
                TextColumn::make('user.name')->label('Seller')->sortable(),
                TextColumn::make('created_at')->dateTime('d M Y')->label('Created'),
            ])
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
            'index' => Pages\ListAuctions::route('/'),
            'create' => Pages\CreateAuctions::route('/create'),
            'edit' => Pages\EditAuctions::route('/{record}/edit'),
        ];
    }
}
