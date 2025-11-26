<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // utente che ha fatto l'azione (se loggato)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // chiave tecnica per filtrare (es. user.update, db.insert, db.update, ...)
            $table->string('action', 100);

            // descrizione leggibile / SQL
            $table->text('description')->nullable();

            // riferimento all'oggetto interessato (polimorfico, opzionale)
            $table->string('subject_type')->nullable();  // es. App\Models\User
            $table->unsignedBigInteger('subject_id')->nullable();

            // info di contesto
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
