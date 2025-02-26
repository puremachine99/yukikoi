<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('koi_id'); // Menggunakan string agar sesuai dengan kois.id
        $table->foreign('koi_id')->references('id')->on('kois')->onDelete('cascade');
    
        $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
    
        $table->enum('status', ['menunggu konfirmasi', 'sedang dikemas', 'dikirim', 'selesai', 'dibatalkan'])->default('menunggu konfirmasi');
        $table->text('shipping_address')->nullable();
        $table->string('tracking_number')->nullable();
        $table->timestamps();
    });
    
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
