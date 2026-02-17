<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('payer_id')->constrained('users')->cascadeOnDelete();
            $table->string('purpose'); // order/ad/etc
            $table->string('currency', 3)->default('IDR');
            $table->decimal('amount', 14, 2)->default(0);
            $table->string('status')->default('pending'); // pending/paid/expired
            $table->string('gateway')->nullable();
            $table->string('external_ref')->nullable()->index();
            $table->json('metadata')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'expires_at']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
