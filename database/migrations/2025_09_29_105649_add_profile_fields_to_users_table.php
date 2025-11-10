<?php

// database/migrations/2025_11_10_000000_fix_evento_id_on_segnalazioni_generiche.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sor.segnalazioni_generiche', function (Blueprint $table) {
            // Se la colonna esiste con nome errato, rinomina
            if (Schema::hasColumn('sor.segnalazioni_generiche', 'event_id') &&
                !Schema::hasColumn('sor.segnalazioni_generiche', 'evento_id')) {
                $table->renameColumn('event_id', 'evento_id');
            }

            // Assicurati sia integer/bigInteger compatibile con eventi.id
            // (usa il tipo che hai usato nella tabella 'sor.eventi')
            if (!Schema::hasColumn('sor.segnalazioni_generiche', 'evento_id')) {
                $table->unsignedBigInteger('evento_id')->nullable()->after('priorita');
            } else {
                // Forza nullable e tipo corretto se serve
                $table->unsignedBigInteger('evento_id')->nullable()->change();
            }

            // Indice + FK (prima rimuovi eventuale vincolo vecchio)
            try { $table->dropForeign(['evento_id']); } catch (\Throwable $e) {}
            $table->foreign('evento_id')
                  ->references('id')
                  ->on('sor.eventi')
                  ->nullOnDelete(); // o ->cascadeOnDelete() se preferisci
        });
    }

    public function down(): void
    {
        Schema::table('sor.segnalazioni_generiche', function (Blueprint $table) {
            try { $table->dropForeign(['evento_id']); } catch (\Throwable $e) {}
            // se prima si chiamava event_id e vuoi tornare indietro:
            // $table->renameColumn('evento_id', 'event_id');
        });
    }
};
