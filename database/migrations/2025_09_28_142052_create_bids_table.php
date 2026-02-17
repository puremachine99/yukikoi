<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('lot_id')->constrained('auction_lots')->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount', 14, 2);
            $table->boolean('is_sniping')->default(false);
            $table->timestamp('created_at')->useCurrent();

            $table->index(['lot_id', 'created_at']);
            $table->index(['lot_id', 'amount']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};
