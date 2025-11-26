<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class ApplicativiController extends Controller
{
    /**
     * Filtra gli applicativi in base ai ruoli dell'utente.
     *
     * Ogni item in config/applicativi.php può avere una chiave opzionale:
     *  'roles' => ['amministratore', 'prefetture', 'provincie']
     *
     * Se 'roles' non è presente o è vuoto → applicativo visibile a TUTTI gli utenti abilitati.
     */
    protected function filterAppsForUser(array $apps, $user): array
    {
        return collect($apps)
            ->filter(function ($app) use ($user) {
                $allowedRoles = $app['roles'] ?? null;

                // Nessuna restrizione: visibile a tutti gli utenti abilitati
                if (empty($allowedRoles) || !is_array($allowedRoles)) {
                    return true;
                }

                // Usa il metodo che hai già nel modello User
                return $user->hasAnyRole($allowedRoles);
            })
            ->values()
            ->all();
    }

    /**
     * Lista applicativi.
     * - Utente deve essere autenticato E abilitato
     * - Mostriamo solo gli applicativi compatibili con i suoi ruoli
     * - Se non ci sono applicativi visibili → mostriamo pagina vuota (NON 403)
     */
    public function index()
    {
        $user = Auth::user();

        // Deve essere loggato e abilitato
        if (! $user || ! $user->is_active) {
            // Se vuoi usare la pagina custom:
            // return response()->view('errors.not-authorized', [], 403);
            abort(403, 'Non sei abilitato a visualizzare gli applicativi.');
        }

        // Recupera gli items dal file di configurazione
        $allApps = Config::get('applicativi.items', []);

        // Filtra in base ai ruoli dell'utente
        $apps = $this->filterAppsForUser($allApps, $user);

        // NIENTE più abort se $apps è vuoto:
        // la view gestirà il caso "nessun applicativo abilitato".

        return view('applicativi.index', [
            'apps'           => $apps,
            'hasVisibleApps' => ! empty($apps),
        ]);
    }

    /**
     * Dettaglio di un singolo applicativo.
     * - Stesse regole di accesso della index
     * - Se slug esiste ma non è tra quelli permessi al ruolo → 403
     */
    public function show(string $slug)
    {
        $user = Auth::user();

        if (! $user || ! $user->is_active) {
            // return response()->view('errors.not-authorized', [], 403);
            abort(403, 'Non sei abilitato a visualizzare gli applicativi.');
        }

        $allApps = Config::get('applicativi.items', []);

        // Filtra gli applicativi concessi all'utente
        $visibleApps = $this->filterAppsForUser($allApps, $user);

        // Cerca solo tra quelli visibili
        $app = collect($visibleApps)->firstWhere('slug', $slug);

        // Se non lo trovo:
        //  - o non esiste
        //  - oppure esiste ma non è permesso al ruolo dell'utente
        if (! $app) {
            abort(403, 'Non hai i permessi per accedere a questo applicativo.');
        }

        return view('applicativi.show', compact('app'));
    }
}
