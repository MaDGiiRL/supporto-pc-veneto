<?php

namespace App\Http\Controllers\Sor;

use App\Http\Controllers\Controller;
use App\Models\Comunicazione;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ComunicazioniController extends Controller
{

    // app/Http/Controllers/Sor/ComunicazioniController.php

    public function index(Request $r)
    {
        $q = Comunicazione::query()
            ->with(['evento:id,tipologia,descrizione,aree,aperto,aggiornato_il']);

        if ($r->filled('q')) {
            $needle = mb_strtolower($r->string('q'));
            $q->where(function ($w) use ($needle) {
                $w->whereRaw('LOWER(oggetto) LIKE ?', ["%{$needle}%"])
                    ->orWhereRaw('LOWER(contenuto) LIKE ?', ["%{$needle}%"])
                    ->orWhereRaw('LOWER(mitt_dest) LIKE ?', ["%{$needle}%"])
                    ->orWhereRaw('LOWER(tipo) LIKE ?', ["%{$needle}%"])
                    ->orWhereRaw("EXISTS (SELECT 1 FROM jsonb_array_elements_text(aree) a WHERE LOWER(a.value) LIKE ?)", ["%{$needle}%"]);
            });
        }
        if ($r->filled('comune')) {
            $c = mb_strtolower($r->string('comune'));
            $q->whereRaw("EXISTS (SELECT 1 FROM jsonb_array_elements_text(aree) a WHERE LOWER(a.value) LIKE ?)", ["%{$c}%"]);
        }
        if ($r->filled('date')) {
            $q->whereDate('comunicata_il', $r->date('date'));
        }
        if ($r->filled('time')) {
            $q->whereRaw("to_char(comunicata_il, 'HH24:MI') = ?", [$r->string('time')]);
        }
        if ($r->filled('dal')) $q->where('comunicata_il', '>=', $r->date('dal') . ' 00:00:00');
        if ($r->filled('al'))  $q->where('comunicata_il', '<=', $r->date('al') . ' 23:59:59');

        // filtro per evento specifico (opzionale)
        if ($r->filled('evento_id')) {
            $q->where('evento_id', (int)$r->integer('evento_id'));
        }

        $q->orderByDesc('comunicata_il')->orderByDesc('id');

        $res = $q->paginate((int)$r->integer('per_page', 20));

        return response()->json([

            'data' => $res->items(),
            'meta' => [
                'current_page' => $res->currentPage(),
                'last_page' => $res->lastPage(),
                'total' => $res->total(),
            ],
        ]);
    }

    public function store(Request $r, int $evento)
    {
        $ev = Evento::findOrFail($evento);

        $data = $r->validate([
            'comunicata_il' => 'nullable|date',
            'tipo'          => 'nullable|string|max:40',
            'verso'         => 'required|in:Entrata,Uscita',
            'mitt_dest'     => 'nullable|string|max:160',
            'telefono'      => 'nullable|string|max:60',
            'email'         => 'nullable|email|max:160',
            'indirizzo'     => 'nullable|string|max:240',
            'provincia'     => 'nullable|string|max:4',
            'comune'        => 'nullable|string|max:120',
            'aree'          => 'array',
            'oggetto'       => 'nullable|string|max:240',
            'contenuto'     => 'nullable|string',
            'priorita'      => 'required|in:Nessuna,Alta,Media,Bassa',
        ]);

        // 👉 qui aggiungi l’operatore loggato
        $data['operatore'] = optional($r->user())->name ?? optional($r->user())->email ?? 'sconosciuto';
        $data['evento_id'] = $ev->id;
        $data['comunicata_il'] = $data['comunicata_il'] ?? now();

        $com = Comunicazione::create($data);

        // aggiorna evento
        $ev->aggiornato_il = now();
        $ev->aperto = true;
        $ev->save();

        return response()->json($com, 201);
    }


    public function update(Request $r, int $evento, int $id)
    {
        // garantisco appartenenza all'evento
        $ev  = Evento::findOrFail($evento);
        $com = Comunicazione::where('evento_id', $evento)->findOrFail($id);

        $data = $r->validate([
            'comunicata_il' => 'nullable|date',
            'tipo'          => 'nullable|string|max:40',
            'verso'         => ['nullable', Rule::in(['Entrata', 'Uscita'])],
            'mitt_dest'     => 'nullable|string|max:160',
            'telefono'      => 'nullable|string|max:60',
            'email'         => 'nullable|email|max:160',
            'indirizzo'     => 'nullable|string|max:240',
            'provincia'     => 'nullable|string|max:4',
            'comune'        => 'nullable|string|max:120',
            'aree'          => 'nullable|array',
            'oggetto'       => 'nullable|string|max:240',
            'contenuto'     => 'nullable|string',
            'priorita'      => ['nullable', Rule::in(['Nessuna', 'Alta', 'Media', 'Bassa'])],
        ]);

        // aggiorno solo i campi presenti
        $com->fill(array_filter($data, fn($v) => $v !== null));
        $com->save();

        // touch evento
        $ev->aggiornato_il = now();
        $ev->save();

        return response()->json($com);
    }

    public function destroy(int $evento, int $id)
    {
        $ev  = Evento::findOrFail($evento);
        $com = Comunicazione::where('evento_id', $evento)->findOrFail($id);

        $com->delete();

        // touch evento
        $ev->aggiornato_il = now();
        $ev->save();

        return response()->noContent();
    }
}
