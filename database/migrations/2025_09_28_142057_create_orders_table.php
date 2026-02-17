<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('buyer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('seller_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('auction_id')->nullable()->constrained('auctions')->nullOnDelete();
            $table->string('status')->default('pending_payment'); // pending_payment/paid/shipped/completed/cancelled
            $table->decimal('subtotal', 14, 2)->default(0);
            $table->decimal('fee_total', 14, 2)->default(0);
            $table->decimal('total', 14, 2)->default(0);
            $table->timestamp('expires_at')->nullable(); // 3-day rule
            $table->timestamps();
            $table->index(['buyer_id', 'status']);
            $table->index(['seller_id', 'status']);
            $table->index('expires_at');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
