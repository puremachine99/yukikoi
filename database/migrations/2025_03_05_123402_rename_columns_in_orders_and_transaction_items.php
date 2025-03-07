<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('total_price', 'price'); // Samakan dengan transaction_items
            $table->renameColumn('recipient_name', 'buyer_name'); // Agar lebih sesuai
            $table->renameColumn('recipient_phone', 'buyer_phone'); // Agar lebih sesuai
        });

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->renameColumn('farm_owner_name', 'seller_name'); // Agar lebih jelas
            $table->renameColumn('farm_phone_number', 'seller_phone'); // Agar lebih jelas
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('price', 'total_price');
            $table->renameColumn('buyer_name', 'recipient_name');
            $table->renameColumn('buyer_phone', 'recipient_phone');
        });

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->renameColumn('seller_name', 'farm_owner_name');
            $table->renameColumn('seller_phone', 'farm_phone_number');
        });
    }
};
