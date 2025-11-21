<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('coc_activations', function (Blueprint $table) {
            $table->id();

            // Comune/provincia presi da config, ma salvo codistat per riferimento
            $table->string('codistat', 6)->index();

            // Categoria COC (aperta h24, diurna, ecc.)
            $table->string('categoria')->nullable();

            // Periodo di validità dell’attivazione
            $table->timestamp('opened_at');
            $table->timestamp('closed_at')->nullable();

            // Lat/Lon opzionali: puoi precompilarli dal config
            $table->decimal('lat', 10, 6)->nullable();
            $table->decimal('lon', 10, 6)->nullable();

            $table->text('note')->nullable();

            // Chi ha creato la riga
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coc_activations');
    }
};
