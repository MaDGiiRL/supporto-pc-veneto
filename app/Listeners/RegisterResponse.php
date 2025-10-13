<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Registrazione completata',
            'message' => 'Benvenuta/o ' . ($request->user()->name ?? '') . '!'
        ]);

        return redirect()->route('home');
    }
}
