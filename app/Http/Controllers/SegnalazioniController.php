<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

use App\Models\Sor\SorLog;
use App\Models\Sor\SorDashboardLog;
use App\Models\Coc\CocStato;
use App\Models\Coc\CocLog;

class SegnalazioniController extends Controller
{
    /** Elenco pagine + icone consentite */
    private function pages(): array
    {
        $pages = [
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
                'label'    => 'Apertura SOR',
                'category' => 'Generale',
                'icon'     => 'information-circle',
                'view'     => 'apertura-chiusura-sor',
            ],
            'apertura-chiusura-coc' => [
                'label'    => 'Apertura COC',
                'category' => 'Generale',
                'icon'     => 'map-pin',
                'view'     => 'apertura-chiusura-coc',
            ],
            'monitoraggio-coc' => [
                'label'    => 'Monitoraggio COC',
                'category' => 'Generale',
                'icon'     => 'map',
                'view'     => 'monitoraggio-coc',
            ],

            // NUOVA PAGINA: Mappa segnalazioni SOR
            'mappa-sor' => [
                'label'    => 'Mappa segnalazioni',
                'category' => 'Generale',
                'icon'     => 'map',
                'view'     => 'mappa-sor',
            ],

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
            'chart-pie',
        ];

        foreach ($pages as $k => $cfg) {
            $icon = $cfg['icon'] ?? 'document-text';
            if (! in_array($icon, $allowed, true)) {
                $pages[$k]['icon'] = 'document-text';
            }
        }

        return $pages;
    }

    private function resolveCurrent(array $pages, string $page): array
    {
        $key   = array_key_exists($page, $pages) ? $page : 'dashboard';
        $entry = $pages[$key];

        $view = $entry['view'] ?? 'placeholder';
        if (! view()->exists("applicativi.segnalazioni.sections.$view")) {
            $entry['view'] = 'placeholder';
        }

        $entry['_slug'] = $key;

        return $entry;
    }

    public function show(Request $request, ?string $page = 'dashboard')
    {
        $pages      = $this->pages();
        $current    = $this->resolveCurrent($pages, $page ?? 'dashboard');
        $currentKey = $current['_slug'];

        $data = [
            'pages'      => $pages,
            'current'    => $current,
            'currentKey' => $currentKey,
        ];

        /*
        |--------------------------------------------------------------------------|
        | APERTURA / CHIUSURA SOR
        |--------------------------------------------------------------------------|
        */
        if (($current['view'] ?? null) === 'apertura-chiusura-sor') {

            $enteOriginario = 30000;

            $statoAttuale = DB::table('segnalazioni.stato_sala_operativa as s')
                ->join('segnalazioni.tbl_stati_sale_operative as t', 's.stato_sala_op', '=', 't.id_stati_sale_operative')
                ->select('s.*', 't.descrizione as stato_descrizione')
                ->where('s.codistat', $enteOriginario)
                ->orderBy('s.data_ora', 'desc')
                ->orderBy('s.segnalazione', 'desc')
                ->first();

            if (! $statoAttuale) {
                $statoAttuale = (object) [
                    'stato_sala_op'  => 0,
                    'data_ora'       => now(),
                    'nota_stato_sala_op' => '',
                    'stato_descrizione'  => 'N/D',
                    'id_segnalazione_stato_sala_op' => null,
                ];
            }

            $statiSale = DB::table('segnalazioni.tbl_stati_sale_operative')
                ->orderBy('id_stati_sale_operative')
                ->get();

            $rischi = DB::table('segnalazioni.tbl_rischio as r')
                ->leftJoin('segnalazioni.corem_rischio as c', function ($join) use ($statoAttuale) {
                    $join->on('r.id_rischio', '=', 'c.id_rischio')
                        ->whereNull('c.data_fine')
                        ->where('c.id_segnalazione_stato_sala_op', $statoAttuale->id_segnalazione_stato_sala_op);
                })
                ->select('r.*', DB::raw('CASE WHEN c.id_segnalazione_stato_sala_op IS NULL THEN false ELSE true END as attivo'))
                ->orderBy('r.id_rischio')
                ->get();

            $configurazioni = DB::table('segnalazioni.tbl_configurazione as c')
                ->leftJoin('segnalazioni.corem_configurazione as cc', function ($join) use ($statoAttuale) {
                    $join->on('c.id_configurazione', '=', 'cc.id_configurazione')
                        ->whereNull('cc.data_fine')
                        ->where('cc.id_segnalazione_stato_sala_op', $statoAttuale->id_segnalazione_stato_sala_op);
                })
                ->select('c.*', DB::raw('CASE WHEN cc.id_segnalazione_stato_sala_op IS NULL THEN false ELSE true END as attiva'))
                ->orderBy('c.id_configurazione')
                ->get();

            $funzioni = DB::table('segnalazioni.tbl_funzioni as f')
                ->leftJoin('segnalazioni.corem_funzioni as cf', function ($join) use ($statoAttuale) {
                    $join->on('f.id_funzione', '=', 'cf.id_funzione')
                        ->whereNull('cf.data_fine')
                        ->where('cf.id_segnalazione_stato_sala_op', $statoAttuale->id_segnalazione_stato_sala_op);
                })
                ->select('f.*', DB::raw('CASE WHEN cf.id_segnalazione_stato_sala_op IS NULL THEN false ELSE true END as attiva'))
                ->orderBy('f.id_funzione')
                ->get();

            $coordLogs = SorLog::orderByDesc('created_at')->paginate(50, ['*'], 'coord_page');
            $dashboardLogs = SorDashboardLog::orderByDesc('created_at')->paginate(50, ['*'], 'dash_page');

            $data = array_merge($data, compact(
                'statoAttuale',
                'statiSale',
                'rischi',
                'configurazioni',
                'funzioni',
                'coordLogs',
                'dashboardLogs'
            ));
        }

        /*
        |--------------------------------------------------------------------------|
        | APERTURA / CHIUSURA COC
        |--------------------------------------------------------------------------|
        */
        if (($current['view'] ?? null) === 'apertura-chiusura-coc') {

            $user = $request->user();
            $codistat = $user->codistat ?? '26026';

            $statoCoc = CocStato::where('codistat', $codistat)
                ->orderByDesc('data_ora')
                ->orderByDesc('id')
                ->first();

            if (! $statoCoc) {
                $statoCoc = new CocStato([
                    'codistat'       => $codistat,
                    'stato_coc'      => 0,
                    'fase_operativa' => 0,
                    'nota_stato'     => null,
                    'nota_fase'      => null,
                    'data_ora'       => now(),
                ]);
            }

            $segnalazioni = collect();
            $eventi       = collect();

            $data = array_merge($data, compact('codistat', 'statoCoc', 'segnalazioni', 'eventi'));
        }

        /*
        |--------------------------------------------------------------------------|
        | MONITORAGGIO COC
        |--------------------------------------------------------------------------|
        */
        if (($current['view'] ?? null) === 'monitoraggio-coc') {

            // Intervallo di default: mese corrente
            $defaultStart = Carbon::now()->startOfMonth();
            $defaultEnd   = Carbon::now()->endOfMonth()->setTime(23, 59, 59);

            // Nomi dei campi presi dalla Blade: data_inizio, data_fine, provincia
            $dataInizio = $request->input('data_inizio', $defaultStart->format('Y-m-d\TH:i'));
            $dataFine   = $request->input('data_fine',   $defaultEnd->format('Y-m-d\TH:i'));

            $provinciaSelezionata = $request->input('provincia', 'ALL');

            $start = Carbon::parse($dataInizio);
            $end   = Carbon::parse($dataFine);

            // Base query log COC nell’intervallo
            $base = CocLog::query()->whereBetween('created_at', [$start, $end]);

            $totalLogs   = (clone $base)->count();
            $totalOpens  = (clone $base)->where('action', 'open')->count();
            $totalCloses = (clone $base)->where('action', 'close')->count();
            $totalUpdate = (clone $base)->where('action', 'update')->count();

            $byStatus = (clone $base)
                ->select('to_stato_id', DB::raw('COUNT(*) as total'))
                ->groupBy('to_stato_id')
                ->orderBy('to_stato_id')
                ->get();

            $byFase = (clone $base)
                ->select('to_fase_id', DB::raw('COUNT(*) as total'))
                ->groupBy('to_fase_id')
                ->orderBy('to_fase_id')
                ->get();

            $logs = (clone $base)
                ->orderByDesc('created_at')
                ->limit(300)
                ->get();

            // Province (statiche, così la Blade ha sempre qualcosa da mostrare)
            $province = ['BL', 'PD', 'RO', 'TV', 'VE', 'VR', 'VI'];

            // Statistiche per provincia (per ora tutte 0, nessuna query su colonne non certe)
            $stats = [];
            foreach ($province as $p) {
                $stats[$p] = 0;
            }

            $totale = array_sum($stats);

            // Righe comuni per tabella (vuote: evitiamo query su colonne sconosciute)
            $comuniRows = collect();

            $data = array_merge($data, compact(
                'start',
                'end',
                'dataInizio',
                'dataFine',
                'provinciaSelezionata',
                'province',
                'stats',
                'totale',
                'comuniRows',
                'totalLogs',
                'totalOpens',
                'totalCloses',
                'totalUpdate',
                'byStatus',
                'byFase',
                'logs'
            ));
        }

        /* LOG SOR */
        if (($current['view'] ?? null) === 'log') {
            $data['coordLogs'] = SorLog::orderByDesc('created_at')->paginate(50, ['*'], 'coord_page');
            $data['dashboardLogs'] = SorDashboardLog::orderByDesc('created_at')->paginate(50, ['*'], 'dash_page');
        }

        return view('applicativi.segnalazioni.index', $data);
    }
}
