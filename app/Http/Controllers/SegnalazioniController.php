<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            // 'ricerca' => [
            //     'label'    => 'Ricerca',
            //     'category' => 'Generale',
            //     'icon'     => 'magnifying-glass',
            //     'view'     => 'ricerca',
            // ],
            'monitoraggio-coc' => [
                'label'    => 'Monitoraggio COC',
                'category' => 'Generale',
                'icon'     => 'map',
                'view'     => 'monitoraggio-coc',
            ],
            'tabella-riassuntiva' => [
                'label'    => 'Tabella riassuntiva',
                'category' => 'Generale',
                'icon'     => 'list-bullet',
                'view'     => 'tabella-riassuntiva',
            ],

            // SEZIONI CHE NON HAI ANCORA → placeholder
            // 'eventi-in-atto' => [
            //     'label'    => 'Eventi in atto',
            //     'category' => 'Generale',
            //     'icon'     => 'bolt',
            //     'view'     => 'placeholder',
            // ],
            'storico-chiamate' => [
                'label'    => 'Storico chiamate',
                'category' => 'Storico',
                'icon'     => 'phone-arrow-down-left',
                'view'     => 'placeholder',
            ],
            'storico-vvf-estrazione' => [
                'label'    => 'Storico VVF Estrazione',
                'category' => 'Storico',
                'icon'     => 'arrow-down-tray',
                'view'     => 'placeholder',
            ],
            'storico-vvf-mappatura' => [
                'label'    => 'Storico VVF Mappatura interventi',
                'category' => 'Storico',
                'icon'     => 'rectangle-group',
                'view'     => 'placeholder',
            ],
            'emergency-scenarios' => [
                'label'    => 'Emergency scenarios',
                'category' => 'Emergenze',
                'icon'     => 'rectangle-stack',
                'view'     => 'placeholder',
            ],
            'emergency-management' => [
                'label'    => 'Emergency Management',
                'category' => 'Emergenze',
                'icon'     => 'clipboard-document-check',
                'view'     => 'placeholder',
            ],
            'mappa-eventi' => [
                'label'    => 'Mappa eventi',
                'category' => 'Mappe',
                'icon'     => 'map-pin',
                'view'     => 'placeholder',
            ],
            'mappa-interventi-vvf' => [
                'label'    => 'Mappa Interventi VVF',
                'category' => 'Mappe',
                'icon'     => 'map',
                'view'     => 'placeholder',
            ],
            'mappa-cluster-vvf' => [
                'label'    => 'Mappa cluster eventi VVF',
                'category' => 'Mappe',
                'icon'     => 'rectangle-stack',
                'view'     => 'placeholder',
            ],
            'mappa-stato-coc' => [
                'label'    => 'Mappa stato COC',
                'category' => 'Mappe',
                'icon'     => 'map',
                'view'     => 'placeholder',
            ],
            'mappa-attivita-organizzazioni' => [
                'label'    => "Mappa att.tà organizzazioni",
                'category' => 'Mappe',
                'icon'     => 'users',
                'view'     => 'placeholder',
            ],
            'ricerca-recapiti' => [
                'label'    => 'Ricerca recapiti',
                'category' => 'Generale',
                'icon'     => 'magnifying-glass',
                'view'     => 'ricerca-recapiti',
            ],
            'reportistica' => [
                'label'    => 'Reportistica',
                'category' => 'Generale',
                'icon'     => 'chart-pie',
                'view'     => 'placeholder',
            ],
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

        return view('applicativi.segnalazioni.index', compact('pages', 'current', 'currentKey'));
    }
}
