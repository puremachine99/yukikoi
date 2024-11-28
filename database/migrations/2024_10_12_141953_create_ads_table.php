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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // Judul iklan (opsional)
            $table->text('description')->nullable(); // Deskripsi singkat iklan
            $table->string('image'); // Path untuk gambar iklan
            $table->string('link')->nullable(); // URL tujuan iklan
            $table->enum('position', ['carousel', 'sidebar', 'footer', 'sponsorship', 'header'])
                  ->default('carousel'); // Posisi iklan: carousel, sidebar, footer, sponsorship, header
            $table->boolean('is_active')->default(true); // Status aktif/non-aktif
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
