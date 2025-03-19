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
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->enum('status', [
                'menunggu konfirmasi',
                'karantina',
                'siap dikirim',
                'dikirim',
                'dibatalkan',
                'proses pengajuan komplain',
                'komplain disetujui',
                'komplain ditolak',
                'selesai' // Tambahkan status selesai
            ])->default('menunggu konfirmasi')->change();
        });
    }

    public function down(): void
    {
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
            ])->default('menunggu konfirmasi')->change();
        });
    }
};
