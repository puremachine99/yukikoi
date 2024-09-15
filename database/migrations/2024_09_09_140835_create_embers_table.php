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
        Schema::create('embers', function (Blueprint $table) {
            $table->id();
            $table->string('koi_id'); // Kolom koi_id sebagai string, agar sesuai dengan kolom id di tabel kois
            $table->unsignedBigInteger('user_id'); // Foreign key dari tabel users
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('koi_id')->references('id')->on('kois')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('embers');
    }
};
