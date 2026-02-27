{{-- resources/views/applicativi/formazione/partials/modals.blade.php --}}

{{-- MODALE: crea/modifica corso --}}
<div class="c-modal hidden" id="modal-corso" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true" style="max-width:60rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h3 class="mb-2 text-lg font-semibold">Corso</h3>
        <p class="text-xs opacity-70 mb-4">Apertura/chiusura e modifiche: UI abilitata (controllo reale lato back).</p>

        <form id="form-corso" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" name="id" />

            <label class="grid gap-1.5 md:col-span-2">
                <span class="label">Titolo corso</span>
                <input class="input" name="titolo" placeholder="Es. Base Protezione Civile" />
            </label>

            <label class="grid gap-1.5">
                <span class="label">Data inizio</span>
                <input class="input" name="data_inizio" type="date" />
            </label>

            <label class="grid gap-1.5">
                <span class="label">Data fine</span>
                <input class="input" name="data_fine" type="date" />
            </label>

            <label class="grid gap-1.5 md:col-span-2">
                <span class="label">Sede corso</span>
                <input class="input" name="sede" placeholder="Indirizzo sede del corso" />
            </label>

            <label class="grid gap-1.5">
                <span class="label">Comune</span>
                <input class="input" name="comune" placeholder="Comune" />
            </label>

            <label class="grid gap-1.5">
                <span class="label">Stato</span>
                <select class="input" name="stato">
                    <option value="bozza">Bozza</option>
                    <option value="aperto">Aperto iscrizioni</option>
                    <option value="in_corso">In corso</option>
                    <option value="concluso">Concluso</option>
                </select>
            </label>

            <label class="grid gap-1.5 md:col-span-2">
                <span class="label">Descrizione</span>
                <textarea class="input" name="descrizione" rows="4" placeholder="Note, prerequisiti, ecc."></textarea>
            </label>

            <div class="md:col-span-2 flex justify-end gap-2 pt-2">
                <button type="button" class="btn" data-close-modal>Chiudi</button>
                <button type="reset" class="btn">Reset</button>
                <button type="submit" class="btn btn-primary">💾 Salva</button>
            </div>
        </form>
    </div>
</div>

{{-- MODALE: iscrizione (associazione obbligatoria) --}}
<div class="c-modal hidden" id="modal-iscrizione" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true" style="max-width:60rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h3 class="mb-2 text-lg font-semibold">Iscrizione studente</h3>
        <p class="text-xs opacity-70 mb-4">
            Per iscriversi è obbligatorio selezionare l’associazione di appartenenza (da Elenco Regionale).
            Gestione eccezioni attestati nella sezione “Controlli”.
        </p>

        <form id="form-iscrizione" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" name="corso_id" />
            <input type="hidden" name="studente_id" />

            <label class="grid gap-1.5 md:col-span-2">
                <span class="label">Corso</span>
                <input class="input" name="corso_label" placeholder="Seleziona un corso..." />
            </label>

            <label class="grid gap-1.5 md:col-span-2">
                <span class="label">Studente</span>
                <input class="input" name="studente_label" placeholder="Cerca studente..." />
            </label>

            <label class="grid gap-1.5 md:col-span-2">
                <span class="label">Associazione di appartenenza (obbligatoria)</span>
                <select class="input" id="iscr-associazione" name="associazione_id" required>
                    <option value="">Seleziona associazione...</option>
                    {{-- DEMO --}}
                    <option value="1">ODV X</option>
                    <option value="2">ODV Y</option>
                </select>
                <span class="text-xs opacity-70 mt-1">
                    Default: se lo studente non risulta più iscritto ad alcuna associazione, non deve essere incluso tra i promossi/export.
                </span>
            </label>

            <label class="grid gap-1.5">
                <span class="label">Stato</span>
                <select class="input" name="stato">
                    <option value="iscritto">Iscritto</option>
                    <option value="ritirato">Ritirato</option>
                    <option value="ammesso">Ammesso</option>
                </select>
            </label>

            <label class="grid gap-1.5">
                <span class="label">Note</span>
                <input class="input" name="note" />
            </label>

            <div class="md:col-span-2 flex justify-end gap-2 pt-2">
                <button type="button" class="btn" data-close-modal>Chiudi</button>
                <button type="reset" class="btn">Reset</button>
                <button type="submit" class="btn btn-primary">💾 Salva iscrizione</button>
            </div>
        </form>
    </div>
</div>

{{-- MODALE: presenze (edit ore fino a conclusione corso) --}}
<div class="c-modal hidden" id="modal-presenze" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true" style="max-width:72rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h3 class="mb-2 text-lg font-semibold">Registro presenze</h3>
        <p class="text-xs opacity-70 mb-4">
            Correzione ore presenza: UI abilitata (vincoli reali lato back).
        </p>

        <form id="form-presenze" class="grid gap-4">
            <input type="hidden" name="corso_id" value="" />

            <div class="rounded-2xl border border-slate-200 bg-white p-3">
                <div class="flex flex-wrap items-end gap-2">
                    <label class="grid gap-1.5">
                        <span class="label">Filtro studente</span>
                        <input class="input" name="q" placeholder="Cerca..." />
                    </label>
                    <label class="grid gap-1.5">
                        <span class="label">Data lezione</span>
                        <input class="input" name="data" type="date" />
                    </label>
                    <div class="ml-auto text-sm opacity-70">Modifica ore: <strong>inline</strong></div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="table">
                    <thead class="text-left">
                        <tr>
                            <th>Studente</th>
                            <th>Associazione (iscrizione)</th>
                            <th>Ore previste</th>
                            <th>Ore presenti</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- demo row --}}
                        <tr>
                            <td>Mario Rossi</td>
                            <td>ODV X</td>
                            <td>4</td>
                            <td>
                                <input class="input" style="max-width:9rem" name="ore_presenti_demo" placeholder="es. 2.5" value="3.5" />
                            </td>
                            <td><input class="input" name="note_demo" placeholder="correzione..." /></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" class="btn" data-close-modal>Chiudi</button>
                <button type="submit" class="btn btn-primary">💾 Salva presenze</button>
            </div>
        </form>
    </div>
</div>