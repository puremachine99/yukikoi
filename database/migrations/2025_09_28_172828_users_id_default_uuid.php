<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // kalau kolom id sudah bertipe uuid, set default-nya
        DB::statement('ALTER TABLE users ALTER COLUMN id SET DEFAULT gen_random_uuid();');
    }
    public function down(): void
    {
        DB::statement('ALTER TABLE users ALTER COLUMN id DROP DEFAULT;');
    }
};
