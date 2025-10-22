<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sor.segnalazioni_generiche', function (Blueprint $table) {
            $table->id();
            $table->timestampTz('creata_il')->useCurrent(); // data/ora inserimento
            $table->enum('direzione', ['E', 'U'])->default('E'); // Entrata/Uscita
            $table->string('tipologia', 50);
            $table->jsonb('aree')->default('[]');
            $table->text('sintesi')->nullable();
            $table->string('operatore', 120)->nullable();
            $table->enum('priorita', ['Nessuna', 'Alta', 'Media', 'Bassa'])->default('Nessuna');
            $table->foreignId('evento_id')->nullable();

            $table->timestampsTz();

            // FK su schema qualificato
            $table->foreign('evento_id')->references('id')->on('sor.eventi')->onDelete('set null');

            $table->index('tipologia');
            $table->index('direzione');
            $table->index('priorita');
            $table->index('creata_il');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sor.segnalazioni_generiche');
    }
};
