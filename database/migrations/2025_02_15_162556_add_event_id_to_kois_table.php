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
    Schema::table('kois', function (Blueprint $table) {
        $table->unsignedBigInteger('event_id')->nullable()->after('auction_code');
        $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('kois', function (Blueprint $table) {
        $table->dropForeign(['event_id']);
        $table->dropColumn('event_id');
    });
}

};
