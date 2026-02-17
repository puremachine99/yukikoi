<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
    
        if (Schema::hasColumn('sessions', 'user_id')) {
            DB::statement('ALTER TABLE sessions DROP COLUMN user_id;');
        }
        DB::statement('ALTER TABLE sessions ADD COLUMN user_id uuid NULL;');
        DB::statement('CREATE INDEX IF NOT EXISTS sessions_user_id_index ON sessions (user_id);');
    }

    public function down(): void
    {
        // Kembalikan ke integer kalau perlu (opsional)
        DB::statement('ALTER TABLE sessions DROP COLUMN user_id;');
        DB::statement('ALTER TABLE sessions ADD COLUMN user_id bigint NULL;');
        DB::statement('CREATE INDEX IF NOT EXISTS sessions_user_id_index ON sessions (user_id);');
    }
};
