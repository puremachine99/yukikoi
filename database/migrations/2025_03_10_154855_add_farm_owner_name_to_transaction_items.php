<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->string('farm_owner_name', 255)->nullable(); // Menambahkan kolom farm_owner_name
            $table->string('farm_phone_number', 20)->nullable(); // Jika farm_phone_number juga hilang
        });
    }

    public function down(): void
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropColumn(['farm_owner_name', 'farm_phone_number']);
        });
    }
};
