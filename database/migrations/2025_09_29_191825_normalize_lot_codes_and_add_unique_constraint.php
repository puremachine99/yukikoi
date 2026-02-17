<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function (): void {
            $counters = [];

            DB::table('auction_lots as lots')
                ->select(
                    'lots.id',
                    'lots.auction_id',
                    'lots.created_at',
                    'profiles.farm_name',
                    'users.name as seller_name'
                )
                ->leftJoin('auctions', 'lots.auction_id', '=', 'auctions.id')
                ->leftJoin('users', 'auctions.seller_id', '=', 'users.id')
                ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
                ->orderBy('lots.created_at')
                ->orderBy('lots.id')
                ->chunk(100, function ($rows) use (&$counters): void {
                    foreach ($rows as $row) {
                        $prefixBase = $row->farm_name ?? $row->seller_name ?? 'LOT';
                        $prefix = Str::upper(Str::slug($prefixBase, ''));

                        if ($prefix === '') {
                            $prefix = 'LOT';
                        }

                        $prefix = Str::limit($prefix, 12, '');

                        $counters[$row->auction_id] = ($counters[$row->auction_id] ?? 0) + 1;
                        $sequence = $counters[$row->auction_id];

                        $code = sprintf('%s-%03d', $prefix, $sequence);

                        DB::table('auction_lots')
                            ->where('id', $row->id)
                            ->update(['lot_code' => $code]);
                    }
                });
        });

        DB::statement('ALTER TABLE auction_lots ALTER COLUMN lot_code SET NOT NULL');

        Schema::table('auction_lots', function (Blueprint $table) {
            $table->unique(['auction_id', 'lot_code']);
        });
    }

    public function down(): void
    {
        Schema::table('auction_lots', function (Blueprint $table) {
            $table->dropUnique('auction_lots_auction_id_lot_code_unique');
        });

        DB::statement('ALTER TABLE auction_lots ALTER COLUMN lot_code DROP NOT NULL');
    }
};
