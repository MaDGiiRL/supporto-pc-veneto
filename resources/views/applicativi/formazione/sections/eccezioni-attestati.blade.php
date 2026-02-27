<section class="sec shadow-card">
    <div class="flex items-center justify-between gap-3 mb-3">
        <div>
            <h3 class="text-sm font-semibold">Eccezioni attestati</h3>
            <p class="text-xs opacity-70 mt-1">
                Gestione casi: volontari formati ma senza ODV iscritta all’Elenco Regionale (o iter non concluso).
            </p>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-4">
        <div class="grid md:grid-cols-2 gap-4">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <h4 class="font-semibold mb-2">Proposta tecnica (front)</h4>
                <ul class="list-disc pl-5 text-sm text-slate-700 space-y-1">
                    <li>Registro “Eccezioni” separato dalle statistiche standard (flag)</li>
                    <li>Iscrizione corso con “Associazione non in elenco” = selezione obbligatoria di un motivo</li>
                    <li>Attestato rilasciabile senza associare ODV “ufficiale” (se policy lo consente)</li>
                    <li>In export/statistiche: escludi o separa queste righe (tab dedicato)</li>
                </ul>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-4">
                <h4 class="font-semibold mb-2">Registro eccezioni (mock)</h4>
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead class="text-left">
                            <tr>
                                <th>Studente</th>
                                <th>Corso</th>
                                <th>Motivo</th>
                                <th>Stato</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>—</td>
                                <td>—</td>
                                <td>ODV non iscritta / iter</td>
                                <td><span class="tag">Da verificare</span></td>
                                <td><button class="btn-xs">Apri</button></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-sm opacity-70">Back: GET/POST /api/formazione/eccezioni-attestati</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4 text-xs opacity-70">
            Nota: questa sezione è “policy-driven”. Qui il front è predisposto per separare il dato dalle statistiche standard.
        </div>
    </div>
</section>