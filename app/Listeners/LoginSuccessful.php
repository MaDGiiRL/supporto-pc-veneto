<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;

class LoginSuccessful
{
    public function handle(Login $event)
    {
        Session::flash('alert', [
            'type' => 'success',
            'title' => 'Accesso effettuato',
            'message' => 'Benvenuto, ' . $event->user->name . '!'
        ]);
    }
}
