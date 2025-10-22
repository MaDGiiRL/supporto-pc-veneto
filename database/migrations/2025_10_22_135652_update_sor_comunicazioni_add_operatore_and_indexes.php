<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    private string $schema = 'sor';
    private string $table  = 'comunicazioni';

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
        // Aggiungi 'operatore' se manca
        if (!$this->hasColumn('operatore')) {
            Schema::table("{$this->schema}.{$this->table}", function (Blueprint $table) {
                $table->string('operatore', 120)->nullable()->after('contenuto');
            });
        }

        // Indici normali
        $idx = [
            'comunicazioni_evento_id_idx'      => 'evento_id',
            'comunicazioni_comunicata_il_idx'  => 'comunicata_il',
            'comunicazioni_tipo_idx'           => 'tipo',
            'comunicazioni_priorita_idx'       => 'priorita',
        ];

        foreach ($idx as $name => $col) {
            if (!$this->hasIndex($name) && $this->hasColumn($col)) {
                Schema::table("{$this->schema}.{$this->table}", function (Blueprint $table) use ($name, $col) {
                    $table->index($col, $name);
                });
            }
        }

        // Indice GIN su JSONB 'aree'
        if ($this->hasColumn('aree') && !$this->hasIndex('comunicazioni_aree_gin_idx')) {
            DB::statement("CREATE INDEX comunicazioni_aree_gin_idx ON {$this->schema}.{$this->table} USING GIN ((aree) jsonb_path_ops);");
        }

        // (Facoltativi) indici su lower() se usi LIKE case-insensitive frequenti
        // if (!$this->hasIndex('comunicazioni_oggetto_lower_idx')) {
        //     DB::statement(\"CREATE INDEX comunicazioni_oggetto_lower_idx ON {$this->schema}.{$this->table} (lower(oggetto));\");
        // }
    }

    public function down(): void
    {
        // Drop indici
        foreach (
            [
                'comunicazioni_evento_id_idx',
                'comunicazioni_comunicata_il_idx',
                'comunicazioni_tipo_idx',
                'comunicazioni_priorita_idx',
            ] as $name
        ) {
            if ($this->hasIndex($name)) {
                Schema::table("{$this->schema}.{$this->table}", function (Blueprint $table) use ($name) {
                    $table->dropIndex($name);
                });
            }
        }

        if ($this->hasIndex('comunicazioni_aree_gin_idx')) {
            DB::statement("DROP INDEX IF EXISTS comunicazioni_aree_gin_idx;");
        }

        // Drop colonna operatore se presente
        if ($this->hasColumn('operatore')) {
            Schema::table("{$this->schema}.{$this->table}", function (Blueprint $table) {
                $table->dropColumn('operatore');
            });
        }
    }
};
