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
            $table->text('shipping_address')->nullable(); // Address of the shipping destination
            $table->string('farm_owner_name')->nullable(); // Name of the farm owner
            $table->string('farm_phone_number')->nullable(); // Phone number of the farm owner
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropColumn(['shipping_address', 'farm_owner_name', 'farm_phone_number']);
        });
    }
};
