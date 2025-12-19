<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Assicuro che lo schema "segnalazioni" esista
        DB::statement('CREATE SCHEMA IF NOT EXISTS segnalazioni');

        // ATTENZIONE: per Postgres schema.tabella
        Schema::create('segnalazioni.stato_sala_operativa', function (Blueprint $table) {
            $table->bigIncrements('id_segnalazione_stato_sala_op');

            $table->integer('codistat');                        // usato nel where
            $table->unsignedBigInteger('stato_sala_op');        // join con tbl_stati_sale_operative
            $table->timestamp('data_ora');                      // usato nell'orderBy
            $table->text('nota_stato_sala_op')->nullable();     // usato nel fallback

            // se ti serve anche created_at/updated_at
            // $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('segnalazioni.stato_sala_operativa');
    }
};
