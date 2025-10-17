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
            $table->boolean('is_sniping')->default(0); // Whether the bid is a snipe bid
        });
    }

    public function down()
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->dropColumn('is_sniping');
        });
    }
};
