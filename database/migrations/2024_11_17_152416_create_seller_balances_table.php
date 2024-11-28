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
        Schema::create('seller_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Seller
            $table->decimal('total_sales', 12, 2); // Total hasil penjualan
            $table->decimal('admin_fee', 10, 2); // Fee admin (5% atau 7.5%)
            $table->decimal('net_balance', 12, 2); // Saldo bersih setelah dikurangi fee admin
            $table->string('status')->default('pending'); // Pending, Settled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_balances');
    }
};
