<?php

namespace App\Http\Controllers\Sor;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\SegnalazioneGenerica;
use App\Services\Sor\DashboardLogService;   // ⬅️ IMPORT SERVIZIO
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SegnalazioneController extends Controller
{
    protected DashboardLogService $dashLog;

    public function __construct(DashboardLogService $dashLog)
    {
        $this->dashLog = $dashLog;
    }

    // normalizza e accetta sia event_id che evento_id
    protected function normalizeEventoId(Request $r): ?int
    {
        $eid = $r->input('evento_id', $r->input('event_id'));
        if ($eid === null || $eid === '' || $eid === '__new__') {
            return null;
        }

        return is_numeric($eid) ? (int) $eid : null;
    }

    public function index(Request $r)
    {
        $q = SegnalazioneGenerica::query()->with('evento');

        // filtri coordinamento (status / assegnatario)
        if ($r->filled('status')) {
            $q->where('status', $r->string('status'));
        }

        if ($r->filled('assigned_to')) {
            $q->where('assigned_to', $r->string('assigned_to'));
        }

        // ricerca testuale
        if ($r->filled('q')) {
            $needle = mb_strtolower($r->string('q'));

            $q->where(function ($w) use ($needle) {
                $w->whereRaw('LOWER(sintesi) LIKE ?', ["%{$needle}%"])
                    ->orWhereRaw('LOWER(operatore) LIKE ?', ["%{$needle}%"])
                    ->orWhereRaw('LOWER(ente) LIKE ?', ["%{$needle}%"])
                    ->orWhereRaw('LOWER(oggetto) LIKE ?', ["%{$needle}%"])
                    ->orWhereRaw('LOWER(contenuto) LIKE ?', ["%{$needle}%"])
                    ->orWhereRaw("
                    EXISTS (
                      SELECT 1
                      FROM jsonb_array_elements_text(COALESCE(aree, '[]'::jsonb)) a
                      WHERE LOWER(a.value) LIKE ?
                    )
                  ", ["%{$needle}%"]);
            });
        }

        // filtro per comune (campo dedicato + dentro aree)
        if ($r->filled('comune')) {
            $c = mb_strtolower($r->string('comune'));

            $q->where(function ($w) use ($c) {
                $w->whereRaw('LOWER(comune) LIKE ?', ["%{$c}%"])
                    ->orWhereRaw("
                    EXISTS (
                      SELECT 1
                      FROM jsonb_array_elements_text(COALESCE(aree, '[]'::jsonb)) a
                      WHERE LOWER(a.value) LIKE ?
                    )
                  ", ["%{$c}%"]);
            });
        }

        // filtri temporali
        if ($r->filled('date')) {
            $q->whereDate('creata_il', $r->date('date'));
        }

        if ($r->filled('time')) {
            $q->whereRaw("to_char(creata_il, 'HH24:MI') = ?", [$r->string('time')]);
        }

        if ($r->filled('dal')) {
            $q->where('creata_il', '>=', $r->date('dal') . ' 00:00:00');
        }

        if ($r->filled('al')) {
            $q->where('creata_il', '<=', $r->date('al') . ' 23:59:59');
        }

        // filtro per evento
        if ($r->filled('evento_id')) {
            $q->where('evento_id', (int) $r->integer('evento_id'));
        }

        $q->orderByDesc('creata_il')->orderByDesc('id');

        $perPage = (int) $r->integer('per_page', 10);
        $res     = $q->paginate($perPage);

        return response()->json([
            'data' => $res->items(),
            'meta' => [
                'current_page' => $res->currentPage(),
                'last_page'    => $res->lastPage(),
                'total'        => $res->total(),
            ],
        ]);
    }

    public function store(Request $r)
    {
        $evento_id = $this->normalizeEventoId($r);

        $data = $r->validate([
            'creata_il' => 'nullable|date',
            'direzione' => 'required|in:E,U',
            'tipologia' => 'required|string|max:50',
            'aree'      => 'array',
            'sintesi'   => 'nullable|string',
            'priorita'  => 'required|in:Nessuna,Alta,Media,Bassa',

            // campi “comunicazione”
            'tipo'            => 'nullable|string|max:40',
            'ente'            => 'nullable|string|max:255',
            'mitt_dest'       => 'nullable|string|max:255',
            'telefono'        => 'nullable|string|max:60',
            'email'           => 'nullable|email|max:160',
            'indirizzo'       => 'nullable|string|max:240',
            'provincia'       => 'nullable|string|max:4',
            'comune'          => 'nullable|string|max:120',
            'oggetto'         => 'nullable|string|max:240',
            'contenuto'       => 'nullable|string',
            'campi_specifici' => 'nullable|array',
        ]);

        // controllo manuale sull'evento (evento opzionale)
        if ($evento_id !== null && !Evento::whereKey($evento_id)->exists()) {
            return response()->json(['message' => 'evento_id non valido'], 422);
        }

        // fallback sintesi = oggetto / contenuto se vuota
        if (empty($data['sintesi'])) {
            $data['sintesi'] = $data['oggetto'] ?? $data['contenuto'] ?? null;
        }

        $data['evento_id'] = $evento_id;

        $data['operatore'] = optional($r->user())->name
            ?? optional($r->user())->email
            ?? 'sconosciuto';

        $data['creata_il'] = $data['creata_il'] ?? now();

        $sg = SegnalazioneGenerica::create($data);

        // ⬇️ LOG DASHBOARD: creazione segnalazione
        $this->dashLog->log('created_segnalazione', [
            'segnalazione_id' => $sg->id,
            'evento_id'       => $evento_id,
            'details'         => $sg->oggetto ?: $sg->sintesi ?: null,
        ]);

        return response()->json($sg, 201);
    }

    public function update(Request $r, int $id)
    {
        $sg        = SegnalazioneGenerica::findOrFail($id);
        $evento_id = $this->normalizeEventoId($r);

        // snapshot BEFORE per capire cosa è cambiato
        $beforeEvento = $sg->evento_id;
        $beforeStatus = $sg->status;
        $beforeAss    = $sg->assigned_to;

        $data = $r->validate([
            'creata_il' => 'nullable|date',
            'direzione' => 'nullable|in:E,U',
            'tipologia' => 'nullable|string|max:50',
            'aree'      => 'nullable|array',
            'sintesi'   => 'nullable|string',
            'priorita'  => 'nullable|in:Nessuna,Alta,Media,Bassa',

            // campi “comunicazione”
            'tipo'            => 'nullable|string|max:40',
            'ente'            => 'nullable|string|max:255',
            'mitt_dest'       => 'nullable|string|max:255',
            'telefono'        => 'nullable|string|max:60',
            'email'           => 'nullable|email|max:160',
            'indirizzo'       => 'nullable|string|max:240',
            'provincia'       => 'nullable|string|max:4',
            'comune'          => 'nullable|string|max:120',
            'oggetto'         => 'nullable|string|max:240',
            'contenuto'       => 'nullable|string',
            'campi_specifici' => 'nullable|array',
        ]);

        // autore ultimo aggiornamento
        $sg->operatore = optional($r->user())->name
            ?? optional($r->user())->email
            ?? $sg->operatore;

        // gestione associazione evento (anche per rimuovere)
        if ($r->has('evento_id') || $r->has('event_id')) {
            if ($evento_id !== null && !Evento::whereKey($evento_id)->exists()) {
                return response()->json(['message' => 'evento_id non valido'], 422);
            }
            $data['evento_id'] = $evento_id; // anche null ⇒ sg scollegata da evento
        }

        // se sintesi viene omessa ma oggetto / contenuto arrivano, possiamo aggiornarla
        if (array_key_exists('oggetto', $data) || array_key_exists('contenuto', $data)) {
            if (empty($data['sintesi'])) {
                $data['sintesi'] = $data['oggetto'] ?? $data['contenuto'] ?? $sg->sintesi;
            }
        }

        $sg->fill(array_filter($data, fn($v) => $v !== null));
        $sg->save();

        // ⬇️ LOG DASHBOARD: modifica segnalazione
        $detailsParts = ['Modifica segnalazione da dashboard'];

        if ($beforeEvento !== $sg->evento_id) {
            if ($sg->evento_id && !$beforeEvento) {
                $detailsParts[] = "Collegata all'evento #{$sg->evento_id}";
            } elseif (!$sg->evento_id && $beforeEvento) {
                $detailsParts[] = "Scollegata dall'evento #{$beforeEvento}";
            } elseif ($sg->evento_id && $beforeEvento) {
                $detailsParts[] = "Ricollegata da evento #{$beforeEvento} a #{$sg->evento_id}";
            }
        }

        $this->dashLog->log('updated_segnalazione', [
            'segnalazione_id' => $sg->id,
            'evento_id'       => $sg->evento_id,
            'from_status'     => $beforeStatus,
            'to_status'       => $sg->status,
            'from_assignee'   => $beforeAss,
            'to_assignee'     => $sg->assigned_to,
            'details'         => implode(' | ', array_filter($detailsParts)),
        ]);

        return response()->json($sg);
    }

    public function destroy(int $id)
    {
        $sg = SegnalazioneGenerica::findOrFail($id);

        // ⬇️ LOG PRIMA DI CANCELLARE
        $this->dashLog->log('deleted_segnalazione', [
            'segnalazione_id' => $sg->id,
            'evento_id'       => $sg->evento_id,
            'details'         => $sg->oggetto ?: $sg->sintesi ?: 'Segnalazione eliminata',
        ]);

        $sg->delete();

        return response()->noContent();
    }

    public function export(Request $r): StreamedResponse
    {
        // riusa la query di index per coerenza filtri
        $r2      = Request::create('', 'GET', $r->query());
        $payload = $this->index($r2)->getData(true);
        $rows    = $payload['data'] ?? [];

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="segnalazioni_generiche.csv"',
        ];

        return response()->stream(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8

            fputcsv($out, [
                'Data/Ora',
                'Direzione',
                'Tipologia',
                'Aree',
                'Sintesi',
                'Operatore',
                'Priorità',
                'Evento',
            ], ';');

            foreach ($rows as $r) {
                $dt = isset($r['creata_il']) ? strtotime($r['creata_il']) : null;

                fputcsv($out, [
                    $dt ? date('d/m/Y H:i', $dt) : '',
                    $r['direzione'] ?? '',
                    $r['tipologia'] ?? '',
                    implode(', ', $r['aree'] ?? []),
                    $r['sintesi'] ?? '',
                    $r['operatore'] ?? '',
                    $r['priorita'] ?? 'Nessuna',
                    $r['evento_id'] ?? '',
                ], ';');
            }

            fclose($out);
        }, 200, $headers);
    }
}
