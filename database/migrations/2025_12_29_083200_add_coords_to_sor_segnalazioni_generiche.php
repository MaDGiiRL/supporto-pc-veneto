<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            ALTER TABLE sor.segnalazioni_generiche
            ADD COLUMN IF NOT EXISTS lat DOUBLE PRECISION,
            ADD COLUMN IF NOT EXISTS lng DOUBLE PRECISION
        ");

        DB::statement("
            CREATE INDEX IF NOT EXISTS seggen_lat_lng_idx
            ON sor.segnalazioni_generiche (lat, lng)
        ");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE sor.segnalazioni_generiche DROP COLUMN IF EXISTS lat");
        DB::statement("ALTER TABLE sor.segnalazioni_generiche DROP COLUMN IF EXISTS lng");
    }
};
