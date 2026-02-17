<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('escrow_entries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('type'); // hold/release/refund
            $table->decimal('amount', 14, 2);
            $table->string('note')->nullable();
            $table->timestamps();
            $table->index(['order_id', 'type']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('escrow_entries');
    }
};
