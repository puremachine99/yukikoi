<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('auction_counters', function (Blueprint $table) {
            $table->id();
            $table->string('prefix', 4);
            $table->string('year', 2);
            $table->string('month', 2);
            $table->unsignedInteger('sequence')->default(0);
            $table->timestamps();

            $table->unique(['prefix', 'year', 'month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auction_counters');
    }
};
