<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // campi operativi sulla tabella esistente
        if (!Schema::hasColumn('sor.segnalazioni_generiche', 'status')) {
            DB::statement("ALTER TABLE sor.segnalazioni_generiche
              ADD COLUMN status        VARCHAR(32) DEFAULT 'aperta',
              ADD COLUMN assigned_to   VARCHAR(32) NULL,
              ADD COLUMN instructions  TEXT NULL,
              ADD COLUMN last_note_text TEXT NULL,
              ADD COLUMN last_note_by   VARCHAR(255) NULL,
              ADD COLUMN last_note_at   TIMESTAMPTZ NULL
            ");
            DB::statement("CREATE INDEX IF NOT EXISTS seggen_status_idx ON sor.segnalazioni_generiche(status)");
            DB::statement("CREATE INDEX IF NOT EXISTS seggen_assigned_idx ON sor.segnalazioni_generiche(assigned_to)");
        }

        // logs
        DB::statement("
            CREATE TABLE IF NOT EXISTS sor.sor_logs (
                id BIGSERIAL PRIMARY KEY,
                segnalazione_id BIGINT NOT NULL,
                action VARCHAR(32) NOT NULL,          -- assign | close | note
                from_status VARCHAR(32) NULL,
                to_status   VARCHAR(32) NULL,
                from_assignee VARCHAR(64) NULL,
                to_assignee   VARCHAR(64) NULL,
                details TEXT NULL,
                performed_by VARCHAR(255) NULL,
                performed_by_id BIGINT NULL,
                created_at TIMESTAMPTZ DEFAULT NOW(),
                updated_at TIMESTAMPTZ DEFAULT NOW()
            );
        ");
        DB::statement("CREATE INDEX IF NOT EXISTS logs_seg_idx ON sor.sor_logs(segnalazione_id)");
        DB::statement("CREATE INDEX IF NOT EXISTS logs_action_idx ON sor.sor_logs(action)");
        DB::statement("
            ALTER TABLE sor.sor_logs
            ADD CONSTRAINT fk_logs_seg FOREIGN KEY (segnalazione_id)
            REFERENCES sor.segnalazioni_generiche(id) ON DELETE CASCADE
        ");

        // notes
        DB::statement("
            CREATE TABLE IF NOT EXISTS sor.sor_notes (
                id BIGSERIAL PRIMARY KEY,
                segnalazione_id BIGINT NOT NULL,
                text TEXT NOT NULL,
                created_by VARCHAR(255) NULL,
                created_by_id BIGINT NULL,
                created_at TIMESTAMPTZ DEFAULT NOW(),
                updated_at TIMESTAMPTZ DEFAULT NOW()
            );
        ");
        DB::statement("CREATE INDEX IF NOT EXISTS notes_seg_idx ON sor.sor_notes(segnalazione_id)");
        DB::statement("
            ALTER TABLE sor.sor_notes
            ADD CONSTRAINT fk_notes_seg FOREIGN KEY (segnalazione_id)
            REFERENCES sor.segnalazioni_generiche(id) ON DELETE CASCADE
        ");
    }

    public function down(): void
    {
        // non rimuovo i campi dalla tabella principale per sicurezza
        DB::statement("DROP TABLE IF EXISTS sor.sor_notes");
        DB::statement("DROP TABLE IF EXISTS sor.sor_logs");
    }
};
