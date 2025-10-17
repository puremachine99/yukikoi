<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('status_histories', 'order_id')) {
            Schema::table('status_histories', function (Blueprint $table) {
                $table->dropConstrainedForeignId('order_id');
            });
        }

        if (Schema::hasColumn('complaints', 'order_id')) {
            Schema::table('complaints', function (Blueprint $table) {
                $table->dropConstrainedForeignId('order_id');
            });
        }

        Schema::dropIfExists('orders');
    }

    public function down(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->string('koi_id');
            $table->foreignId('transaction_id')->constrained('transactions')->cascadeOnDelete();
            $table->decimal('price', 12, 2);
            $table->enum('status', ['pending', 'menunggu konfirmasi', 'siap dikirim', 'dikirim', 'karantina', 'selesai', 'dibatalkan']);
            $table->text('shipping_address')->nullable();
            $table->string('recipient_name', 255)->nullable();
            $table->string('recipient_phone', 20)->nullable();
            $table->string('shipping_group', 255)->nullable();
            $table->timestamps();
        });

        Schema::table('complaints', function (Blueprint $table) {
            $table->foreignId('order_id')->nullable()->constrained('orders')->cascadeOnDelete();
        });

        Schema::table('status_histories', function (Blueprint $table) {
            $table->foreignId('order_id')->nullable()->constrained('orders')->cascadeOnDelete();
        });
    }
};
