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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Buyer
            $table->decimal('total_amount', 12, 2); // Total biaya sebelum tambahan
            $table->decimal('fee_payment_gateway', 10, 2); // Biaya payment gateway
            $table->decimal('fee_application', 10, 2); // Biaya aplikasi
            $table->decimal('fee_rekber', 10, 2)->nullable(); // Fee rekber (input buyer)
            $table->decimal('fee_shipping', 10, 2)->nullable(); // Ongkos kirim
            $table->decimal('total_with_fees', 12, 2); // Total dengan semua biaya
            $table->string('status')->default('pending'); // Pending, Paid, Completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
