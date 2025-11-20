<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate(
            ['slug' => 'coordinamento'],
            [
                'label'      => 'Coordinamento (Admin)',
                'can_assign' => true,
                'can_close'  => true,
            ]
        );

        Role::updateOrCreate(
            ['slug' => 'volontariato'],
            [
                'label'      => 'Volontariato',
                'can_assign' => false,
                'can_close'  => true,
            ]
        );

        Role::updateOrCreate(
            ['slug' => 'mezzi'],
            [
                'label'      => 'Mezzi e Materiali',
                'can_assign' => false,
                'can_close'  => true,
            ]
        );

        Role::updateOrCreate(
            ['slug' => 'prociv'],
            [
                'label'      => 'Protezione Civile',
                'can_assign' => false,
                'can_close'  => true,
            ]
        );
    }
}
