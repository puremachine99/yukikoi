<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('owner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('species_id')->nullable()->constrained('fish_species')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();

            // spesifikasi ikan
            $table->enum('gender', ['male', 'female', 'unknown'])->default('unknown');
            $table->decimal('size_cm', 6, 2)->nullable(); // 9999.99 cm more than enough

            // harga default (boleh kosong di item; akan diisi di lot saat dilelang)
            $table->decimal('open_bid', 14, 2)->nullable();
            $table->decimal('bid_step', 14, 2)->nullable();
            $table->decimal('buy_now_price', 14, 2)->nullable();

            $table->json('media')->nullable(); // array of URLs / path
            $table->string('status')->default('draft'); // draft/active/sold/archived

            $table->string('sku')->nullable()->unique();

            $table->timestamps();

            // indeks pencarian
            $table->index(['owner_id', 'status']);
            $table->index('species_id');
            $table->index('gender');
            $table->index('size_cm');
            $table->index('open_bid');
            $table->index('buy_now_price');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
