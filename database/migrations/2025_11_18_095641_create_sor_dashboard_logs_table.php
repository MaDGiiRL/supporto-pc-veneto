<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sor.sor_dashboard_logs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('segnalazione_id')->nullable();
            $table->unsignedBigInteger('evento_id')->nullable();

            // es: created, updated, deleted, linked_to_event, unlinked_from_event…
            $table->string('action', 50);

            // stato della segnalazione/evento (se li usi in dashboard)
            $table->string('from_status', 50)->nullable();
            $table->string('to_status', 50)->nullable();

            // assegnatario (se in dashboard assegni a qualcuno, altrimenti li puoi lasciare null)
            $table->string('from_assignee', 100)->nullable();
            $table->string('to_assignee', 100)->nullable();

            // testo libero (es. "Creata segnalazione generica", "Modificato oggetto", ecc.)
            $table->text('details')->nullable();

            $table->string('performed_by', 100)->nullable();
            $table->unsignedBigInteger('performed_by_id')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sor.sor_dashboard_logs');
    }
};
