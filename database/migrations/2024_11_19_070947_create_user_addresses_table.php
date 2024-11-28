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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke user
            $table->string('recipient_name'); // Atas nama penerima
            $table->string('phone_number'); // Nomor telepon penerima
            $table->string('full_address'); // Alamat lengkap
            $table->string('city'); // Kota
            $table->string('district'); // Kecamatan
            $table->enum('type', ['rumah', 'kantor', 'lain-lain'])->default('lain-lain'); // Jenis alamat
            $table->boolean('is_default')->default(false); // Penanda alamat default
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_adresses');
    }
};
