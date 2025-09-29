<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, mixed>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'first_name'   => ['required', 'string', 'max:100'],
            'last_name'    => ['required', 'string', 'max:100'],
            'organization' => ['required', 'string', 'max:150'],
            'phone'        => ['nullable', 'string', 'max:30'],

            'email'        => [
                'required',
                'string',
                'lowercase',     // mantiene coerente il case
                'email',
                'max:255',
                Rule::unique(User::class, 'email'),
            ],

            // Usa le regole fornite dal trait Fortify (include "confirmed")
            'password'     => $this->passwordRules(),
        ])->validate();

        $email = strtolower($input['email']); // doppia sicurezza

        return User::create([
            'first_name'   => $input['first_name'],
            'last_name'    => $input['last_name'],
            'organization' => $input['organization'],
            'phone'        => $input['phone'] ?? null,
            'email'        => $email,

            // campo "name" composto automaticamente
            'name'         => trim($input['first_name'] . ' ' . $input['last_name']),

            'password'     => Hash::make($input['password']),
        ]);
    }
}
