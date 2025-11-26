<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleAbilityMiddleware
{
    /**
     * Uso:
     *  ->middleware('role.ability:assign')
     *  ->middleware('role.ability:close')
     */
    public function handle(Request $request, Closure $next, string $ability): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'Utente non autenticato.');
        }

        $allowed = match ($ability) {
            'assign' => $user->canAssign(),
            'close'  => $user->canClose(),
            default  => false,
        };

        if (! $allowed) {
            abort(403, 'Non puoi eseguire questa operazione.');
        }

        return $next($request);
    }
}
