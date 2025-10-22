<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sor.eventi', function (Blueprint $table) {
            $table->id();
            $table->string('tipologia', 50);                // sismico, idraulico, ecc.
            $table->text('descrizione')->nullable();
            $table->jsonb('aree')->default('[]');           // ["Verona", "Verona - Avesa", ...]
            $table->boolean('aperto')->default(true);
            $table->timestampTz('aggiornato_il')->nullable();
            $table->string('operatore', 120)->nullable();
            $table->timestampsTz();

            $table->index('tipologia');
            $table->index('aperto');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sor.eventi');
    }
};
