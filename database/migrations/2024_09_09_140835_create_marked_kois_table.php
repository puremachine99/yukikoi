<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('marked_kois', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // User yang tandain koi
            $table->foreignId('koi_id')->constrained(); // Koi yang ditandai
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marked_kois');
    }
};
