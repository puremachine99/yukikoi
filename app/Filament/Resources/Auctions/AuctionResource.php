<?php

namespace App\Filament\Resources\Auctions;

use App\Filament\Resources\Auctions\Pages\CreateAuction;
use App\Filament\Resources\Auctions\Pages\EditAuction;
use App\Filament\Resources\Auctions\Pages\ListAuctions;
use App\Filament\Resources\Auctions\Schemas\AuctionForm;
use App\Filament\Resources\Auctions\Tables\AuctionsTable;
use App\Models\Auction;
use BackedEnum;
use Carbon\Carbon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class AuctionResource extends Resource
{
    protected static ?string $model = Auction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static string|UnitEnum|null $navigationGroup = 'Seller';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationLabel = 'Lelang';

    public static function form(Schema $schema): Schema
    {
        return AuctionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AuctionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAuctions::route('/'),
            'create' => CreateAuction::route('/create'),
            'edit' => EditAuction::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('seller_id', auth()->id());
    }

    public static function determineStatus(?string $startAt, ?string $endAt, ?string $fallback = null): string
    {
        $now = now();
        $start = $startAt ? Carbon::parse($startAt) : null;
        $end = $endAt ? Carbon::parse($endAt) : null;

        if ($start && $end && $end->lessThanOrEqualTo($start)) {
            return 'draft';
        }

        if ($end && $end->lessThanOrEqualTo($now)) {
            return 'completed';
        }

        if ($start && $start->lessThanOrEqualTo($now) && (! $end || $end->greaterThan($now))) {
            return 'live';
        }

        if ($start && $start->greaterThan($now)) {
            return 'scheduled';
        }

        return $fallback ?? 'draft';
    }

    public static function determineType(array $lots): string
    {
        $itemIds = collect($lots)
            ->pluck('items')
            ->flatten()
            ->filter()
            ->unique();

        return $itemIds->count() <= 1 ? 'single' : 'multi';
    }
}
