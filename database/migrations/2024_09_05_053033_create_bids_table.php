<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_id')->constrained(); // Foreign key ke auctions
            $table->foreignId('koi_id')->constrained(); // Foreign key ke koi
            $table->foreignId('user_id')->constrained(); // Foreign key ke users (bidder)
            $table->decimal('bid_amount', 15, 2);
            $table->boolean('is_winner')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};
