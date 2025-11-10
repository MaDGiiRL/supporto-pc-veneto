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
                  ->orWhereRaw('LOWER(tipologia) LIKE ?', ["%{$needle}%"])
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

        if ($r->filled('dal')) $q->where('aggiornato_il', '>=', $r->date('dal') . ' 00:00:00');
        if ($r->filled('al'))  $q->where('aggiornato_il', '<=', $r->date('al')  . ' 23:59:59');

        // Niente filtro stato lato API: lo hai già lato client; se vuoi:
        // if ($r->filled('open')) $q->where('aperto', filter_var($r->boolean('open'), FILTER_VALIDATE_BOOLEAN));

        $q->orderByDesc('aggiornato_il')->orderByDesc('id');

        // consentiamo sia payload "array" che paginator come nel frontend
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

    public function show(int $id)
    {
        $ev = Evento::with(['comunicazioni', 'segnalazioni'])->findOrFail($id);
        return response()->json($ev);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'tipologia'   => 'required|string|max:50',
            'descrizione' => 'nullable|string',
            'aree'        => 'array',
            'aperto'      => 'boolean',
        ]);

        $data['aggiornato_il'] = now();
        $data['operatore']     = optional($r->user())->name ?? optional($r->user())->email ?? 'sconosciuto';

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
        // riusa la index per rispettare gli stessi filtri
        $r2 = Request::create('', 'GET', $r->query());
        $payload = $this->index($r2)->getData(true);
        $rows = $payload['data'] ?? [];

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="eventi.csv"',
        ];

        return response()->stream(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($out, ['ID', 'Tipologia', 'Descrizione', 'Aree', 'Aperto', 'Ultimo aggiornamento', 'Operatore'], ';');

            foreach ($rows as $r) {
                fputcsv($out, [
                    $r['id'] ?? '',
                    $r['tipologia'] ?? '',
                    $r['descrizione'] ?? '',
                    implode(', ', $r['aree'] ?? []),
                    isset($r['aperto']) ? ($r['aperto'] ? '1' : '0') : '',
                    optional($r['aggiornato_il'] ?? null) ? date('d/m/Y H:i', strtotime($r['aggiornato_il'])) : '',
                    $r['operatore'] ?? '',
                ], ';');
            }
            fclose($out);
        }, 200, $headers);
    }

    public function exportSingle(int $id): StreamedResponse
    {
        $ev = Evento::with('comunicazioni')->findOrFail($id);
        $rows = $ev->comunicazioni->toArray();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="evento_'.$id.'_comunicazioni.csv"',
        ];

        return response()->stream(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($out, ['Data', 'Ora', 'Tipo', 'Verso', 'Mitt/Dest', 'Telefono', 'Email', 'Aree', 'Oggetto', 'Priorità'], ';');

            foreach ($rows as $c) {
                $dt = isset($c['comunicata_il']) ? strtotime($c['comunicata_il']) : null;
                fputcsv($out, [
                    $dt ? date('d/m/Y', $dt) : '',
                    $dt ? date('H:i', $dt) : '',
                    $c['tipo'] ?? '',
                    $c['verso'] ?? '',
                    $c['mitt_dest'] ?? '',
                    $c['telefono'] ?? '',
                    $c['email'] ?? '',
                    implode(', ', $c['aree'] ?? []),
                    $c['oggetto'] ?? '',
                    $c['priorita'] ?? 'Nessuna',
                ], ';');
            }
            fclose($out);
        }, 200, $headers);
    }
}
