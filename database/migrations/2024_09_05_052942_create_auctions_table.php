<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->string('auction_code')->primary();
            $table->string('title');
            $table->text('description');
            $table->enum('jenis', ['reguler', 'keeping contest', 'grow out', 'azukari'])->default('reguler');
            $table->enum('status', ['draft', 'pending', 'rejected', 'ready', 'on going', 'completed'])->default('draft');
            $table->timestamp('start_time');
            $table->datetime('end_time')->nullable();
            $table->dateTime('contest_time')->nullable();
            $table->string('banner')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('auctions');
        Schema::enableForeignKeyConstraints();
    }
};
