<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); 
            $table->string('name');
            $table->string('profile_photo')->nullable();
            $table->string('email')->unique();
            $table->string('farm_name')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('ktp_photo')->nullable();
            $table->string('nik')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('phone_number')->unique();
            $table->boolean('is_seller')->default(false);
            $table->string('pin')->default('1234');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes(); // Soft delete
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
