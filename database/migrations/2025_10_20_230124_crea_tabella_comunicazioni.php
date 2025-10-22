<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sor.comunicazioni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id');
            $table->timestampTz('comunicata_il')->nullable();   // data+ora comunicazione
            $table->string('tipo', 40)->nullable();             // Telefono, Email, PEC, ...
            $table->enum('verso', ['Entrata', 'Uscita'])->default('Entrata');

            $table->string('mitt_dest', 160)->nullable();
            $table->string('telefono', 60)->nullable();
            $table->string('email', 160)->nullable();
            $table->string('indirizzo', 240)->nullable();

            $table->string('provincia', 4)->nullable();
            $table->string('comune', 120)->nullable();
            $table->jsonb('aree')->default('[]');

            $table->string('oggetto', 240)->nullable();
            $table->text('contenuto')->nullable();
            $table->enum('priorita', ['Nessuna', 'Alta', 'Media', 'Bassa'])->default('Nessuna');

            $table->timestampsTz();

            $table->foreign('evento_id')->references('id')->on('sor.eventi')->onDelete('cascade');

            $table->index('verso');
            $table->index('priorita');
            $table->index('comunicata_il');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sor.comunicazioni');
    }
};
