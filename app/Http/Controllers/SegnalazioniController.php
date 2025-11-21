<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// 👉 model per i log SOR
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
            'segnalazioni-eventi' => [
                'label'    => 'Segnalazioni Eventi',
                'category' => 'Generale',
                'icon'     => 'document-text',
                'view'     => 'segnalazioni-eventi',
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
                'view'     => 'log',
            ],
            'tabella-riassuntiva' => [
                'label'    => 'Tabella riassuntiva',
                'category' => 'Storico',
                'icon'     => 'list-bullet',
                'view'     => 'tabella-riassuntiva',
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

        // base data per la view
        $data = [
            'pages'      => $pages,
            'current'    => $current,
            'currentKey' => $currentKey,
        ];

        /*
        |--------------------------------------------------------------------------
        | PAGINA: APERTURA / CHIUSURA SOR
        |--------------------------------------------------------------------------
        */
        if (($current['view'] ?? null) === 'apertura-chiusura-sor') {

            // TODO: sostituisci con il tuo controlla_ente()
            $enteOriginario = 30000;

            // Stato SOR attuale
            $statoAttuale = DB::table('segnalazioni.stato_sala_operativa as s')
                ->join('segnalazioni.tbl_stati_sale_operative as t', 's.stato_sala_op', '=', 't.id_stati_sale_operative')
                ->select(
                    's.*',
                    't.descrizione as stato_descrizione'
                )
                ->where('s.codistat', $enteOriginario)
                ->orderBy('s.data_ora', 'desc')
                ->orderBy('s.segnalazione', 'desc')
                ->first();

            if (!$statoAttuale) {
                $statoAttuale = (object)[
                    'stato_sala_op'        => 0,
                    'data_ora'             => now(),
                    'nota_stato_sala_op'   => '',
                    'stato_descrizione'    => 'N/D',
                    'id_segnalazione_stato_sala_op' => null,
                ];
            }

            // Stati sala
            $statiSale = DB::table('segnalazioni.tbl_stati_sale_operative')
                ->orderBy('id_stati_sale_operative')
                ->get();

            // Rischi
            $rischi = DB::table('segnalazioni.tbl_rischio as r')
                ->leftJoin('segnalazioni.corem_rischio as c', function ($join) use ($statoAttuale) {
                    $join->on('r.id_rischio', '=', 'c.id_rischio')
                        ->whereNull('c.data_fine')
                        ->where('c.id_segnalazione_stato_sala_op', $statoAttuale->id_segnalazione_stato_sala_op);
                })
                ->select(
                    'r.*',
                    DB::raw('CASE WHEN c.id_segnalazione_stato_sala_op IS NULL THEN false ELSE true END as attivo')
                )
                ->orderBy('r.id_rischio')
                ->get();

            // Configurazioni
            $configurazioni = DB::table('segnalazioni.tbl_configurazione as c')
                ->leftJoin('segnalazioni.corem_configurazione as cc', function ($join) use ($statoAttuale) {
                    $join->on('c.id_configurazione', '=', 'cc.id_configurazione')
                        ->whereNull('cc.data_fine')
                        ->where('cc.id_segnalazione_stato_sala_op', $statoAttuale->id_segnalazione_stato_sala_op);
                })
                ->select(
                    'c.*',
                    DB::raw('CASE WHEN cc.id_segnalazione_stato_sala_op IS NULL THEN false ELSE true END as attiva')
                )
                ->orderBy('c.id_configurazione')
                ->get();

            // Funzioni
            $funzioni = DB::table('segnalazioni.tbl_funzioni as f')
                ->leftJoin('segnalazioni.corem_funzioni as cf', function ($join) use ($statoAttuale) {
                    $join->on('f.id_funzione', '=', 'cf.id_funzione')
                        ->whereNull('cf.data_fine')
                        ->where('cf.id_segnalazione_stato_sala_op', $statoAttuale->id_segnalazione_stato_sala_op);
                })
                ->select(
                    'f.*',
                    DB::raw('CASE WHEN cf.id_segnalazione_stato_sala_op IS NULL THEN false ELSE true END as attiva')
                )
                ->orderBy('f.id_funzione')
                ->get();

            // Log coordinamento + dashboard (inclusi i sor_open / sor_close / sor_update che hai scritto in SorController)
            $coordLogs = SorLog::orderByDesc('created_at')
                ->paginate(50, ['*'], 'coord_page');

            $dashboardLogs = SorDashboardLog::orderByDesc('created_at')
                ->paginate(50, ['*'], 'dash_page');

            $data = array_merge($data, [
                'statoAttuale'   => $statoAttuale,
                'statiSale'      => $statiSale,
                'rischi'         => $rischi,
                'configurazioni' => $configurazioni,
                'funzioni'       => $funzioni,
                'coordLogs'      => $coordLogs,
                'dashboardLogs'  => $dashboardLogs,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINA: LOG STORICO
        |--------------------------------------------------------------------------
        */
        if (($current['view'] ?? null) === 'log') {
            $data['coordLogs'] = SorLog::orderByDesc('created_at')
                ->paginate(50, ['*'], 'coord_page');

            $data['dashboardLogs'] = SorDashboardLog::orderByDesc('created_at')
                ->paginate(50, ['*'], 'dash_page');
        }

        return view('applicativi.segnalazioni.index', $data);
    }
}
