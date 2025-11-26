<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 🔹 Assicuriamoci che lo schema "coc" esista (PostgreSQL)
        DB::statement('CREATE SCHEMA IF NOT EXISTS coc');

        Schema::create('coc.coc_stati', function (Blueprint $table) {
            $table->id();

            // Comune / ente
            $table->string('codistat', 10)->index(); // es. "26026"

            // Stato COC: 0=chiusa, 1=diurna, 2=h24, ecc (decidi tu la codifica)
            $table->unsignedTinyInteger('stato_coc')->default(0);

            // Fase operativa: 0=assenza allerta, 2=preallarme, 3=allarme...
            $table->unsignedTinyInteger('fase_operativa')->default(0);

            // Note
            $table->text('nota_stato')->nullable();
            $table->text('nota_fase')->nullable();

            // Decorrenza dell’assetto attuale (tipo data_sala / data_fase)
            $table->timestamp('data_ora')->useCurrent();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coc.coc_stati');
        // NON droppo lo schema coc, potrebbe avere altre tabelle
    }
};
