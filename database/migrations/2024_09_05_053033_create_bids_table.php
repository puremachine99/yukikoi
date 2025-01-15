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
            $table->string('koi_id'); // Foreign key dari tabel kois
            $table->unsignedBigInteger('user_id'); // Foreign key dari tabel users
            $table->decimal('amount', 10, 2); // Bid amount
            $table->boolean('is_win')->default(0); // Bid amount
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('koi_id')->references('id')->on('kois')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};
