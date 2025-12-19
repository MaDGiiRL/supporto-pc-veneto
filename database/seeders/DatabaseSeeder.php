<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Qui registri il RoleSeeder
        $this->call([
            RoleSeeder::class,
        ]);
    }
}
