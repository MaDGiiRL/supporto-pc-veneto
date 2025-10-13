<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;

class ApplicativiController extends Controller
{
    public function index()
    {
        // Recupera gli items dal file di configurazione
        $apps = Config::get('applicativi.items', []);

        // Passa i dati alla view
        return view('applicativi.index', compact('apps'));
    }

    public function show(string $slug)
    {
        // Cerca l'app specifico nel config (opzionale)
        $apps = Config::get('applicativi.items', []);
        $app = collect($apps)->firstWhere('slug', $slug);

        if (!$app) {
            abort(404);
        }

        // Mostra la view del singolo applicativo
        return view('applicativi.show', compact('app'));
    }
}
