<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up(): void {
    DB::statement("
      ALTER TABLE sor.segnalazioni_generiche
      ADD COLUMN IF NOT EXISTS status VARCHAR(32) DEFAULT 'aperta',
      ADD COLUMN IF NOT EXISTS assigned_to VARCHAR(32) NULL,
      ADD COLUMN IF NOT EXISTS instructions TEXT NULL,
      ADD COLUMN IF NOT EXISTS last_note_text TEXT NULL,
      ADD COLUMN IF NOT EXISTS last_note_by VARCHAR(255) NULL,
      ADD COLUMN IF NOT EXISTS last_note_at TIMESTAMPTZ NULL
    ");
    DB::statement("CREATE TABLE IF NOT EXISTS sor.sor_logs (id bigserial primary key, segnalazione_id bigint not null, action varchar(32) not null, from_status varchar(32), to_status varchar(32), from_assignee varchar(64), to_assignee varchar(64), details text, performed_by varchar(255), performed_by_id bigint, created_at timestamptz default now(), updated_at timestamptz default now())");
    DB::statement("CREATE TABLE IF NOT EXISTS sor.sor_notes (id bigserial primary key, segnalazione_id bigint not null, text text not null, created_by varchar(255), created_by_id bigint, created_at timestamptz default now(), updated_at timestamptz default now())");
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('segnalazioni', function (Blueprint $table) {
            //
        });
    }
};
