<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();      // es: coordinamento, volontariato, mezzi, prociv
            $table->string('label');               // etichetta da mostrare a UI
            $table->boolean('can_assign')->default(false); // può smistare
            $table->boolean('can_close')->default(false);  // può chiudere
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
