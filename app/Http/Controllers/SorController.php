<?php

namespace App\Http\Controllers;

use App\Models\Sor\SorDashboardLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SorController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->validate([
            'stato_id'    => 'required|integer',
            'decorrenza'  => 'required|date',
            'descrizione' => 'nullable|string',
            'rischi'      => 'array',
            'rischi.*'    => 'integer',
            'config_id'   => 'required|integer',
            'funzioni'    => 'array',
            'funzioni.*'  => 'integer',
        ]);

        // TODO: recupera l’ente reale (es. da utente loggato o da sessione)
        $enteOriginario = 30000;

        $now        = Carbon::now();
        $decorrenza = Carbon::parse($data['decorrenza'])
            ->setTime($now->hour, $now->minute, $now->second);

        $user = $request->user();

        DB::transaction(function () use ($data, $enteOriginario, $decorrenza, $now, $user) {

            // ==========================
            // 1) Stato precedente + snapshot per log
            // ==========================
            $statoPrecedente = DB::table('segnalazioni.stato_sala_operativa')
                ->where('codistat', $enteOriginario)
                ->orderBy('data_ora', 'desc')
                ->orderBy('segnalazione', 'desc') // se esiste questa colonna
                ->first();

            $fromStatoId        = $statoPrecedente->stato_sala_op ?? null;
            $fromDecorrenza     = $statoPrecedente ? Carbon::parse($statoPrecedente->data_ora) : null;
            $fromDescrizione    = $statoPrecedente->nota_stato_sala_op ?? null;

            $fromConfigId = null;
            $fromRischi   = [];
            $fromFunzioni = [];

            if ($statoPrecedente) {
                $idPrev = $statoPrecedente->id_segnalazione_stato_sala_op;

                // leggiamo CONFIG, RISCHI, FUNZIONI attivi PRIMA di chiuderli
                $fromConfigId = DB::table('segnalazioni.corem_configurazione')
                    ->where('id_segnalazione_stato_sala_op', $idPrev)
                    ->whereNull('data_fine')
                    ->orderBy('data_inizio', 'desc')
                    ->value('id_configurazione');

                $fromRischi = DB::table('segnalazioni.corem_rischio')
                    ->where('id_segnalazione_stato_sala_op', $idPrev)
                    ->whereNull('data_fine')
                    ->pluck('id_rischio')
                    ->map(fn($v) => (int) $v)
                    ->toArray();

                $fromFunzioni = DB::table('segnalazioni.corem_funzioni')
                    ->where('id_segnalazione_stato_sala_op', $idPrev)
                    ->whereNull('data_fine')
                    ->pluck('id_funzione')
                    ->map(fn($v) => (int) $v)
                    ->toArray();
            }

            // ==========================
            // 2) Chiudo i record attivi collegati allo stato precedente
            // ==========================
            if ($statoPrecedente) {
                $idPrev = $statoPrecedente->id_segnalazione_stato_sala_op;

                DB::table('segnalazioni.corem_rischio')
                    ->where('id_segnalazione_stato_sala_op', $idPrev)
                    ->whereNull('data_fine')
                    ->update(['data_fine' => $now]);

                DB::table('segnalazioni.corem_configurazione')
                    ->where('id_segnalazione_stato_sala_op', $idPrev)
                    ->whereNull('data_fine')
                    ->update(['data_fine' => $now]);

                DB::table('segnalazioni.corem_funzioni')
                    ->where('id_segnalazione_stato_sala_op', $idPrev)
                    ->whereNull('data_fine')
                    ->update(['data_fine' => $now]);
            }

            // ==========================
            // 3) Inserisco il nuovo stato SOR
            // ==========================
            DB::table('segnalazioni.stato_sala_operativa')->insert([
                'codistat'                   => $enteOriginario,
                'stato_sala_op'              => $data['stato_id'],
                'data_ora'                   => $decorrenza,
                'nota_stato_sala_op'         => $data['descrizione'] ?? null,
                // se hai altre colonne obbligatorie (es. utente, sorgente, ecc.) aggiungile qui
            ]);

            // Rileggo subito l’ultimo stato (che sarà quello appena inserito)
            $nuovoStato = DB::table('segnalazioni.stato_sala_operativa')
                ->where('codistat', $enteOriginario)
                ->orderBy('data_ora', 'desc')
                ->orderBy('segnalazione', 'desc')
                ->first();

            if (!$nuovoStato) {
                // qualcosa è andato storto, interrompo la transazione
                throw new \RuntimeException('Impossibile reperire il nuovo stato SOR appena inserito.');
            }

            $idNuovoStato = $nuovoStato->id_segnalazione_stato_sala_op;

            // ==========================
            // 4) Inserisco i nuovi rischi
            // ==========================
            $rischi = $data['rischi'] ?? [];
            foreach ($rischi as $idRischio) {
                DB::table('segnalazioni.corem_rischio')->insert([
                    'id_rischio'                    => $idRischio,
                    'id_segnalazione_stato_sala_op' => $idNuovoStato,
                    'data_inizio'                   => $decorrenza,
                    'data_fine'                     => null,
                ]);
            }

            // ==========================
            // 5) Inserisco la nuova configurazione operativa
            // ==========================
            if (!empty($data['config_id'])) {
                DB::table('segnalazioni.corem_configurazione')->insert([
                    'id_configurazione'             => $data['config_id'],
                    'id_segnalazione_stato_sala_op' => $idNuovoStato,
                    'data_inizio'                   => $decorrenza,
                    'data_fine'                     => null,
                ]);
            }

            // ==========================
            // 6) Inserisco le funzioni attivate
            // ==========================
            $funzioni = $data['funzioni'] ?? [];
            foreach ($funzioni as $idFunzione) {
                DB::table('segnalazioni.corem_funzioni')->insert([
                    'id_funzione'                   => $idFunzione,
                    'id_segnalazione_stato_sala_op' => $idNuovoStato,
                    'data_inizio'                   => $decorrenza,
                    'data_fine'                     => null,
                ]);
            }

            // ==========================
            // 7) Snapshot DOPO per log
            // ==========================
            $toStatoId        = (int) $data['stato_id'];
            $toDecorrenza     = $decorrenza;
            $toDescrizione    = $data['descrizione'] ?? null;
            $toConfigId       = $data['config_id'] ?? null;
            $toRischi         = array_map('intval', $rischi);
            $toFunzioni       = array_map('intval', $funzioni);

            // ==========================
            // 8) Determino tipo di azione: open / close / update
            // ==========================
            $fromStatoInt = (int) ($fromStatoId ?? 0);
            $action = 'sor_update';

            if ($fromStatoInt === 0 && $toStatoId !== 0) {
                $action = 'sor_open';
            } elseif ($fromStatoInt !== 0 && $toStatoId === 0) {
                $action = 'sor_close';
            }

            // ==========================
            // 9) Costruisco dettaglio testuale del log
            // ==========================
            $lines = [];

            $lines[] = "Aggiornamento SOR ente {$enteOriginario}";
            $lines[] = "Azione: {$action}";

            // Stato
            $lines[] = "Stato: " . ($fromStatoId ?? '—') . " → " . $toStatoId;

            // Config
            $lines[] = "Config: " . ($fromConfigId ?? '—') . " → " . ($toConfigId ?? '—');

            // Decorrenza
            $lines[] = "Decorrenza: " .
                ($fromDecorrenza ? $fromDecorrenza->format('d/m/Y H:i:s') : '—') .
                " → " .
                ($toDecorrenza ? $toDecorrenza->format('d/m/Y H:i:s') : '—');

            // Rischi
            $lines[] = "Rischi: [" . implode(', ', $fromRischi) . "] → [" . implode(', ', $toRischi) . "]";

            // Funzioni
            $lines[] = "Funzioni: [" . implode(', ', $fromFunzioni) . "] → [" . implode(', ', $toFunzioni) . "]";

            // Descrizione
            if (trim((string) $fromDescrizione) !== trim((string) $toDescrizione)) {
                $lines[] = "Descrizione (prima): " . ($fromDescrizione ?: '—');
                $lines[] = "Descrizione (dopo): " . ($toDescrizione ?: '—');
            }

            $details = implode("\n", $lines);

            // ==========================
            // 10) Scrivo il log in sor.sor_dashboard_logs
            // ==========================
            SorDashboardLog::create([
                'segnalazione_id' => null,
                'evento_id'       => null,

                // es: sor_open / sor_close / sor_update
                'action'          => $action,

                'from_status'     => $fromStatoId,
                'to_status'       => $toStatoId,
                'from_assignee'   => null,
                'to_assignee'     => null,

                'details'         => $details,
                'performed_by'    => $user?->name,
                'performed_by_id' => $user?->id,
                'created_at'      => $now,
                'updated_at'      => $now,
            ]);
        });

        return response()->json(['status' => 'ok']);
    }
}
