<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private string $schema = 'sor';
    private string $table  = 'segnalazioni_generiche';
    private string $fkName = 'segnalazioni_generiche_evento_id_fkey'; // nome standard PG se già creata
    private string $idxName = 'segnalazioni_generiche_evento_id_idx';

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

    private function hasForeignKey(string $fkName): bool
    {
        // Cerca per nome constraint
        $byName = DB::table('pg_constraint')
            ->where('conname', $fkName)
            ->exists();

        if ($byName) return true;

        // Oppure verifica che esista una FK da tabella->colonna verso sor.eventi(id)
        return DB::table('pg_constraint AS c')
            ->join('pg_class AS src', 'src.oid', '=', 'c.conrelid')
            ->join('pg_namespace AS ns_src', 'ns_src.oid', '=', 'src.relnamespace')
            ->join('pg_class AS tgt', 'tgt.oid', '=', 'c.confrelid')
            ->join('pg_namespace AS ns_tgt', 'ns_tgt.oid', '=', 'tgt.relnamespace')
            ->where('c.contype', 'f')
            ->where('ns_src.nspname', $this->schema)
            ->where('src.relname', $this->table)
            ->where('ns_tgt.nspname', $this->schema)
            ->where('tgt.relname', 'eventi')
            ->exists();
    }

    public function up(): void
    {
        // 1) Colonna evento_id deve esistere ed essere nullable
        if (! $this->hasColumn('evento_id')) {
            Schema::table("{$this->schema}.{$this->table}", function (Blueprint $table) {
                $table->foreignId('evento_id')->nullable()->after('priorita');
            });
        } else {
            // forza nullable (idempotente: Postgres non protesta se già nullable)
            DB::statement("ALTER TABLE {$this->schema}.{$this->table} ALTER COLUMN evento_id DROP NOT NULL");
        }

        // 2) Indice su evento_id (Postgres NON lo crea da solo con la FK)
        if (! $this->hasIndex($this->idxName)) {
            Schema::table("{$this->schema}.{$this->table}", function (Blueprint $table) {
                $table->index('evento_id', $this->idxName);
            });
        }

        // 3) Foreign key (crea solo se assente); usa NOT VALID poi VALIDATE per ridurre lock
        if (! $this->hasForeignKey($this->fkName)) {
            DB::statement("
                ALTER TABLE {$this->schema}.{$this->table}
                ADD CONSTRAINT {$this->fkName}
                FOREIGN KEY (evento_id)
                REFERENCES {$this->schema}.eventi(id)
                ON DELETE SET NULL
                NOT VALID;
            ");
            DB::statement("
                ALTER TABLE {$this->schema}.{$this->table}
                VALIDATE CONSTRAINT {$this->fkName};
            ");
        }
    }

    public function down(): void
    {
        // Drop FK se esiste
        if ($this->hasForeignKey($this->fkName)) {
            DB::statement("
                ALTER TABLE {$this->schema}.{$this->table}
                DROP CONSTRAINT IF EXISTS {$this->fkName};
            ");
        }

        // Drop indice se esiste
        if ($this->hasIndex($this->idxName)) {
            Schema::table("{$this->schema}.{$this->table}", function (Blueprint $table) {
                $table->dropIndex($this->idxName);
            });
        }
        // La colonna evento_id NON la rimuovo nel down per non perdere dati associati.
        // Se vuoi rimuoverla:
        // if ($this->hasColumn('evento_id')) {
        //     Schema::table("{$this->schema}.{$this->table}", function (Blueprint $table) {
        //         $table->dropColumn('evento_id');
        //     });
        // }
    }
};
