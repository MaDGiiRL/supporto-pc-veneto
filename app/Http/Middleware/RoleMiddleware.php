<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Uso:
     *  ->middleware('role:amministratore')
     *  ->middleware('role:amministratore,prefetture,provincie')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'Utente non autenticato.');
        }

        if ($user->hasAnyRole($roles)) {
            return $next($request);
        }

        abort(403, 'Non hai i permessi per accedere a questa pagina.');
    }
}
