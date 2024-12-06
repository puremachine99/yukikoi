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
        Schema::create('activities', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // User yang melakukan aktivitas
            $table->string('koi_id')->constrained('kois')->onDelete('cascade'); // Relasi ke tabel kois
            $table->enum('activity_type', ['view', 'like', 'bid', 'bin'])->index(); // Jenis aktivitas (view atau like)
            $table->decimal('weight', 8, 2)->default(1); // Bobot aktivitas untuk preferensi
            $table->timestamps(); // Created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activitiys');
    }
};
