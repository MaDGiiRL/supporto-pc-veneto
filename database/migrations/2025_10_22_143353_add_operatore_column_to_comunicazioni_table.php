<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 🔍 Verifica robusta per Postgres: controlla nello schema 'sor'
        $exists = DB::table('information_schema.columns')
            ->where('table_schema', 'sor')
            ->where('table_name', 'comunicazioni')
            ->where('column_name', 'operatore')
            ->exists();

        if (! $exists) {
            Schema::table('sor.comunicazioni', function (Blueprint $table) {
                $table->string('operatore', 120)->nullable();
            });
        }
    }

    public function down(): void
    {
        $exists = DB::table('information_schema.columns')
            ->where('table_schema', 'sor')
            ->where('table_name', 'comunicazioni')
            ->where('column_name', 'operatore')
            ->exists();

        if ($exists) {
            Schema::table('sor.comunicazioni', function (Blueprint $table) {
                $table->dropColumn('operatore');
            });
        }
    }
};
