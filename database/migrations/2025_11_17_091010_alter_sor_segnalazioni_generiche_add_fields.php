<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sor.segnalazioni_generiche', function (Blueprint $table) {
            // Tipo comunicazione (FAX, Email, Telefono, PEC…)
            $table->string('tipo', 40)->nullable();

            // Ente
            $table->string('ente', 255)->nullable();

            // Contatti
            $table->string('mitt_dest', 255)->nullable();
            $table->string('telefono', 60)->nullable();
            $table->string('email', 160)->nullable();
            $table->string('indirizzo', 240)->nullable();
            $table->string('provincia', 4)->nullable();
            $table->string('comune', 120)->nullable();

            // Oggetto + contenuto
            $table->string('oggetto', 240)->nullable();
            $table->text('contenuto')->nullable();

            // Campi specifici dinamici
            $table->jsonb('campi_specifici')->nullable();

            // Indici utili
            $table->index('ente');
            $table->index('comune');
        });
    }

    public function down(): void
    {
        Schema::table('sor.segnalazioni_generiche', function (Blueprint $table) {
            $table->dropIndex(['ente']);
            $table->dropIndex(['comune']);

            $table->dropColumn([
                'tipo',
                'ente',
                'mitt_dest',
                'telefono',
                'email',
                'indirizzo',
                'provincia',
                'comune',
                'oggetto',
                'contenuto',
                'campi_specifici',
            ]);
        });
    }
};
