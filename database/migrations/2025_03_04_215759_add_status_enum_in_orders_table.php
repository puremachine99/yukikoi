<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status'); // Hapus dulu
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', [
                'menunggu konfirmasi',
                'sedang dikemas',
                'dikirim',
                'selesai',
                'dibatalkan',
                'proses pengajuan komplain',
                'komplain disetujui',
                'komplain ditolak'
            ])->default('menunggu konfirmasi');
        });

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropColumn('status'); // Hapus dulu
        });

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->enum('status', [
                'menunggu konfirmasi',
                'sedang dikemas',
                'dikirim',
                'selesai',
                'dibatalkan',
                'proses pengajuan komplain',
                'komplain disetujui',
                'komplain ditolak'
            ])->default('menunggu konfirmasi');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status'); // Hapus saat rollback
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', [
                'menunggu konfirmasi',
                'sedang dikemas',
                'dikirim',
                'selesai',
                'dibatalkan'
            ])->default('menunggu konfirmasi');
        });

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropColumn('status'); // Hapus saat rollback
        });

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->enum('status', [
                'menunggu konfirmasi',
                'sedang dikemas',
                'dikirim',
                'selesai',
                'dibatalkan'
            ])->default('menunggu konfirmasi');
        });
    }
};
