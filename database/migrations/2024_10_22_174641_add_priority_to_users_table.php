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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_priority_seller')->default(false); // Status Priority Seller
            $table->timestamp('subscription_start')->nullable();   // Tanggal mulai subscription
            $table->timestamp('subscription_end')->nullable();     // Tanggal berakhir subscription
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            //
        });
    }
};
