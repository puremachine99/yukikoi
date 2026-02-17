<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('scope_type'); // 'auction' or 'lot'
            $table->uuid('scope_id');
            $table->timestamps();
            $table->index(['scope_type', 'scope_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
