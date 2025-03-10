<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('karantina_reason')->nullable()->after('status'); // Alasan Karantina
            $table->date('karantina_end_date')->nullable()->after('karantina_reason'); // Tanggal Selesai Karantina
            $table->text('cancel_reason')->nullable()->after('karantina_end_date'); // Alasan Pembatalan
        });

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->text('karantina_reason')->nullable()->after('status'); // Alasan Karantina
            $table->date('karantina_end_date')->nullable()->after('karantina_reason'); // Tanggal Selesai Karantina
            $table->text('cancel_reason')->nullable()->after('karantina_end_date'); // Alasan Pembatalan
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['karantina_reason', 'karantina_end_date', 'cancel_reason']);
        });

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropColumn(['karantina_reason', 'karantina_end_date', 'cancel_reason']);
        });
    }
};
