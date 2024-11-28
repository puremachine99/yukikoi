<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            Schema::table('transaction_items', function (Blueprint $table) {
                $table->decimal('shipping_fee', 12, 2)->after('price')->nullable()->default(0)->comment('Biaya ongkir per item');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            Schema::table('transaction_items', function (Blueprint $table) {
                $table->dropColumn('shipping_fee');
            });
        });
    }
};
