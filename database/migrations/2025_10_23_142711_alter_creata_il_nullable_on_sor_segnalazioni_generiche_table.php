<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 👉 Rende nullable la colonna (senza doctrine/dbal)
        DB::statement("ALTER TABLE sor.segnalazioni_generiche ALTER COLUMN creata_il DROP NOT NULL");

        // (Opzionale) Se vuoi anche togliere il default now():
        // DB::statement("ALTER TABLE sor.segnalazioni_generiche ALTER COLUMN creata_il DROP DEFAULT");
    }

    public function down(): void
    {
        // ❌ Ripristina NOT NULL e il default now() (se lo avevi)
        DB::statement("ALTER TABLE sor.segnalazioni_generiche ALTER COLUMN creata_il SET DEFAULT now()");
        DB::statement("UPDATE sor.segnalazioni_generiche SET creata_il = now() WHERE creata_il IS NULL");
        DB::statement("ALTER TABLE sor.segnalazioni_generiche ALTER COLUMN creata_il SET NOT NULL");
    }
};
