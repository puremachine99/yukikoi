<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kois', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_id')->constrained(); // Foreign key ke auctions
            $table->string('jenis_koi');
            $table->integer('ukuran');
            $table->enum('gender', ['male', 'female', 'unchecked'])->default('unchecked');
            $table->decimal('open_bid', 15, 2);
            $table->decimal('kelipatan_bid', 15, 2);
            $table->decimal('buy_it_now', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koi');
    }
};
