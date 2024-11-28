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
        Schema::create('chats', function (Blueprint $table) {
            $table->id(); // Primary key otomatis
            $table->unsignedBigInteger('user_id'); // Foreign key ke tabel users
            $table->string('koi_id'); // Foreign key ke tabel kois
            $table->text('message'); // Kolom untuk menyimpan pesan chat
            $table->timestamps(); // Kolom created_at dan updated_at

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('koi_id')->references('id')->on('kois')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
