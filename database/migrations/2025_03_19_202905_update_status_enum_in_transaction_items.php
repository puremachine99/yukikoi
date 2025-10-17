<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $statuses = [
            'menunggu konfirmasi',
            'karantina',
            'siap dikirim',
            'dikirim',
            'dibatalkan',
            'proses pengajuan komplain',
            'komplain disetujui',
            'komplain ditolak',
            'selesai',
        ];

        if (Schema::getConnection()->getDriverName() === 'pgsql') {
            $enumList = "'" . implode("','", array_map(fn ($value) => str_replace("'", "''", $value), $statuses)) . "'";

            DB::statement("ALTER TABLE transaction_items ALTER COLUMN status DROP DEFAULT");
            DB::statement("ALTER TABLE transaction_items ALTER COLUMN status TYPE VARCHAR(255)");
            DB::statement("ALTER TABLE transaction_items DROP CONSTRAINT IF EXISTS transaction_items_status_check");
            DB::statement("ALTER TABLE transaction_items ADD CONSTRAINT transaction_items_status_check CHECK (status IN ($enumList))");
            DB::statement("ALTER TABLE transaction_items ALTER COLUMN status SET DEFAULT 'menunggu konfirmasi'");
            DB::statement("ALTER TABLE transaction_items ALTER COLUMN status SET NOT NULL");
        } else {
            Schema::table('transaction_items', function (Blueprint $table) use ($statuses) {
                $table->enum('status', $statuses)->default('menunggu konfirmasi')->change();
            });
        }
    }

    public function down(): void
    {
        $statuses = [
            'menunggu konfirmasi',
            'karantina',
            'siap dikirim',
            'dikirim',
            'dibatalkan',
            'proses pengajuan komplain',
            'komplain disetujui',
            'komplain ditolak',
        ];

        if (Schema::getConnection()->getDriverName() === 'pgsql') {
            $enumList = "'" . implode("','", array_map(fn ($value) => str_replace("'", "''", $value), $statuses)) . "'";

            DB::statement("ALTER TABLE transaction_items ALTER COLUMN status DROP DEFAULT");
            DB::statement("ALTER TABLE transaction_items DROP CONSTRAINT IF EXISTS transaction_items_status_check");
            DB::statement("ALTER TABLE transaction_items ADD CONSTRAINT transaction_items_status_check CHECK (status IN ($enumList))");
            DB::statement("ALTER TABLE transaction_items ALTER COLUMN status SET DEFAULT 'menunggu konfirmasi'");
            DB::statement("ALTER TABLE transaction_items ALTER COLUMN status SET NOT NULL");
        } else {
            Schema::table('transaction_items', function (Blueprint $table) use ($statuses) {
                $table->enum('status', $statuses)->default('menunggu konfirmasi')->change();
            });
        }
    }
};
