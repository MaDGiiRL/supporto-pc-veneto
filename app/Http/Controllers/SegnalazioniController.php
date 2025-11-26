<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

// 👉 model per i log SOR
use App\Models\Sor\SorLog;
use App\Models\Sor\SorDashboardLog;

// 👉 model COC (stato + log)
use App\Models\Coc\CocStato;
use App\Models\Coc\CocLog;

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
            // 👉 nuovo: sinottico
            'sinottico' => [
                'label'    => 'Sinottico',
                'category' => 'Generale',
                'icon'     => 'chart-pie',
                'view'     => 'sinottico',
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

        // Fallback se la view non esiste
        $view = $entry['view'] ?? 'placeholder';
        if (! view()->exists("applicativi.segnalazioni.sections.$view")) {
            $entry['view'] = 'placeholder';
        }

        // utile in blade
        $entry['_slug'] = $key;

        return $entry;
    }

    public function show(Request $request, ?string $page = 'dashboard')
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
        |--------------------------------------------------------------------------|
        | PAGINA: SINOTTICO (replica vecchia pagina iniziale)
        |--------------------------------------------------------------------------|
        */
        if (($current['view'] ?? null) === 'sinottico') {

            /*
            |------------------------------------------------------------------
            | Province del Veneto (config) + indice numerico come legacy
            |------------------------------------------------------------------
            */
            $venetoConfig = Config::get('province.veneto', []);
            $province     = array_keys($venetoConfig);

            // fallback se il config è vuoto
            if (empty($province)) {
                $province = ['BL', 'PD', 'RO', 'TV', 'VE', 'VI', 'VR'];
            }

            $provinceIndex = [];
            foreach ($province as $i => $sigla) {
                $provinceIndex[$sigla] = $i + 1; // BL=1, PD=2, ...
            }

            /*
            |------------------------------------------------------------------
            | 1. Situazione Centri Operativi Comunali (COC) – $stato_sala_sintetico
            |------------------------------------------------------------------
            | Query equivalente alla crosstab del vecchio PHP:
            |  - ultima stato_sala_operativa per comune
            |  - join con Comuni_Veneto + Province
            |  - conteggi per (stato, provincia)
            |------------------------------------------------------------------
            */
            $cocMatrix = [];

            $sqlCoc = <<<'SQL'
SELECT
    COALESCE(t.descrizione, 'N.D.') AS label,
    prov."Sigla"                   AS sigla,
    COUNT(*)                       AS total,
    sq.stato_sala_op               AS stato_id
FROM "General_data"."Comuni_Veneto" cv
LEFT JOIN "General_data"."Province" prov
       ON prov."Codice Provincia" = cv."Codice Provincia"
LEFT JOIN (
    SELECT DISTINCT s.stato_sala_op, s.codistat
    FROM segnalazioni.stato_sala_operativa s
    JOIN (
        SELECT DISTINCT
            codistat,
            MAX(data_ora_reg) OVER (PARTITION BY codistat ORDER BY codistat) AS latest,
            MAX(segnalazione) OVER (PARTITION BY codistat ORDER BY codistat) AS segnalazione
        FROM segnalazioni.stato_sala_operativa
        WHERE data_ora < NOW()
        ORDER BY codistat
    ) m
      ON s.segnalazione = m.segnalazione
     AND s.codistat     = m.codistat
) sq
    ON sq.codistat = cv."CodiceIstatC"
LEFT JOIN segnalazioni.tbl_stati_sale_operative t
       ON sq.stato_sala_op = t.id_stati_sale_operative
WHERE cv."CodiceIstatC" > 0
  AND cv."Soppresso" = false
GROUP BY label, sigla, sq.stato_sala_op
ORDER BY sq.stato_sala_op, sigla;
SQL;

            try {
                $rowsCoc = DB::select($sqlCoc);
                $tmp     = [];

                foreach ($rowsCoc as $row) {
                    $label   = $row->label;
                    $sigla   = $row->sigla;
                    $total   = (int) $row->total;
                    $statoId = (int) $row->stato_id;

                    if (! in_array($sigla, $province, true)) {
                        continue;
                    }

                    if (! isset($tmp[$label])) {
                        $tmp[$label] = [
                            'label'  => $label,
                            'codice' => $statoId,
                            'values' => array_fill_keys($province, 0),
                        ];
                    }

                    $tmp[$label]['values'][$sigla] = $total;
                }

                // ordino per codice stato (0 chiusa, 1 aperta diurna, 2 h24, …)
                usort($tmp, function ($a, $b) {
                    return ($a['codice'] ?? 0) <=> ($b['codice'] ?? 0);
                });

                $cocMatrix = array_values($tmp);
            } catch (\Throwable $e) {
                $cocMatrix = [];
            }

            /*
            |------------------------------------------------------------------
            | 2. Interventi VVF di interesse – $cap_attuali
            |------------------------------------------------------------------
            | Nel vecchio PHP usavi una crosstab per contare gli interventi
            | per sender (mail comando VVF) → provincia.
            |------------------------------------------------------------------
            */
            $vvfMatrix = [];

            $sqlVvf = <<<'SQL'
SELECT
    sender,
    COUNT(a.incidentprogress) AS total
FROM cap_vvf.tipologie_eventi te
LEFT JOIN (
    SELECT *
    FROM cap_vvf.alert
    WHERE incidentprogress NOT IN ('CLOSED', 'ON HOLD')
      AND expires > NOW()
) a
ON a.code_l1 = te.tipologia_evento
GROUP BY sender
ORDER BY sender;
SQL;

            // mapping sender → sigla provincia
            $vvfSenderToProv = [
                'com.belluno@cert.vigilfuoco.it' => 'BL',
                'com.padova@cert.vigilfuoco.it'  => 'PD',
                'com.rovigo@cert.vigilfuoco.it'  => 'RO',
                'com.treviso@cert.vigilfuoco.it' => 'TV',
                'com.venezia@cert.vigilfuoco.it' => 'VE',
                'com.vicenza@cert.vigilfuoco.it' => 'VI',
                'com.verona@cert.vigilfuoco.it'  => 'VR',
            ];

            try {
                $rowsVvf  = DB::select($sqlVvf);
                $values   = array_fill_keys($province, 0);

                foreach ($rowsVvf as $row) {
                    $sender = $row->sender;
                    $total  = (int) $row->total;

                    $sigla = $vvfSenderToProv[$sender] ?? null;
                    if (! $sigla || ! in_array($sigla, $province, true)) {
                        continue;
                    }

                    $values[$sigla] = $total;
                }

                // una sola riga: "numero interventi"
                $vvfMatrix[] = [
                    'label'  => 'numero interventi',
                    'values' => $values,
                ];
            } catch (\Throwable $e) {
                $vvfMatrix = [];
            }

            /*
            |------------------------------------------------------------------
            | 3. Eventi segnalati – $eventi_sintetico
            |------------------------------------------------------------------
            */
            $eventiMatrix = [];

            $sqlEventi = <<<'SQL'
SELECT
    t.descrizione    AS label,
    prov."Sigla"     AS sigla,
    COUNT(*)         AS total
FROM segnalazioni.evento e
JOIN segnalazioni.tbl_tipi_eventi t
      ON e.tipo_evento = t.id_tipi_eventi
JOIN "General_data"."Comuni_Veneto" c
      ON e.codistat = c."CodiceIstatC"
JOIN "General_data"."Province" prov
      ON prov."Codice Provincia" = c."Codice Provincia"
WHERE e.data_ora_chiusura IS NULL
GROUP BY t.descrizione, prov."Sigla"
ORDER BY t.descrizione, prov."Sigla";
SQL;

            try {
                $rowsEventi = DB::select($sqlEventi);
                $tmp        = [];

                foreach ($rowsEventi as $row) {
                    $label = $row->label;
                    $sigla = $row->sigla;
                    $tot   = (int) $row->total;

                    if (! in_array($sigla, $province, true)) {
                        continue;
                    }

                    if (! isset($tmp[$label])) {
                        $tmp[$label] = [
                            'label'  => $label,
                            'values' => array_fill_keys($province, 0),
                        ];
                    }

                    $tmp[$label]['values'][$sigla] = $tot;
                }

                $eventiMatrix = array_values($tmp);
            } catch (\Throwable $e) {
                // se la tabella segnalazioni.evento non esiste o dà errore,
                // lasciamo semplicemente eventiMatrix vuota
                $eventiMatrix = [];
            }

            /*
            |------------------------------------------------------------------
            | 4. Squadre volontariato attivate – $attivazioni_sintetiche / _no
            |------------------------------------------------------------------
            | Uso una versione più leggibile ma equivalente:
            |  - prendo lo stato più recente da log_stato_attivazioni
            |  - filtro per codici stato
            |------------------------------------------------------------------
            */
            $volontMatrix = [];

            // Attivate: id_stato IN (700,800,550)
            $sqlVolAttive = <<<'SQL'
SELECT
    'Attivate' AS label,
    u."Sigla"  AS sigla,
    COALESCE(SUM(t."Numero squadre"), 0)
      + COALESCE(SUM(t."Numero Volontari"), 0) / 4.0 AS total
FROM "General_data"."TblAttivazione" t
JOIN "General_data"."Unione_Comuni_Enti_Vista" u
  ON t."ID_Zona" = u."CodiceIstatC"
JOIN "General_data".log_stato_attivazioni s
  ON s.id_attivazione = t."ID_Attivazione"
WHERE s.data_registrazione = (
        SELECT MAX(s2.data_registrazione)
        FROM "General_data".log_stato_attivazioni s2
        WHERE s2.id_attivazione = t."ID_Attivazione"
      )
  AND s.id_stato IN (700, 800, 550)
  AND t."DataInizio" <= NOW()
  AND (t."Datafineattivita" IS NULL
       OR t."Datafineattivita" + interval '24 hours' >= NOW())
GROUP BY u."Sigla"
ORDER BY u."Sigla";
SQL;

            // In corso di attivazione: NOT IN (700,800,550,200,900)
            $sqlVolInCorso = <<<'SQL'
SELECT
    'In corso di attivazione' AS label,
    u."Sigla"                 AS sigla,
    COALESCE(SUM(t."Numero squadre"), 0)
      + COALESCE(SUM(t."Numero Volontari"), 0) / 4.0 AS total
FROM "General_data"."TblAttivazione" t
JOIN "General_data"."Unione_Comuni_Enti_Vista" u
  ON t."ID_Zona" = u."CodiceIstatC"
JOIN "General_data".log_stato_attivazioni s
  ON s.id_attivazione = t."ID_Attivazione"
WHERE s.data_registrazione = (
        SELECT MAX(s2.data_registrazione)
        FROM "General_data".log_stato_attivazioni s2
        WHERE s2.id_attivazione = t."ID_Attivazione"
      )
  AND s.id_stato NOT IN (700, 800, 550, 200, 900)
  AND t."DataInizio" <= NOW()
  AND (t."Datafineattivita" IS NULL
       OR t."Datafineattivita" + interval '24 hours' >= NOW())
GROUP BY u."Sigla"
ORDER BY u."Sigla";
SQL;

            try {
                $rowsA   = DB::select($sqlVolAttive);
                $rowsNo  = DB::select($sqlVolInCorso);
                $tmpVol  = [];

                foreach ([$rowsA, $rowsNo] as $rows) {
                    foreach ($rows as $row) {
                        $label = $row->label;
                        $sigla = $row->sigla;
                        $tot   = (float) $row->total;

                        if (! in_array($sigla, $province, true)) {
                            continue;
                        }

                        if (! isset($tmpVol[$label])) {
                            $tmpVol[$label] = [
                                'label'  => $label,
                                'values' => array_fill_keys($province, 0),
                            ];
                        }

                        $tmpVol[$label]['values'][$sigla] = $tot;
                    }
                }

                $volontMatrix = array_values($tmpVol);
            } catch (\Throwable $e) {
                $volontMatrix = [];
            }

            /*
            |------------------------------------------------------------------
            | 5. Cluster CAP VVF – $stato_comuni
            |------------------------------------------------------------------
            */
            $capMatrix = [];

            $sqlCap = <<<'SQL'
SELECT
    'comuni coinvolti' AS label,
    c."Sigla"          AS sigla,
    COUNT(*)           AS total
FROM cap_vvf.comuni_attualmente_interessati c
GROUP BY c."Sigla"
ORDER BY c."Sigla";
SQL;

            try {
                $rowsCap = DB::select($sqlCap);
                $values  = array_fill_keys($province, 0);

                foreach ($rowsCap as $row) {
                    $sigla = $row->sigla;
                    $tot   = (int) $row->total;

                    if (! in_array($sigla, $province, true)) {
                        continue;
                    }

                    $values[$sigla] = $tot;
                }

                $capMatrix[] = [
                    'label'  => 'comuni coinvolti',
                    'values' => $values,
                ];
            } catch (\Throwable $e) {
                $capMatrix = [];
            }

            // merge nei dati per la view
            $data = array_merge($data, [
                'province'      => $province,
                'provinceIndex' => $provinceIndex,
                'cocMatrix'     => $cocMatrix,
                'vvfMatrix'     => $vvfMatrix,
                'eventiMatrix'  => $eventiMatrix,
                'volontMatrix'  => $volontMatrix,
                'capMatrix'     => $capMatrix,
            ]);
        }

        /*
        |--------------------------------------------------------------------------|
        | PAGINA: APERTURA / CHIUSURA SOR
        |--------------------------------------------------------------------------|
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

            if (! $statoAttuale) {
                $statoAttuale = (object) [
                    'stato_sala_op'                  => 0,
                    'data_ora'                       => now(),
                    'nota_stato_sala_op'             => '',
                    'stato_descrizione'              => 'N/D',
                    'id_segnalazione_stato_sala_op'  => null,
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

            // Log coordinamento + dashboard (inclusi i sor_open / sor_close / sor_update)
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
        |--------------------------------------------------------------------------|
        | PAGINA: APERTURA / CHIUSURA COC (singolo comune)
        |--------------------------------------------------------------------------|
        */
        if (($current['view'] ?? null) === 'apertura-chiusura-coc') {

            /** @var \App\Models\User|null $user */
            $user = $request->user();

            // TODO: sostituisci con il tuo meccanismo reale (controlla_ente / campo user)
            $codistat = $user->codistat ?? '26026';

            // stato COC attuale
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

            // Segnalazioni / eventi del comune → per ora vuoto
            $segnalazioni = collect();
            $eventi       = collect();

            $data = array_merge($data, [
                'codistat'     => $codistat,
                'statoCoc'     => $statoCoc,
                'segnalazioni' => $segnalazioni,
                'eventi'       => $eventi,
            ]);
        }

        /*
        |--------------------------------------------------------------------------|
        | PAGINA: MONITORAGGIO COC (coc.coc_logs)
        |--------------------------------------------------------------------------|
        */
        if (($current['view'] ?? null) === 'monitoraggio-coc') {

            $defaultStart = Carbon::now()->startOfMonth();
            $defaultEnd   = Carbon::now()->endOfMonth()->setTime(23, 59, 59);

            $startInput = $request->input('start', $defaultStart->format('Y-m-d\TH:i'));
            $endInput   = $request->input('end',   $defaultEnd->format('Y-m-d\TH:i'));
            $action     = $request->input('action', 'ALL'); // ALL | open | close | update

            $start = Carbon::parse($startInput);
            $end   = Carbon::parse($endInput);

            $dataInizio = $startInput;
            $dataFine   = $endInput;

            $base = CocLog::query()
                ->whereBetween('created_at', [$start, $end]);

            if ($action !== 'ALL') {
                $base->where('action', $action);
            }

            $totalLogs   = (clone $base)->count();
            $totalOpens  = (clone $base)->where('action', 'open')->count();
            $totalCloses = (clone $base)->where('action', 'close')->count();
            $totalUpdate = (clone $base)->where('action', 'update')->count();

            // per stato finale (to_stato_id)
            $byStatus = (clone $base)
                ->select('to_stato_id', DB::raw('COUNT(*) as total'))
                ->groupBy('to_stato_id')
                ->orderBy('to_stato_id')
                ->get();

            // per fase operativa finale (to_fase_id)
            $byFase = (clone $base)
                ->select('to_fase_id', DB::raw('COUNT(*) as total'))
                ->groupBy('to_fase_id')
                ->orderBy('to_fase_id')
                ->get();

            // ultimi log
            $logs = (clone $base)
                ->orderByDesc('created_at')
                ->limit(300)
                ->get();

            $data = array_merge($data, [
                'start'       => $start,
                'end'         => $end,
                'action'      => $action,
                'totalLogs'   => $totalLogs,
                'totalOpens'  => $totalOpens,
                'totalCloses' => $totalCloses,
                'totalUpdate' => $totalUpdate,
                'byStatus'    => $byStatus,
                'byFase'      => $byFase,
                'logs'        => $logs,
                'dataInizio'  => $dataInizio,
                'dataFine'    => $dataFine,
            ]);
        }

        /*
        |--------------------------------------------------------------------------|
        | PAGINA: LOG STORICO SOR
        |--------------------------------------------------------------------------|
        */
        if (($current['view'] ?? null) === 'log') {
            $data['coordLogs'] = SorLog::orderByDesc('created_at')
                ->paginate(50, ['*'], 'coord_page');

            $data['dashboardLogs'] = SorDashboardLog::orderByDesc('created_at')
                ->paginate(50, ['*'], 'dash_page');
        }

        // layout principale delle segnalazioni
        return view('applicativi.segnalazioni.index', $data);
    }
}
