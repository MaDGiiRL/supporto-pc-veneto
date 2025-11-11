<?php

namespace App\Http\Controllers\Sor;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\SegnalazioneGenerica;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SegnalazioneController extends Controller
{
    // normalizza e accetta sia event_id che evento_id
    protected function normalizeEventoId(Request $r): ?int
    {
        $eid = $r->input('evento_id', $r->input('event_id'));
        if ($eid === null || $eid === '' || $eid === '__new__') return null;
        return is_numeric($eid) ? (int)$eid : null;
    }

    public function index(Request $r)
    {
        $q = SegnalazioneGenerica::query()->with('evento');

        if ($r->filled('status'))      { $q->where('status', $r->string('status')); }
        if ($r->filled('assigned_to')) {
            $q->where('assigned_to', $r->string('assigned_to'));
        }

        if ($r->filled('q')) {
            $needle = mb_strtolower($r->string('q'));
            $q->where(function ($w) use ($needle) {
                $w->whereRaw('LOWER(sintesi) LIKE ?', ["%{$needle}%"])
                  ->orWhereRaw('LOWER(operatore) LIKE ?', ["%{$needle}%"])
                  ->orWhereRaw("
                    EXISTS (
                      SELECT 1
                      FROM jsonb_array_elements_text(COALESCE(aree, '[]'::jsonb)) a
                      WHERE LOWER(a.value) LIKE ?
                    )
                  ", ["%{$needle}%"]);
            });
        }

        if ($r->filled('comune')) {
            $c = mb_strtolower($r->string('comune'));
            $q->whereRaw("
              EXISTS (
                SELECT 1
                FROM jsonb_array_elements_text(COALESCE(aree, '[]'::jsonb)) a
                WHERE LOWER(a.value) LIKE ?
              )", ["%{$c}%"]);
        }

        if ($r->filled('date')) { $q->whereDate('creata_il', $r->date('date')); }
        if ($r->filled('time')) { $q->whereRaw("to_char(creata_il, 'HH24:MI') = ?", [$r->string('time')]); }
        if ($r->filled('dal')) $q->where('creata_il', '>=', $r->date('dal') . ' 00:00:00');
        if ($r->filled('al'))  $q->where('creata_il', '<=', $r->date('al') . ' 23:59:59');

        if ($r->filled('evento_id')) {
            $q->where('evento_id', (int)$r->integer('evento_id'));
        }

        $q->orderByDesc('creata_il')->orderByDesc('id');

        $perPage = (int) $r->integer('per_page', 10);
        $res = $q->paginate($perPage);

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
        ]);

        // ⚠️ niente "exists:sor.eventi,id" nel validator → controlliamo via Model
        if ($evento_id !== null && !Evento::whereKey($evento_id)->exists()) {
            return response()->json(['message' => 'evento_id non valido'], 422);
        }

        $data['evento_id'] = $evento_id;
        $data['operatore'] = optional($r->user())->name ?? optional($r->user())->email ?? 'sconosciuto';
        $data['creata_il'] = $data['creata_il'] ?? now();

        $sg = SegnalazioneGenerica::create($data);
        return response()->json($sg, 201);
    }

    public function update(Request $r, int $id)
    {
        $sg = SegnalazioneGenerica::findOrFail($id);
        $evento_id = $this->normalizeEventoId($r);

        $data = $r->validate([
            'creata_il' => 'nullable|date',
            'direzione' => 'nullable|in:E,U',
            'tipologia' => 'nullable|string|max:50',
            'aree'      => 'nullable|array',
            'sintesi'   => 'nullable|string',
            'priorita'  => 'nullable|in:Nessuna,Alta,Media,Bassa',
        ]);

        // autore ultimo aggiornamento
        $sg->operatore = optional($r->user())->name ?? optional($r->user())->email ?? $sg->operatore;

        // Se c'è stato un tentativo di toccare l'associazione, validiamo via Model
        if ($r->has('evento_id') || $r->has('event_id')) {
            if ($evento_id !== null && !Evento::whereKey($evento_id)->exists()) {
                return response()->json(['message' => 'evento_id non valido'], 422);
            }
            $data['evento_id'] = $evento_id; // può essere anche null per rimuovere
        }

        $sg->fill(array_filter($data, fn($v) => $v !== null));
        $sg->save();

        return response()->json($sg);
    }

    public function destroy(int $id)
    {
        SegnalazioneGenerica::findOrFail($id)->delete();
        return response()->noContent();
    }

    public function export(Request $r): StreamedResponse
    {
        // riusa la query di index per coerenza filtri
        $r2 = Request::create('', 'GET', $r->query());
        $payload = $this->index($r2)->getData(true);
        $rows = $payload['data'] ?? [];

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="segnalazioni_generiche.csv"',
        ];

        return response()->stream(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8
            fputcsv($out, ['Data/Ora', 'Direzione', 'Tipologia', 'Aree', 'Sintesi', 'Operatore', 'Priorità', 'Evento'], ';');

            foreach ($rows as $r) {
                fputcsv($out, [
                    optional($r['creata_il'] ?? null) ? date('d/m/Y H:i', strtotime($r['creata_il'])) : '',
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
