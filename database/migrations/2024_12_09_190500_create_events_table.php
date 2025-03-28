<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->text('description');
            $table->enum('event_type', ['keeping contest', 'grow out', 'azukari']);
            $table->enum('reward_mode', ['percent', 'fixed']);
            $table->json('reward_data');
            $table->integer('total_reward')->nullable();
            $table->integer('fixed_reward_total')->nullable();
            
            $table->dateTime('submission_time')->nullable();
            $table->dateTime('judging_time')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->dateTime('approved_at')->nullable();

            $table->string('event_code')->unique();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('approval_code')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->enum('status', ['draft', 'pending', 'rejected', 'ready', 'on going', 'completed'])->default('pending');
            $table->text('doorprize')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
