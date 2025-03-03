<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_item_id')->constrained('transaction_items')->onDelete('cascade');
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->tinyInteger('rating_quality')->unsigned()->comment('Kualitas Produk (1-5)');
            $table->tinyInteger('rating_shipping')->unsigned()->comment('Kondisi Pengiriman (1-5)');
            $table->tinyInteger('rating_service')->unsigned()->comment('Pelayanan Penjual (1-5)');
            $table->text('review')->nullable()->comment('Ulasan dari Buyer');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ratings');
    }
};
