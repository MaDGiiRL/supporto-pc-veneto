<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 🔹 di nuovo, se per caso la precedente non è ancora stata eseguita
        DB::statement('CREATE SCHEMA IF NOT EXISTS coc');

        Schema::create('coc.coc_logs', function (Blueprint $table) {
            $table->id();

            // Comune / ente
            $table->string('codistat', 10)->index();

            // Stato COC (chiusa / aperta diurna / h24, ecc)
            $table->unsignedTinyInteger('from_stato_id')->nullable();
            $table->unsignedTinyInteger('to_stato_id')->nullable();

            // Fase operativa comunale (assenza allerta / preallarme / allarme...)
            $table->unsignedTinyInteger('from_fase_id')->nullable();
            $table->unsignedTinyInteger('to_fase_id')->nullable();

            // Decorrenze
            $table->date('from_decorrenza')->nullable();
            $table->date('to_decorrenza')->nullable();

            // Descrizioni sintetiche
            $table->text('from_descrizione')->nullable();
            $table->text('to_descrizione')->nullable();

            // open | close | update
            $table->string('action', 20);

            // Utente che ha fatto l’operazione
            $table->string('performed_by')->nullable();
            $table->unsignedBigInteger('performed_by_id')->nullable();

            // Solo created_at (log append-only)
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coc.coc_logs');
    }
};
