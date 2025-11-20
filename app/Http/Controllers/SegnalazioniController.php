<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 👉 aggiungi i model per i log SOR
use App\Models\Sor\SorLog;
use App\Models\Sor\SorDashboardLog;

class SegnalazioniController extends Controller
{
    /** Elenco pagine + icone consentite */
    private function pages(): array
    {
        $pages = [
            // GENERALE
            'dashboard' => [
                'label'    => 'Dashboard',
                'category' => 'Generale',
                'icon'     => 'squares-2x2',
                'view'     => 'dashboard',
            ],
            'coordinamento' => [
                'label'    => 'Coordinamento',
                'category' => 'Generale',
                'icon'     => 'users',
                'view'     => 'coordinamento',
            ],
            'sinottico' => [
                'label'    => 'Sinottico',
                'category' => 'Generale',
                'icon'     => 'chart-bar',
                'view'     => 'sinottico',
            ],
            'apertura-chiusura-sor' => [
                'label'    => 'Apertura/Chiusura SOR',
                'category' => 'Generale',
                'icon'     => 'information-circle',
                'view'     => 'apertura-chiusura-sor',
            ],
            'monitoraggio-coc' => [
                'label'    => 'Monitoraggio COC',
                'category' => 'Generale',
                'icon'     => 'map',
                'view'     => 'monitoraggio-coc',
            ],

            // STORICO
            'log' => [
                'label'    => 'Log',
                'category' => 'Storico',
                'icon'     => 'clipboard-document-list',
                'view'     => 'log',   // 👉 usa la tua sections/log.blade.php
            ],
            'tabella-riassuntiva' => [
                'label'    => 'Tabella riassuntiva',
                'category' => 'Storico',
                'icon'     => 'list-bullet',
                'view'     => 'tabella-riassuntiva',
            ],

            // (altri item commentati vanno bene così come sono)
        ];

        // White-list icone
        $allowed = [
            'squares-2x2',
            'chart-bar',
            'information-circle',
            'magnifying-glass',
            'document-text',
            'fire',
            'map',
            'phone',
            'list-bullet',
            'bolt',
            'phone-arrow-down-left',
            'arrow-down-tray',
            'rectangle-group',
            'rectangle-stack',
            'clipboard-document-check',
            'map-pin',
            'users',
            'chart-pie'
        ];

        foreach ($pages as $k => $cfg) {
            $icon = $cfg['icon'] ?? 'document-text';
            if (!in_array($icon, $allowed, true)) {
                $pages[$k]['icon'] = 'document-text';
            }
        }

        return $pages;
    }

    private function resolveCurrent(array $pages, string $page): array
    {
        $key   = array_key_exists($page, $pages) ? $page : 'dashboard';
        $entry = $pages[$key];

        // Fallback se la view non esiste
        $view = $entry['view'] ?? 'placeholder';
        if (!view()->exists("applicativi.segnalazioni.sections.$view")) {
            $entry['view'] = 'placeholder';
        }

        // utile in blade
        $entry['_slug'] = $key;

        return $entry;
    }

    public function show(?string $page = 'dashboard')
    {
        $pages      = $this->pages();
        $current    = $this->resolveCurrent($pages, $page ?? 'dashboard');
        $currentKey = $current['_slug'];

        // base data per la view
        $data = [
            'pages'      => $pages,
            'current'    => $current,
            'currentKey' => $currentKey,
        ];

        // 🔹 SE SIAMO NELLA PAGINA LOG, CARICHIAMO I DUE Paginator
        if (($current['view'] ?? null) === 'log') {
            $data['coordLogs'] = SorLog::orderByDesc('created_at')
                ->paginate(50, ['*'], 'coord_page');

            $data['dashboardLogs'] = SorDashboardLog::orderByDesc('created_at')
                ->paginate(50, ['*'], 'dash_page');
        }

        return view('applicativi.segnalazioni.index', $data);
    }
}
