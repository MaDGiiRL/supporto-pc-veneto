<?php

namespace App\Http\Controllers\Coc;

use App\Http\Controllers\Controller;
use App\Models\Coc\CocLog;
use App\Models\Coc\CocStato;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CocController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->validate([
            'stato_id'    => 'required|integer',   // 0 chiusa, 1 aperta diurna, 2 aperta h24...
            'fase_id'     => 'nullable|integer',   // 0 nessuna, 1 attenzione, 2 preallarme, 3 allarme...
            'decorrenza'  => 'required|date',      // solo data, l'ora la prendiamo dal server
            'nota_stato'  => 'nullable|string',
            'nota_fase'   => 'nullable|string',
        ]);

        // TODO: recupera il codistat reale dal profilo utente o dalla sessione
        /** @var \App\Models\User $user */
        $user = $request->user();
        $codistat = $user->codistat ?? '26026'; // <-- placeholder per test

        $now = Carbon::now();
        $decorrenza = Carbon::parse($data['decorrenza'])
            ->setTime($now->hour, $now->minute, $now->second);

        DB::transaction(function () use ($data, $codistat, $decorrenza, $now, $user) {

            // 1) Stato precedente
            $prev = CocStato::where('codistat', $codistat)
                ->orderByDesc('data_ora')
                ->orderByDesc('id')
                ->first();

            $fromStatoId    = $prev->stato_coc      ?? null;
            $fromFaseId     = $prev->fase_operativa ?? null;
            $fromDecorrenza = $prev->data_ora       ?? null;

            // descrizione "principale": per semplicità uso nota_stato
            $fromDescrizione = $prev->nota_stato ?? null;

            // 2) Inserisco nuovo stato
            $new = CocStato::create([
                'codistat'       => $codistat,
                'stato_coc'      => (int) $data['stato_id'],
                'fase_operativa' => (int) ($data['fase_id'] ?? 0),
                'nota_stato'     => $data['nota_stato'] ?? null,
                'nota_fase'      => $data['nota_fase'] ?? null,
                'data_ora'       => $decorrenza,
            ]);

            // 3) snapshot DOPO
            $toStatoId     = (int) $data['stato_id'];
            $toFaseId      = (int) ($data['fase_id'] ?? 0);
            $toDecorrenza  = $decorrenza;
            $toDescrizione = $data['nota_stato'] ?? null;

            // 4) action open / close / update
            $fromInt  = (int) ($fromStatoId ?? 0);
            $action   = 'update';

            if ($fromInt === 0 && $toStatoId !== 0) {
                $action = 'open';
            } elseif ($fromInt !== 0 && $toStatoId === 0) {
                $action = 'close';
            }

            // 5) Scrivo log per monitoraggio COC
            CocLog::create([
                'codistat'        => $codistat,
                'from_stato_id'   => $fromStatoId,
                'to_stato_id'     => $toStatoId,
                'from_fase_id'    => $fromFaseId,
                'to_fase_id'      => $toFaseId,
                'from_decorrenza' => $fromDecorrenza,
                'to_decorrenza'   => $toDecorrenza,
                'from_descrizione' => $fromDescrizione,
                'to_descrizione'  => $toDescrizione,
                'action'          => $action,
                'performed_by'    => $user?->name,
                'performed_by_id' => $user?->id,
                'created_at'      => $now,
            ]);
        });

        if ($request->expectsJson()) {
            return response()->json(['status' => 'ok']);
        }

        return back()->with('status', 'Stato COC aggiornato correttamente.');
    }
}
