<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Seller\InvoiceResource;
use App\Models\Invoice;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class UnpaidInvoicesTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Tagihan Belum Dibayar';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    private const STATUS_LABELS = [
        'pending' => 'Menunggu Pembayaran',
        'awaiting_payment' => 'Menunggu Pembayaran',
        'paid' => 'Sudah Dibayar',
        'expired' => 'Kedaluwarsa',
        'cancelled' => 'Dibatalkan',
    ];

    private const STATUS_COLORS = [
        'pending' => 'warning',
        'awaiting_payment' => 'warning',
        'paid' => 'success',
        'expired' => 'danger',
        'cancelled' => 'danger',
    ];

    protected function getTableQuery(): Builder
    {
        return Invoice::query()
            ->with(['payer', 'payer.profile'])
            ->whereIn('status', ['pending', 'awaiting_payment'])
            ->orderBy('expires_at')
            ->orderBy('created_at');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->formatStateUsing(fn (?string $state) => $state && strlen($state) > 8 ? substr($state, 0, 8) . '…' : ($state ?? '—'))
                    ->tooltip(fn (?string $state) => $state),
                TextColumn::make('payer.profile.display_name')
                    ->label('Pembayar')
                    ->formatStateUsing(fn ($state, Invoice $record) => $state ?? $record->payer?->name ?? '—')
                    ->tooltip(fn (Invoice $record) => $record->payer?->name),
                TextColumn::make('purpose')
                    ->label('Keperluan')
                    ->limit(40)
                    ->tooltip(fn (?string $state) => $state),
                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format((float) $state, 0, ',', '.'))
                    ->alignRight(),
                TextColumn::make('expires_at')
                    ->label('Jatuh Tempo')
                    ->dateTime('d M Y H:i')
                    ->since()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->state(fn (Invoice $record): string => $this->statusLabel($record->status))
                    ->color(fn (Invoice $record): string => $this->statusColor($record->status)),
            ])
            ->recordActions([
                Action::make('lihat')
                    ->label('Lihat')
                    ->color('primary')
                    ->url(fn (Invoice $record): string => InvoiceResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab(),
            ])
            ->emptyStateHeading('Semua tagihan telah dibayar')
            ->paginated([5, 10, 20])
            ->poll('90s');
    }

    private function statusLabel(?string $status): string
    {
        if ($status === null) {
            return 'Tidak diketahui';
        }

        return self::STATUS_LABELS[$status] ?? ucfirst(str_replace('_', ' ', $status));
    }

    private function statusColor(?string $status): string
    {
        return $status ? (self::STATUS_COLORS[$status] ?? 'gray') : 'gray';
    }
}
