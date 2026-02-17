<?php

namespace App\Filament\Widgets;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AuctionOperationsOverview extends BaseWidget
{
    protected ?string $heading = 'Kinerja Operasional Lelang';

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $now = now();
        $upcomingThreshold = $now->copy()->addDay();
        $gmvHorizon = $now->copy()->subDays(30);
        $recentBidHorizon = $now->copy()->subDays(7);
        $recentParticipantHorizon = $now->copy()->subDay();

        $liveAuctions = Auction::query()
            ->where('start_at', '<=', $now)
            ->where(function ($query) use ($now) {
                $query
                    ->whereNull('end_at')
                    ->orWhere('end_at', '>', $now);
            })
            ->count();

        $upcomingAuctions = Auction::query()
            ->whereNotNull('start_at')
            ->whereBetween('start_at', [$now, $upcomingThreshold])
            ->count();

        $gmvLast30Days = (float) Order::query()
            ->whereIn('status', ['paid', 'shipped', 'completed'])
            ->where('created_at', '>=', $gmvHorizon)
            ->sum('total');

        $pendingPaymentExposure = (float) Order::query()
            ->where('status', 'pending_payment')
            ->sum('total');

        $recentBidCounts = Bid::query()
            ->where('created_at', '>=', $recentBidHorizon)
            ->selectRaw('lot_id, COUNT(*) as total')
            ->groupBy('lot_id')
            ->pluck('total');

        $averageBidDepth = $recentBidCounts->avg() ?? 0.0;

        $activeParticipants = Bid::query()
            ->where('created_at', '>=', $recentParticipantHorizon)
            ->distinct('user_id')
            ->count('user_id');

        $formatCurrency = static fn (float $value): string => 'Rp ' . number_format($value, 0, ',', '.');

        return [
            Stat::make('Lelang Live', (string) $liveAuctions)
                ->description('Sedang berlangsung saat ini')
                ->color($liveAuctions > 0 ? 'success' : 'gray'),
            Stat::make('Mulai 24 Jam Ke Depan', (string) $upcomingAuctions)
                ->description('Siap tayang dalam 24 jam')
                ->color($upcomingAuctions > 0 ? 'warning' : 'gray'),
            Stat::make('GMV 30 Hari', $formatCurrency($gmvLast30Days))
                ->description('Pesanan berstatus paid/shipped/completed')
                ->color($gmvLast30Days > 0 ? 'primary' : 'gray'),
            Stat::make('Eksposur Pending', $formatCurrency($pendingPaymentExposure))
                ->description('Order menunggu pembayaran')
                ->color($pendingPaymentExposure > 0 ? 'danger' : 'gray'),
            Stat::make('Rata-rata Bid / Lot (7H)', number_format($averageBidDepth, 1))
                ->description('Intensitas kompetisi 7 hari terakhir')
                ->color($averageBidDepth >= 3 ? 'success' : 'gray'),
            Stat::make('Peserta Aktif 24 Jam', (string) $activeParticipants)
                ->description('User unik yang mengajukan bid')
                ->color($activeParticipants > 0 ? 'primary' : 'gray'),
        ];
    }
}
