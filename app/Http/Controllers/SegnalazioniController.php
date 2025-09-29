<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SegnalazioniController extends Controller
{
    /** Elenco pagine + icone Heroicons **valide** (outline, senza prefisso). */
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
            'sinottico' => [
                'label'    => 'Sinottico',
                'category' => 'Generale',
                'icon'     => 'chart-bar',
                'view'     => 'placeholder',
            ],
            'apertura-chiusura-sor' => [
                'label'    => 'Apertura/Chiusura SOR',
                'category' => 'Generale',
                'icon'     => 'information-circle',
                'view'     => 'placeholder',
            ],
            'ricerca' => [
                'label'    => 'Ricerca',
                'category' => 'Generale',
                'icon'     => 'magnifying-glass',
                'view'     => 'placeholder',
            ],
            'segnalazione-generica' => [
                'label'    => 'Segnalazione generica',
                'category' => 'Generale',
                'icon'     => 'document-text',
                'view'     => 'placeholder',
            ],
            'eventi-aib' => [
                'label'    => 'Eventi AIB',
                'category' => 'Generale',
                'icon'     => 'fire',
                'view'     => 'placeholder',
            ],
            'monitoraggio-coc' => [
                'label'    => 'Monitoraggio COC',
                'category' => 'Generale',
                'icon'     => 'map',
                'view'     => 'placeholder',
            ],
            'telefonata-rep' => [
                'label'    => 'Telefonata reperibilità',
                'category' => 'Generale',
                'icon'     => 'phone',
                'view'     => 'placeholder',
            ],
            'tabella-riassuntiva' => [
                'label'    => 'Tabella riassuntiva',
                'category' => 'Generale',
                'icon'     => 'list-bullet', // <— sicura
                'view'     => 'placeholder',
            ],
            'eventi-in-atto' => [
                'label'    => 'Eventi in atto',
                'category' => 'Generale',
                'icon'     => 'bolt',
                'view'     => 'placeholder',
            ],

            // STORICO
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

            // EMERGENZE
            'emergency-scenarios' => [
                'label'    => 'Emergency scenarios',
                'category' => 'Emergenze',
                'icon'     => 'rectangle-stack', // <— al posto di "layers"
                'view'     => 'placeholder',
            ],
            'emergency-management' => [
                'label'    => 'Emergency Management',
                'category' => 'Emergenze',
                'icon'     => 'clipboard-document-check',
                'view'     => 'placeholder',
            ],

            // MAPPE
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

            // ALTRI
            'ricerca-recapiti' => [
                'label'    => 'Ricerca recapiti',
                'category' => 'Generale',
                'icon'     => 'magnifying-glass',
                'view'     => 'placeholder',
            ],
            'reportistica' => [
                'label'    => 'Reportistica',
                'category' => 'Generale',
                'icon'     => 'chart-pie',
                'view'     => 'placeholder',
            ],
        ];

        // ulteriore “cintura di sicurezza”: se qualcuno rimette un nome non valido
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

    public function index()
    {
        $pages = $this->pages();
        $currentKey = 'dashboard';
        $current = $pages[$currentKey];

        return view('applicativi.segnalazioni.index', compact('pages', 'currentKey', 'current'));
    }

    public function section(string $page)
    {
        $pages = $this->pages();
        $currentKey = array_key_exists($page, $pages) ? $page : 'dashboard';
        $current = $pages[$currentKey];

        return view('applicativi.segnalazioni.index', compact('pages', 'currentKey', 'current'));
    }
}
