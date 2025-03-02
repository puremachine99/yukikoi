<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // database/migrations/2025_xx_xx_create_status_histories_table.php
    public function up()
    {
        Schema::create('status_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('transaction_item_id')->nullable();
            $table->string('status');
            $table->unsignedBigInteger('changed_by'); // ID User yang mengubah status
            $table->timestamp('changed_at')->useCurrent(); // Waktu perubahan status
            $table->timestamps(); // Ini akan menambahkan created_at & updated_at

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('transaction_item_id')->references('id')->on('transaction_items')->onDelete('cascade');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('status_histories');
    }
};
