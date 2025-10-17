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
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->enum('status', ['menunggu konfirmasi', 'sedang dikemas', 'dikirim', 'selesai', 'dibatalkan'])
                  ->default('menunggu konfirmasi');
        });
    }
    
    public function down()
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
    
};
