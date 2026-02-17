<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('gateway')->nullable();
            $table->string('method')->nullable();
            $table->string('gateway_ref')->nullable()->index();
            $table->string('status')->default('pending'); // pending/paid/failed/refunded
            $table->decimal('amount', 14, 2)->default(0);
            $table->json('raw_payload')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'paid_at']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
