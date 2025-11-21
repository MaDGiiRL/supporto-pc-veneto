<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sor_sala_logs', function (Blueprint $table) {
            $table->id();

            // Stato SOR
            $table->unsignedBigInteger('from_stato_id')->nullable();
            $table->unsignedBigInteger('to_stato_id')->nullable();

            // Config SOR
            $table->unsignedBigInteger('from_config_id')->nullable();
            $table->unsignedBigInteger('to_config_id')->nullable();

            // Decorrenza
            $table->date('from_decorrenza')->nullable();
            $table->date('to_decorrenza')->nullable();

            // Descrizione sintetica
            $table->text('from_descrizione')->nullable();
            $table->text('to_descrizione')->nullable();

            // Rischi / funzioni come JSON (array id)
            $table->json('from_rischi')->nullable();
            $table->json('to_rischi')->nullable();
            $table->json('from_funzioni')->nullable();
            $table->json('to_funzioni')->nullable();

            // open | close | update
            $table->string('action', 20);

            // Utente
            $table->string('performed_by')->nullable();
            $table->unsignedBigInteger('performed_by_id')->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sor_sala_logs');
    }
};
