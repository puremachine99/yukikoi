<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lot_items', function (Blueprint $table) {
            $table->foreignUuid('lot_id')->constrained('auction_lots')->cascadeOnDelete();
            $table->foreignUuid('item_id')->constrained('items')->cascadeOnDelete();
            $table->primary(['lot_id', 'item_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('lot_items');
    }
};
