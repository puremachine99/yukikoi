<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('auction_lots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('auction_id')->constrained('auctions')->cascadeOnDelete();
            $table->string('lot_code')->nullable();
            $table->string('title')->nullable();
            $table->decimal('open_bid', 14, 2)->nullable();
            $table->decimal('min_step', 14, 2)->nullable();
            $table->decimal('reserve_price', 14, 2)->nullable();
            $table->decimal('buy_now_price', 14, 2)->nullable();
            $table->timestamps();
            $table->index(['auction_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('auction_lots');
    }
};
