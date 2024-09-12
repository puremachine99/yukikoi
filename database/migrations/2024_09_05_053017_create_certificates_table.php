<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('koi_id'); // Pastikan ini adalah string agar sesuai dengan tipe kolom 'id' di tabel 'kois'
            $table->string('url_gambar'); // Kolom untuk menyimpan URL gambar sertifikat
            $table->timestamps();

            // Foreign key constraint untuk koi_id
            $table->foreign('koi_id')->references('id')->on('kois')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
