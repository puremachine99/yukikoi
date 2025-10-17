<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->foreignId('buyer_id')->nullable()->constrained('users')->cascadeOnDelete();
        });

        DB::table('transaction_items')
            ->update([
                'buyer_id' => DB::raw('(SELECT user_id FROM transactions WHERE transactions.id = transaction_items.transaction_id LIMIT 1)'),
            ]);
    }

    public function down(): void
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('buyer_id');
        });
    }
};
