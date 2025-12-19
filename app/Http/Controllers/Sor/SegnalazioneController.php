<?php

namespace App\Http\Controllers\Sor;

use App\Http\Controllers\Controller;
use App\Models\Sor\SegnalazioneGenerica;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SegnalazioneController extends Controller
{
    /**
     * GET /api/sor/segnalazioni
     * Lista paginata con filtri
     */
    public function index(Request $request)
    {
        $perPage = min($request->integer('per_page', 10), 100);

        $query = SegnalazioneGenerica::query()
            ->orderByDesc('creata_il')
            ->orderByDesc('id');

        // 🔍 filtro testuale
        if ($q = $request->string('q')->trim()) {
            $query->where(function ($q2) use ($q) {
                $q2->where('sintesi', 'ILIKE', "%{$q}%")
                    ->orWhere('oggetto', 'ILIKE', "%{$q}%")
                    ->orWhere('contenuto', 'ILIKE', "%{$q}%")
                    ->orWhere('mitt_dest', 'ILIKE', "%{$q}%")
                    ->orWhere('ente', 'ILIKE', "%{$q}%")
                    ->orWhere('comune', 'ILIKE', "%{$q}%");
            });
        }

        // 📅 filtri data (dal/al) o singola data
        if ($dal = $request->input('dal')) {
            $from = Carbon::parse($dal)->startOfDay();
            $query->where('creata_il', '>=', $from);
        }
        if ($al = $request->input('al')) {
            $to = Carbon::parse($al)->endOfDay();
            $query->where('creata_il', '<=', $to);
        }
        if ($date = $request->input('date')) {
            $d = Carbon::parse($date);
            $query->whereDate('creata_il', $d->toDateString());
        }

        // ⏰ solo ora (filtro globale)
        if ($time = $request->input('time')) {
            $query->whereTime('creata_il', substr($time, 0, 5) . ':00');
        }

        // 🏙️ comune
        if ($comune = $request->string('comune')->trim()) {
            $query->where('comune', 'ILIKE', "%{$comune}%");
        }

        $paginator = $query->paginate($perPage);

        return response()->json([
            'data' => $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
            ],
        ]);
    }

    /**
     * POST /api/sor/segnalazioni
     * Crea nuova segnalazione generica
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'creata_il'       => ['nullable', 'date'],
            'direzione'       => ['nullable', 'in:E,U'],
            'tipologia'       => ['nullable', 'string', 'max:100'],
            'aree'            => ['nullable', 'array'],
            'aree.*'          => ['string', 'max:255'],
            'sintesi'         => ['nullable', 'string'],
            'operatore'       => ['nullable', 'string', 'max:255'],
            'priorita'        => ['nullable', 'string', 'max:50'],
            'evento_id'       => ['nullable', 'integer'],

            'status'          => ['nullable', 'string', 'max:50'],
            'assigned_to'     => ['nullable', 'string', 'max:255'],
            'instructions'    => ['nullable', 'string'],
            'last_note_text'  => ['nullable', 'string'],
            'last_note_by'    => ['nullable', 'string', 'max:255'],
            'last_note_at'    => ['nullable', 'date'],

            'tipo'            => ['nullable', 'string', 'max:50'],
            'ente'            => ['nullable', 'string', 'max:255'],
            'mitt_dest'       => ['nullable', 'string', 'max:255'],
            'telefono'        => ['nullable', 'string', 'max:50'],
            'email'           => ['nullable', 'string', 'max:255'],
            'indirizzo'       => ['nullable', 'string', 'max:255'],
            'provincia'       => ['nullable', 'string', 'max:5'],
            'comune'          => ['nullable', 'string', 'max:255'],
            'oggetto'         => ['nullable', 'string'],
            'contenuto'       => ['nullable', 'string'],
            'campi_specifici' => ['nullable', 'array'],

            'lat'             => ['nullable', 'numeric'],
            'lng'             => ['nullable', 'numeric'],
        ]);

        if (empty($data['creata_il'])) {
            $data['creata_il'] = now();
        }

        $segnalazione = SegnalazioneGenerica::create($data);

        return response()->json($segnalazione, 201);
    }

    /**
     * PATCH /api/sor/segnalazioni/{segnalazione}
     */
    public function update(Request $request, SegnalazioneGenerica $segnalazione)
    {
        $data = $request->validate([
            'creata_il'       => ['sometimes', 'date'],
            'direzione'       => ['sometimes', 'in:E,U'],
            'tipologia'       => ['sometimes', 'string', 'max:100'],
            'aree'            => ['sometimes', 'array'],
            'aree.*'          => ['string', 'max:255'],
            'sintesi'         => ['sometimes', 'string'],
            'operatore'       => ['sometimes', 'string', 'max:255'],
            'priorita'        => ['sometimes', 'string', 'max:50'],
            'evento_id'       => ['sometimes', 'nullable', 'integer'],

            'status'          => ['sometimes', 'nullable', 'string', 'max:50'],
            'assigned_to'     => ['sometimes', 'nullable', 'string', 'max:255'],
            'instructions'    => ['sometimes', 'nullable', 'string'],
            'last_note_text'  => ['sometimes', 'nullable', 'string'],
            'last_note_by'    => ['sometimes', 'nullable', 'string', 'max:255'],
            'last_note_at'    => ['sometimes', 'nullable', 'date'],

            'tipo'            => ['sometimes', 'nullable', 'string', 'max:50'],
            'ente'            => ['sometimes', 'nullable', 'string', 'max:255'],
            'mitt_dest'       => ['sometimes', 'nullable', 'string', 'max:255'],
            'telefono'        => ['sometimes', 'nullable', 'string', 'max:50'],
            'email'           => ['sometimes', 'nullable', 'string', 'max:255'],
            'indirizzo'       => ['sometimes', 'nullable', 'string', 'max:255'],
            'provincia'       => ['sometimes', 'nullable', 'string', 'max:5'],
            'comune'          => ['sometimes', 'nullable', 'string', 'max:255'],
            'oggetto'         => ['sometimes', 'nullable', 'string'],
            'contenuto'       => ['sometimes', 'nullable', 'string'],
            'campi_specifici' => ['sometimes', 'nullable', 'array'],

            'lat'             => ['sometimes', 'nullable', 'numeric'],
            'lng'             => ['sometimes', 'nullable', 'numeric'],
        ]);

        $segnalazione->update($data);

        return response()->json($segnalazione);
    }

    /**
     * DELETE /api/sor/segnalazioni/{segnalazione}
     */
    public function destroy(SegnalazioneGenerica $segnalazione)
    {
        $segnalazione->delete();

        return response()->json([
            'deleted' => true,
        ]);
    }

    /**
     * GET /api/sor/segnalazioni/export.csv
     */
    public function export(Request $request): StreamedResponse
    {
        $query = SegnalazioneGenerica::query()
            ->orderByDesc('creata_il')
            ->orderByDesc('id');

        if ($q = $request->string('q')->trim()) {
            $query->where(function ($q2) use ($q) {
                $q2->where('sintesi', 'ILIKE', "%{$q}%")
                    ->orWhere('oggetto', 'ILIKE', "%{$q}%")
                    ->orWhere('contenuto', 'ILIKE', "%{$q}%")
                    ->orWhere('mitt_dest', 'ILIKE', "%{$q}%")
                    ->orWhere('ente', 'ILIKE', "%{$q}%")
                    ->orWhere('comune', 'ILIKE', "%{$q}%");
            });
        }

        if ($dal = $request->input('dal')) {
            $query->where('creata_il', '>=', Carbon::parse($dal)->startOfDay());
        }
        if ($al = $request->input('al')) {
            $query->where('creata_il', '<=', Carbon::parse($al)->endOfDay());
        }
        if ($comune = $request->string('comune')->trim()) {
            $query->where('comune', 'ILIKE', "%{$comune}%");
        }

        $filename = 'segnalazioni_generiche_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($query) {
            $out = fopen('php://output', 'w');

            // BOM per Excel
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($out, [
                'ID',
                'Data/Ora',
                'Direzione',
                'Tipologia',
                'Comune',
                'Provincia',
                'Aree',
                'Oggetto/Sintesi',
                'Priorità',
                'Operatore',
            ], ';');

            $query->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $r) {
                    fputcsv($out, [
                        $r->id,
                        optional($r->creata_il)->format('d/m/Y H:i'),
                        $r->direzione,
                        $r->tipologia,
                        $r->comune,
                        $r->provincia,
                        is_array($r->aree) ? implode(', ', $r->aree) : $r->aree,
                        $r->sintesi ?? $r->oggetto,
                        $r->priorita,
                        $r->operatore,
                    ], ';');
                }
            });

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
