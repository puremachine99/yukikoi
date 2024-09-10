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
        Schema::table('media', function (Blueprint $table) {
            $table->dropForeign(['koi_id']); // Hapus foreign key lama
            $table->foreign('koi_id')
                ->references('id')->on('kois')
                ->onDelete('cascade'); // Tambahkan onDelete cascade
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->dropForeign(['koi_id']); // Hapus foreign key lama
            $table->foreign('koi_id')
                ->references('id')->on('kois')
                ->onDelete('cascade'); // Tambahkan onDelete cascade
        });
    }

    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropForeign(['koi_id']);
            $table->foreign('koi_id')
                ->references('id')->on('kois'); // Kembalikan tanpa onDelete cascade
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->dropForeign(['koi_id']);
            $table->foreign('koi_id')
                ->references('id')->on('kois'); // Kembalikan tanpa onDelete cascade
        });
    }
};
