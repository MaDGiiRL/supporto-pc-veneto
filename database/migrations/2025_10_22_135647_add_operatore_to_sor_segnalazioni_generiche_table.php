<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    private string $schema = 'sor';
    private string $table  = 'segnalazioni_generiche';

    private function hasColumn(string $col): bool
    {
        return DB::table('information_schema.columns')
            ->where('table_schema', $this->schema)
            ->where('table_name', $this->table)
            ->where('column_name', $col)
            ->exists();
    }

    private function hasIndex(string $indexName): bool
    {
        return DB::table('pg_indexes')
            ->where('schemaname', $this->schema)
            ->where('indexname', $indexName)
            ->exists();
    }

    public function up(): void
    {
        // Colonna 'operatore'
        if (!$this->hasColumn('operatore')) {
            Schema::table("{$this->schema}.{$this->table}", function (Blueprint $table) {
                $table->string('operatore', 120)->nullable()->after('sintesi');
            });
        }

        // Indice su 'operatore'
        $idx = 'segnalazioni_generiche_operatore_idx';
        if (!$this->hasIndex($idx)) {
            Schema::table("{$this->schema}.{$this->table}", function (Blueprint $table) use ($idx) {
                $table->index('operatore', $idx);
            });
        }
    }

    public function down(): void
    {
        // Drop indice se esiste
        $idx = 'segnalazioni_generiche_operatore_idx';
        if ($this->hasIndex($idx)) {
            Schema::table("{$this->schema}.{$this->table}", function (Blueprint $table) use ($idx) {
                $table->dropIndex($idx);
            });
        }

        // Drop colonna se esiste
        if ($this->hasColumn('operatore')) {
            Schema::table("{$this->schema}.{$this->table}", function (Blueprint $table) {
                $table->dropColumn('operatore');
            });
        }
    }
};
