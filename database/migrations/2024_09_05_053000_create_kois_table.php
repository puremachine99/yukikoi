<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kois', function (Blueprint $table) {
            $table->string('id')->primary(); // ID Koi sebagai primary key
            $table->string('auction_code'); // Foreign key dari auctions
            $table->string('kode_ikan');
            $table->string('judul')->nullable();
            $table->string('jenis_koi');
            $table->integer('ukuran');
            $table->enum('gender', ['male', 'female', 'unchecked'])->default('unchecked');
            $table->decimal('open_bid', 10, 0);
            $table->decimal('kelipatan_bid', 10, 0);
            $table->decimal('buy_it_now', 10, 0)->nullable();
            $table->text('keterangan')->nullable();
            $table->string('breeder')->nullable();
            $table->timestamps();
            // Foreign key constraint
            $table->foreign('auction_code')->references('auction_code')->on('auctions')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('koi');
    }
};
