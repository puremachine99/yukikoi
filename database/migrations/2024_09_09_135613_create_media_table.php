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
        Schema::create('media', function (Blueprint $table) {
            $table->id(); // Primary key untuk media
            $table->string('koi_id'); // Foreign key dari tabel koi (id dari tabel kois)
            $table->string('url_media'); // URL atau path media
            $table->enum('media_type', ['photo', 'video']); // Jenis media (foto atau video)
            $table->timestamps(); // Kolom created_at dan updated_at
            // Foreign key constraint untuk koi_id
            $table->foreign('koi_id')->references('id')->on('kois')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
