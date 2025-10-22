<?php

namespace App\Http\Controllers\Sor;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EventoController extends Controller
{
    public function index(Request $r)
    {
        $q = Evento::query();

        if ($r->filled('q')) {
            $needle = mb_strtolower($r->string('q'));
            $q->where(function ($w) use ($needle) {
                $w->whereRaw('LOWER(descrizione) LIKE ?', ["%{$needle}%"])
                    ->orWhereRaw("EXISTS (SELECT 1 FROM jsonb_array_elements_text(aree) a WHERE LOWER(a.value) LIKE ?)", ["%{$needle}%"]);
            });
        }
        if ($r->filled('comune')) {
            $c = mb_strtolower($r->string('comune'));
            $q->whereRaw("EXISTS (SELECT 1 FROM jsonb_array_elements_text(aree) a WHERE LOWER(a.value) LIKE ?)", ["%{$c}%"]);
        }
        if ($r->filled('date')) {
            $q->whereDate('aggiornato_il', $r->date('date'));
        }
        if ($r->filled('time')) {
            $q->whereRaw("to_char(aggiornato_il, 'HH24:MI') = ?", [$r->string('time')]);
        }
        if ($r->filled('dal')) $q->where('aggiornato_il', '>=', $r->date('dal') . ' 00:00:00');
        if ($r->filled('al'))  $q->where('aggiornato_il', '<=', $r->date('al') . ' 23:59:59');

        // stato
        if ($r->string('status') === 'open')   $q->where('aperto', true);
        if ($r->string('status') === 'closed') $q->where('aperto', false);

        $q->orderByDesc('aggiornato_il')->orderByDesc('id');

        $res = $q->paginate((int)$r->integer('per_page', 10));

        return response()->json([
            'data' => $res->items(),
            'meta' => [
                'current_page' => $res->currentPage(),
                'last_page' => $res->lastPage(),
                'total' => $res->total(),
            ],
        ]);
    }

    public function show(int $id)
    {
        $ev = Evento::with(['comunicazioni' => function ($q) {
            $q->orderByDesc('comunicata_il')->orderByDesc('id');
        }])->findOrFail($id);

        return response()->json([
            'id' => $ev->id,
            'tipologia' => $ev->tipologia,
            'descrizione' => $ev->descrizione,
            'aree' => $ev->aree,
            'aperto' => $ev->aperto,
            'aggiornato_il' => $ev->aggiornato_il,
            'operatore' => $ev->operatore,
            'comunicazioni' => $ev->comunicazioni->toArray(),
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'tipologia' => 'required|string|max:50',
            'descrizione' => 'nullable|string',
            'aree' => 'array',
            'aperto' => 'boolean',
            'aggiornato_il' => 'nullable|date',
            'operatore' => 'nullable|string|max:120',
        ]);
        $data['aggiornato_il'] = $data['aggiornato_il'] ?? now();
        $ev = Evento::create($data);
        return response()->json($ev, 201);
    }

    public function toggle(int $id)
    {
        $ev = Evento::findOrFail($id);
        $ev->aperto = !$ev->aperto;
        $ev->aggiornato_il = now();
        $ev->save();
        return response()->json($ev);
    }

    public function export(Request $r): StreamedResponse
    {
        // usa gli stessi filtri dell’index
        $r2 = Request::create('', 'GET', $r->query());
        $data = $this->index($r2)->getData(true)['data'] ?? [];

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="eventi_in_atto.csv"',
        ];
        return response()->stream(function () use ($data) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($out, ['Tipologia', 'Aree', 'Descrizione', 'Aggiornamento', 'Stato'], ';');
            foreach ($data as $r) {
                fputcsv($out, [
                    $r['tipologia'] ?? '',
                    implode(', ', $r['aree'] ?? []),
                    $r['descrizione'] ?? '',
                    optional($r['aggiornato_il'] ?? null) ? date('d/m/Y H:i', strtotime($r['aggiornato_il'])) : '',
                    ($r['aperto'] ?? true) ? 'Aperto' : 'Chiuso',
                ], ';');
            }
            fclose($out);
        }, 200, $headers);
    }
}
