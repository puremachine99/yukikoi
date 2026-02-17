<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignUuid('lot_id')->nullable()->constrained('auction_lots')->nullOnDelete();
            $table->foreignUuid('item_id')->nullable()->constrained('items')->nullOnDelete();
            $table->unsignedInteger('qty')->default(1);
            $table->decimal('price', 14, 2);
            $table->decimal('fee', 14, 2)->default(0);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
