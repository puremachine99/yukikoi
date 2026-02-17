<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Auctions\AuctionResource;
use App\Models\Auction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LiveAuctionsTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Lelang Live & Mendatang';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        $now = now();
        $soon = $now->copy()->addDay();

        return Auction::query()
            ->withCount([
                'lots',
                'orders as paid_orders_count' => fn (Builder $query) => $query->whereIn('status', ['paid', 'shipped', 'completed']),
            ])
            ->where(function (Builder $query) use ($now, $soon) {
                $query
                    ->where(function (Builder $live) use ($now) {
                        $live
                            ->where('start_at', '<=', $now)
                            ->where(function (Builder $range) use ($now) {
                                $range
                                    ->whereNull('end_at')
                                    ->orWhere('end_at', '>', $now);
                            });
                    })
                    ->orWhere(function (Builder $upcoming) use ($now, $soon) {
                        $upcoming
                            ->whereNotNull('start_at')
                            ->whereBetween('start_at', [$now, $soon]);
                    });
            })
            ->orderByRaw('CASE WHEN start_at <= ? THEN 0 ELSE 1 END', [$now])
            ->orderBy('start_at');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->limit(40)
                    ->tooltip(fn (?string $state) => $state),
                TextColumn::make('seller.name')
                    ->label('Penjual')
                    ->placeholder('—'),
                TextColumn::make('start_at')
                    ->label('Mulai')
                    ->dateTime('d M Y H:i'),
                TextColumn::make('end_at')
                    ->label('Selesai')
                    ->dateTime('d M Y H:i')
                    ->placeholder('—'),
                TextColumn::make('status_badge')
                    ->label('Status')
                    ->badge()
                    ->state(fn (Auction $record): string => $this->determineStatus($record))
                    ->color(fn (Auction $record): string => match ($this->determineStatus($record)) {
                        'live' => 'success',
                        'scheduled' => 'warning',
                        'completed' => 'gray',
                        'draft' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('lots_count')
                    ->label('Lot')
                    ->alignRight(),
                TextColumn::make('paid_orders_count')
                    ->label('Pesanan Dibayar')
                    ->alignRight(),
            ])
            ->recordActions([
                Action::make('kelola')
                    ->label('Kelola')
                    ->color('primary')
                    ->url(fn (Auction $record): string => AuctionResource::getUrl('edit', ['record' => $record]))
                    ->openUrlInNewTab(),
            ])
            ->emptyStateHeading('Belum ada lelang live atau mendatang')
            ->paginated([5, 10, 20])
            ->poll('60s');
    }

    private function determineStatus(Auction $record): string
    {
        $start = $record->start_at?->toIso8601String();
        $end = $record->end_at?->toIso8601String();

        return AuctionResource::determineStatus($start, $end, $record->status);
    }
}
