<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('seller_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['single', 'bundle'])->default('single');
            $table->enum('status', ['draft', 'scheduled', 'live', 'ended', 'cancelled'])->default('draft');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->integer('anti_snipe_window_sec')->default(60);
            $table->integer('extend_step_sec')->default(30);
            $table->decimal('buy_now_price', 14, 2)->nullable(); // optional global buy now
            $table->timestamps();

            $table->index(['seller_id', 'status']);
            $table->index(['status', 'start_at']);
            $table->index('end_at');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
