<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('item_shares', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('item_id')->constrained('items')->cascadeOnDelete();
            $table->string('platform')->nullable(); // facebook/twitter/whatsapp/etc
            $table->timestamps();
            $table->index(['item_id','platform']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('item_shares');
    }
};
