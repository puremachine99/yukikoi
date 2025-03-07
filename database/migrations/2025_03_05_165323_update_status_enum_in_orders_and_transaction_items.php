<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Hapus kolom status yang lama
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Tambahkan kembali kolom status dengan opsi enum yang baru
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', [
                'menunggu konfirmasi',
                'karantina',
                'siap dikirim',
                'dikirim',
                'dibatalkan',
                'proses pengajuan komplain',
                'komplain disetujui',
                'komplain ditolak'
            ])->default('menunggu konfirmasi');
        });

        // Hapus kolom status di transaction_items
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Tambahkan kembali kolom status di transaction_items dengan opsi enum yang baru
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->enum('status', [
                'menunggu konfirmasi',
                'karantina',
                'siap dikirim',
                'dikirim',
                'dibatalkan',
                'proses pengajuan komplain',
                'komplain disetujui',
                'komplain ditolak'
            ])->default('menunggu konfirmasi');
        });
    }

    public function down(): void
    {
        // Rollback ke status enum sebelumnya
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status');
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
            $table->dropColumn('status');
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
};
