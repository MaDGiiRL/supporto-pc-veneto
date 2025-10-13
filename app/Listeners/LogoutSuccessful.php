<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;

class LogoutResponse implements LogoutResponseContract
{
    public function toResponse($request)
    {
        
        session()->flash('alert', [
            'type' => 'info',
            'title' => 'Logout effettuato',
            'message' => 'Sei stata disconnessa correttamente.'
        ]);

        return redirect()->route('home');
    }
}
