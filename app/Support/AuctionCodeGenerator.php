<?php

namespace App\Support;

use App\Models\AuctionCounter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuctionCodeGenerator
{
    public function generate(string $jenis): string
    {
        $prefix = match ($jenis) {
            'azukari' => 'AZ',
            'keeping_contest' => 'KC',
            'grow_out' => 'GO',
            default => 'RG',
        };

        return DB::transaction(function () use ($prefix) {
            $now = now();
            $year = $now->format('y');
            $month = $now->format('m');

            $counter = AuctionCounter::lockForUpdate()
                ->firstOrNew(
                    [
                        'prefix' => $prefix,
                        'year' => $year,
                        'month' => $month,
                    ],
                    [
                        'sequence' => 0,
                    ]
                );

            $counter->sequence++;
            $counter->save();

            return sprintf(
                '%s%s%s%s',
                $prefix,
                $year,
                $month,
                str_pad((string) $counter->sequence, 3, '0', STR_PAD_LEFT)
            );
        });
    }
}
