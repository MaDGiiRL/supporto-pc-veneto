<?php

namespace App\Http\Controllers\Sor;

use App\Http\Controllers\Controller;
use App\Models\SegnalazioneGenerica;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // ⬅️ IMPORTANTE
use Symfony\Component\HttpFoundation\StreamedResponse;

class SegnalazioneController extends Controller
{
    public function index(Request $r)
    {
        $q = SegnalazioneGenerica::query()->with('evento');

        // filtri semplici
        if ($r->filled('q')) {
            $needle = mb_strtolower($r->string('q'));
            $q->where(function ($w) use ($needle) {
                $w->whereRaw('LOWER(sintesi) LIKE ?', ["%{$needle}%"])
                    ->orWhereRaw('LOWER(operatore) LIKE ?', ["%{$needle}%"])
                    ->orWhereRaw("EXISTS (SELECT 1 FROM jsonb_array_elements_text(aree) a WHERE LOWER(a.value) LIKE ?)", ["%{$needle}%"]);
            });
        }
        if ($r->filled('comune')) {
            $c = mb_strtolower($r->string('comune'));
            $q->whereRaw("EXISTS (SELECT 1 FROM jsonb_array_elements_text(aree) a WHERE LOWER(a.value) LIKE ?)", ["%{$c}%"]);
        }
        if ($r->filled('date')) { // YYYY-MM-DD
            $q->whereDate('creata_il', $r->date('date'));
        }
        if ($r->filled('time')) { // HH:MM
            $q->whereRaw("to_char(creata_il, 'HH24:MI') = ?", [$r->string('time')]);
        }
        if ($r->filled('dal')) $q->where('creata_il', '>=', $r->date('dal') . ' 00:00:00');
        if ($r->filled('al'))  $q->where('creata_il', '<=', $r->date('al') . ' 23:59:59');

        $q->orderByDesc('creata_il');

        $perPage = (int) $r->integer('per_page', 10);
        $res = $q->paginate($perPage);

        return response()->json([
            'data' => $res->items(),
            'meta' => [
                'current_page' => $res->currentPage(),
                'last_page' => $res->lastPage(),
                'total' => $res->total(),
            ],
        ]);
    }


    public function store(Request $r)
    {
        $data = $r->validate([
            'creata_il' => 'nullable|date',
            'direzione' => 'required|in:E,U',
            'tipologia' => 'required|string|max:50',
            'aree'      => 'array',
            'sintesi'   => 'nullable|string',
            'priorita'  => 'required|in:Nessuna,Alta,Media,Bassa',
            'evento_id' => 'nullable|integer|exists:sor.eventi,id',
        ]);

        // 👉 qui aggiungi questa riga
        $data['operatore'] = optional($r->user())->name ?? optional($r->user())->email ?? 'sconosciuto';
        $data['creata_il'] = $data['creata_il'] ?? now();

        $sg = SegnalazioneGenerica::create($data);
        return response()->json($sg, 201);
    }


    public function update(Request $r, int $id)
    {
        $sg = SegnalazioneGenerica::findOrFail($id);

        $data = $r->validate([
            'creata_il' => 'nullable|date',
            'direzione' => 'nullable|in:E,U',
            'tipologia' => 'nullable|string|max:50',
            'aree'      => 'nullable|array',
            'sintesi'   => 'nullable|string',
            'priorita'  => 'nullable|in:Nessuna,Alta,Media,Bassa',
            'evento_id' => 'nullable|integer|exists:sor.eventi,id',
        ]);

        // 👉 qui blocchi eventuali override dal client
        if (array_key_exists('operatore', $data)) {
            unset($data['operatore']);
        }

        // 👉 qui aggiorni l’operatore con l’utente loggato
        $sg->operatore = optional($r->user())->name ?? optional($r->user())->email ?? $sg->operatore;

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
        // riusa i filtri dell’index
        $r2 = Request::create('', 'GET', $r->query());
        $data = $this->index($r2)->getData(true)['data'] ?? [];

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="segnalazioni_generiche.csv"',
        ];

        return response()->stream(function () use ($data) {
            $out = fopen('php://output', 'w');
            // BOM UTF-8
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($out, ['Data/Ora', 'Direzione', 'Tipologia', 'Aree', 'Sintesi', 'Operatore', 'Priorità', 'Evento'], ';');
            foreach ($data as $r) {
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
