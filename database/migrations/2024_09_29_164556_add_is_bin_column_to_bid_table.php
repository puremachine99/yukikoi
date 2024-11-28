<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->boolean('is_bin')->default(false)->after('is_win'); // Menambahkan kolom is_bin setelah kolom is_win
        });
    }

    public function down()
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->dropColumn('is_bin');
        });
    }
};
