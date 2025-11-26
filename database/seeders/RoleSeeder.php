<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            // slug                  label                    can_assign  can_close
            ['amministratore',       'Amministratore',         true,       true],
            ['ufficio-volontariato', 'Ufficio Volontariato',   true,       true],
            ['comuni',               'Comuni',                 false,      false],
            ['pianificazione',       'Pianificazione',         true,       false],
            ['prefetture',           'Prefetture',             true,       true],
            ['provincie',            'Provincie',              true,       true],
            ['volontari',            'Volontari',              false,      false],
            ['sor-coordinatore',     'Coordinatore SOR',       true,       true],
            ['sor-mezzi-materiali',  'Mezzi e materiali SOR',  false,      true],
        ];

        foreach ($roles as [$slug, $label, $canAssign, $canClose]) {
            Role::updateOrCreate(
                ['slug' => $slug],
                [
                    'label'      => $label,
                    'can_assign' => $canAssign,
                    'can_close'  => $canClose,
                ]
            );
        }
    }
}
