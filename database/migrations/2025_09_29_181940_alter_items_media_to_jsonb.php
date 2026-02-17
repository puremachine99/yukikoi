<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Convert items.media from JSON to JSONB to allow DISTINCT and better indexing in PostgreSQL.
        DB::statement('ALTER TABLE items ALTER COLUMN media TYPE jsonb USING media::jsonb');
    }

    public function down(): void
    {
        // Revert back to JSON (not recommended). Data preserved via cast.
        DB::statement('ALTER TABLE items ALTER COLUMN media TYPE json USING media::json');
    }
};
