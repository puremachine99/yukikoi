<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('auction_reports', function (Blueprint $table) {
            $table->foreignUuid('auction_id')->primary()->constrained('auctions')->cascadeOnDelete();
            $table->json('stats'); // {participants, bid_count, watch_count, likes, shares, snipes, winner_id, final_price, fees, payouts, ...}
            $table->timestamp('generated_at')->useCurrent();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('auction_reports');
    }
};
