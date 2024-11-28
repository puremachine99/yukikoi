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
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->unsignedBigInteger('farm')->nullable()->after('koi_id'); // Kolom untuk ID Toko
            $table->foreign('farm')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropForeign(['farm']);
            $table->dropColumn('farm');
        });
    }
};
