<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    private string $schema = 'sor';
    private string $table  = 'sor_notes';

    private function tableExists(): bool
    {
        return DB::table('information_schema.tables')
            ->where('table_schema', $this->schema)
            ->where('table_name', $this->table)
            ->exists();
    }

    private function hasIndexOn(string $column): bool
    {
        return DB::table('pg_indexes')
            ->where('schemaname', $this->schema)
            ->where('tablename', $this->table)
            ->whereRaw("indexdef ILIKE ?", ["%({$column})%"])
            ->exists();
    }

    public function up(): void
    {
        if (!$this->tableExists()) {
            Schema::create("{$this->schema}.{$this->table}", function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('segnalazione_id');
                $table->text('text');
                $table->string('created_by', 160)->nullable();
                $table->unsignedBigInteger('created_by_id')->nullable();
                $table->timestampsTz();

                // niente ->index() qui
            });
        }

        // assicurati dell’indice su segnalazione_id (a prescindere dal nome esistente)
        if (!$this->hasIndexOn('segnalazione_id')) {
            DB::statement("CREATE INDEX sor_notes_segnalazione_id_idx ON {$this->schema}.{$this->table} (segnalazione_id)");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists("{$this->schema}.{$this->table}");
    }
};
