<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            ALTER TABLE sor.comunicazioni
            ADD COLUMN IF NOT EXISTS lat DOUBLE PRECISION,
            ADD COLUMN IF NOT EXISTS lng DOUBLE PRECISION
        ");

        DB::statement("
            CREATE INDEX IF NOT EXISTS comunicazioni_lat_lng_idx
            ON sor.comunicazioni (lat, lng)
        ");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE sor.comunicazioni DROP COLUMN IF EXISTS lat");
        DB::statement("ALTER TABLE sor.comunicazioni DROP COLUMN IF EXISTS lng");
    }
};
