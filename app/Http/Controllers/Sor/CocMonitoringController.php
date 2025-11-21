<?php

namespace App\Http\Controllers;

use App\Models\CocActivation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CocMonitoringController extends Controller
{
    public function index(Request $request)
    {
        // Valori di default per la form (formato datetime-local)
        $dataInizio = $request->input('data_inizio', now()->subDay()->format('Y-m-d\TH:i'));
        $dataFine   = $request->input('data_fine',   now()->addDay()->format('Y-m-d\TH:i'));
        $provinciaSelezionata = $request->input('provincia', 'ALL');

        $start = Carbon::parse($dataInizio);
        $end   = Carbon::parse($dataFine);

        // Config comuni e province
        $province = array_keys(config('province'));
        $comuniConfig = collect(config('comuni_veneto'));

        // Query base per le attivazioni
        $query = CocActivation::query()
            ->whereBetween('opened_at', [$start, $end]);

        if ($provinciaSelezionata !== 'ALL') {
            $codistats = $comuniConfig
                ->where('provincia', $provinciaSelezionata)
                ->pluck('codistat')
                ->toArray();

            if (count($codistats)) {
                $query->whereIn('codistat', $codistats);
            } else {
                // nessun comune per quella provincia -> nessun risultato
                $query->whereRaw('1=0');
            }
        }

        $activations = $query->get();

        // Righe per tabella e mappa
        $comuniRows = $activations->map(function ($act) use ($comuniConfig) {
            $info = $comuniConfig->firstWhere('codistat', $act->codistat);

            return (object) [
                'prov'      => $info['provincia'] ?? null,
                'comune'    => $info['comune'] ?? ("Comune {$act->codistat}"),
                'categoria' => $act->categoria,
                'data'      => optional($act->opened_at)->format('d/m/Y H:i'),
                'lat'       => $act->lat ?? ($info['lat'] ?? null),
                'lon'       => $act->lon ?? ($info['lon'] ?? null),
            ];
        });

        // Statistiche per provincia
        $stats = [];
        foreach ($province as $p) {
            $stats[$p] = $comuniRows->where('prov', $p)->count();
        }

        $totale = array_sum($stats);

        return view('coc-monitoraggio', [
            'dataInizio'           => $dataInizio,
            'dataFine'             => $dataFine,
            'provinciaSelezionata' => $provinciaSelezionata,
            'stats'                => $stats,
            'totale'               => $totale,
            'province'             => $province,
            'comuniRows'           => $comuniRows,
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validazione dati in ingresso
        $data = $request->validate([
            'codistat'  => ['required', 'string', 'max:6'],
            'categoria' => ['nullable', 'string', 'max:255'],
            'opened_at' => ['required', 'date'],
            'closed_at' => ['nullable', 'date', 'after_or_equal:opened_at'],
            'note'      => ['nullable', 'string'],
        ]);

        // 2. Prendo info comune da config
        $comuniConfig = collect(config('comuni_veneto'));
        $infoComune   = $comuniConfig->firstWhere('codistat', $data['codistat']);

        $lat = $infoComune['lat'] ?? null;
        $lon = $infoComune['lon'] ?? null;

        // 3. Creo la riga (created_by richiesto dalla migration)
        CocActivation::create([
            'codistat'   => $data['codistat'],
            'categoria'  => $data['categoria'] ?? null,
            'opened_at'  => $data['opened_at'],
            'closed_at'  => $data['closed_at'] ?? null,
            'note'       => $data['note'] ?? null,
            'lat'        => $lat,
            'lon'        => $lon,
            'created_by' => Auth::id(), // obbligatorio per la foreign key
        ]);

        return redirect()
            ->route('coc.monitoraggio')
            ->with('status', 'COC registrato correttamente.');
    }
}
