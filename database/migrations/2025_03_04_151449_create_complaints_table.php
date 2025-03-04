<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_item_id')->constrained('transaction_items')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('cascade'); // Bisa null
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->enum('type', ['retur', 'komplain']); // Jenis permintaan
            $table->text('reason'); // Alasan komplain atau retur
            $table->string('proof')->nullable(); // Path untuk bukti (gambar/video)
            $table->enum('status', ['pending', 'diproses', 'selesai'])->default('pending')->index(); // Optimasi query
            $table->foreignId('resolved_by')->nullable()->constrained('users')->onDelete('set null'); // Admin yang menangani
            $table->text('response')->nullable(); // Tanggapan admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
