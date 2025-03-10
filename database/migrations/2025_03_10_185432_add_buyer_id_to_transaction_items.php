<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->unsignedBigInteger('buyer_id')->nullable()->after('transaction_id'); // Tambahkan buyer_id tapi nullable dulu
        });

        // Update buyer_id berdasarkan transaction_id
        DB::statement('
        UPDATE transaction_items ti
        JOIN transactions t ON ti.transaction_id = t.id
        SET ti.buyer_id = t.user_id
    ');

        // Setelah data diisi, baru tambahkan foreign key
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropForeign(['buyer_id']);
            $table->dropColumn('buyer_id');
        });
    }

};
