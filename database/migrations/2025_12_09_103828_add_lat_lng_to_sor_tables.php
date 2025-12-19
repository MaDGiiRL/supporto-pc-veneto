<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private function columnExists(string $schema, string $table, string $column): bool
    {
        $row = DB::selectOne("
            SELECT 1
            FROM information_schema.columns
            WHERE table_schema = ? AND table_name = ? AND column_name = ?
            LIMIT 1
        ", [$schema, $table, $column]);

        return (bool) $row;
    }

    private function addLatLng(string $schema, string $table): void
    {
        $fullTable = $schema . '.' . $table;

        if (!$this->columnExists($schema, $table, 'lat')) {
            Schema::table($fullTable, function (Blueprint $table) {
                $table->double('lat')->nullable();
            });
        }

        if (!$this->columnExists($schema, $table, 'lng')) {
            Schema::table($fullTable, function (Blueprint $table) {
                $table->double('lng')->nullable();
            });
        }
    }

    private function dropLatLng(string $schema, string $table): void
    {
        $fullTable = $schema . '.' . $table;

        if ($this->columnExists($schema, $table, 'lat')) {
            Schema::table($fullTable, function (Blueprint $table) {
                $table->dropColumn('lat');
            });
        }

        if ($this->columnExists($schema, $table, 'lng')) {
            Schema::table($fullTable, function (Blueprint $table) {
                $table->dropColumn('lng');
            });
        }
    }

    public function up(): void
    {
        // segnalazioni generiche
        $this->addLatLng('sor', 'segnalazioni_generiche');

        // comunicazioni (se in futuro vuoi lat/lng anche lì)
        $this->addLatLng('sor', 'comunicazioni');

        // eventi (se vuoi un "centroide" dell’evento)
        $this->addLatLng('sor', 'eventi');
    }

    public function down(): void
    {
        $this->dropLatLng('sor', 'segnalazioni_generiche');
        $this->dropLatLng('sor', 'comunicazioni');
        $this->dropLatLng('sor', 'eventi');
    }
};
