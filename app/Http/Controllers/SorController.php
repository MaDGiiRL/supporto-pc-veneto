<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        DB::transaction(function () use ($data, $enteOriginario, $decorrenza, $now) {

            // 1) Recupero l’ultimo stato SOR per l’ente (prima del nuovo inserimento)
            $statoPrecedente = DB::table('segnalazioni.stato_sala_operativa')
                ->where('codistat', $enteOriginario)
                ->orderBy('data_ora', 'desc')
                ->orderBy('segnalazione', 'desc') // se esiste questa colonna
                ->first();

            // 2) Chiudo i record attivi collegati allo stato precedente
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

            // 3) Inserisco il nuovo stato SOR
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

            // 4) Inserisco i nuovi rischi
            $rischi = $data['rischi'] ?? [];
            foreach ($rischi as $idRischio) {
                DB::table('segnalazioni.corem_rischio')->insert([
                    'id_rischio'                       => $idRischio,
                    'id_segnalazione_stato_sala_op'    => $idNuovoStato,
                    'data_inizio'                      => $decorrenza,
                    'data_fine'                        => null,
                ]);
            }

            // 5) Inserisco la nuova configurazione operativa
            if (!empty($data['config_id'])) {
                DB::table('segnalazioni.corem_configurazione')->insert([
                    'id_configurazione'                => $data['config_id'],
                    'id_segnalazione_stato_sala_op'    => $idNuovoStato,
                    'data_inizio'                      => $decorrenza,
                    'data_fine'                        => null,
                ]);
            }

            // 6) Inserisco le funzioni attivate
            $funzioni = $data['funzioni'] ?? [];
            foreach ($funzioni as $idFunzione) {
                DB::table('segnalazioni.corem_funzioni')->insert([
                    'id_funzione'                      => $idFunzione,
                    'id_segnalazione_stato_sala_op'    => $idNuovoStato,
                    'data_inizio'                      => $decorrenza,
                    'data_fine'                        => null,
                ]);
            }
        });

        return response()->json(['status' => 'ok']);
    }
}
