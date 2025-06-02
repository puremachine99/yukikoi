<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number')->index(); // Untuk pencarian cepat
            $table->string('otp'); // Menyimpan hash OTP, bukan plain text
            $table->string('purpose'); // 'password_reset' atau 'registration'
            $table->boolean('verified')->default(false);
            $table->timestamp('expires_at');
            $table->timestamps();
            
            // Index untuk query yang sering digunakan
            $table->index(['phone_number', 'purpose']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};