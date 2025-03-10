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
        // Hapus foreign key hanya jika ada
        $foreignKeys = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_NAME = 'status_histories' AND COLUMN_NAME = 'order_id'");

        if (!empty($foreignKeys)) {
            $foreignKeyName = $foreignKeys[0]->CONSTRAINT_NAME;
            DB::statement("ALTER TABLE status_histories DROP FOREIGN KEY `$foreignKeyName`");
        }

        $foreignKeysComplaints = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_NAME = 'complaints' AND COLUMN_NAME = 'order_id'");

        if (!empty($foreignKeysComplaints)) {
            $foreignKeyName = $foreignKeysComplaints[0]->CONSTRAINT_NAME;
            DB::statement("ALTER TABLE complaints DROP FOREIGN KEY `$foreignKeyName`");
        }

        // Hapus kolom order_id jika ada
        Schema::table('status_histories', function (Blueprint $table) {
            if (Schema::hasColumn('status_histories', 'order_id')) {
                $table->dropColumn('order_id');
            }
        });

        Schema::table('complaints', function (Blueprint $table) {
            if (Schema::hasColumn('complaints', 'order_id')) {
                $table->dropColumn('order_id');
            }
        });

        // Setelah semua foreign key dihapus, hapus tabel orders
        Schema::dropIfExists('orders');
    }

    public function down(): void
    {
        // Buat ulang tabel orders jika rollback
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('seller_id');
            $table->string('koi_id');
            $table->unsignedBigInteger('transaction_id');
            $table->decimal('price', 12, 2);
            $table->enum('status', ['pending', 'menunggu konfirmasi', 'siap dikirim', 'dikirim', 'karantina', 'selesai', 'dibatalkan']);
            $table->text('shipping_address')->nullable();
            $table->string('recipient_name', 255)->nullable();
            $table->string('recipient_phone', 20)->nullable();
            $table->string('shipping_group', 255)->nullable();
            $table->timestamps();
        });

        // Tambahkan kembali foreign key di complaints
        Schema::table('complaints', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable()->after('id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

        // Tambahkan kembali foreign key di status_histories
        Schema::table('status_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable()->after('transaction_item_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }
};
