<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDecimalPrecisionToSupport10m extends Migration
{
    public function up()
    {
        // Bids table
        Schema::table('bids', function (Blueprint $table) {
            $table->decimal('amount', 12, 2)->change(); // from 10,2 → 12,2
        });

        // Kois table
        Schema::table('kois', function (Blueprint $table) {
            $table->decimal('open_bid', 12, 2)->change();
            $table->decimal('kelipatan_bid', 12, 2)->change();
            $table->decimal('buy_it_now', 12, 2)->nullable()->change();
        });

        // Transactions table
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('total_amount', 15, 2)->change();
            $table->decimal('fee_payment_gateway', 12, 2)->change();
            $table->decimal('fee_application', 12, 2)->change();
            $table->decimal('fee_rekber', 12, 2)->nullable()->change();
            $table->decimal('fee_shipping', 12, 2)->nullable()->change();
            $table->decimal('total_with_fees', 15, 2)->change();
        });

        // Seller balances table
        Schema::table('seller_balances', function (Blueprint $table) {
            $table->decimal('total_sales', 15, 2)->change();
            $table->decimal('admin_fee', 12, 2)->change();
            $table->decimal('net_balance', 15, 2)->change();
        });

        // Carts table
        Schema::table('carts', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->change();
        });

        // Transaction items table
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->change();
        });
    }

    public function down()
    {
        // Reverse back to original (as fallback)
        Schema::table('bids', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->change();
        });

        Schema::table('kois', function (Blueprint $table) {
            $table->decimal('open_bid', 10, 0)->change();
            $table->decimal('kelipatan_bid', 10, 0)->change();
            $table->decimal('buy_it_now', 10, 0)->nullable()->change();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('total_amount', 12, 2)->change();
            $table->decimal('fee_payment_gateway', 10, 2)->change();
            $table->decimal('fee_application', 10, 2)->change();
            $table->decimal('fee_rekber', 10, 2)->nullable()->change();
            $table->decimal('fee_shipping', 10, 2)->nullable()->change();
            $table->decimal('total_with_fees', 12, 2)->change();
        });

        Schema::table('seller_balances', function (Blueprint $table) {
            $table->decimal('total_sales', 12, 2)->change();
            $table->decimal('admin_fee', 10, 2)->change();
            $table->decimal('net_balance', 12, 2)->change();
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->change();
        });

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->change();
        });
    }
}
