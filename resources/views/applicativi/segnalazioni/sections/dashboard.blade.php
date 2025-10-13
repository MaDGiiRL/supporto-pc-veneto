<div class="p-6" id="app">
    <header class="mb-4">
        <h2 class="text-xl font-semibold">Dashboard SOR</h2>
        <p class="text-sm opacity-75 mt-1">
            Eventi AIB, Segnalazioni generiche e Telefonate di reperibilità — tutto in una pagina.
        </p>
    </header>

    <!-- Barra azioni -->
    <div class="rounded-2xl border border-slate-200 bg-white shadow-card p-4 mb-4">
        <div class="flex flex-wrap items-center gap-2">
            <button class="btn" data-open-modal="#modal-aib">🔥 Nuova segnalazione AIB</button>
            <button class="btn" data-open-modal="#modal-gen">📝 Nuova segnalazione generica</button>
            <button class="btn btn-primary" data-open-modal="#modal-phone">📞 Nuova telefonata (reperibilità)</button>
        </div>
    </div>

    <!-- 🔎 Ricerca globale -->
    <div class="rounded-2xl border border-slate-200 bg-white shadow-card p-4 mb-6">
        <div class="grid md:grid-cols-4 gap-3">
            <label class="grid gap-1">
                <span class="label">Parola chiave (testi)</span>
                <input class="input" id="global-q" placeholder="Cerca in tutte le tabelle…" />
            </label>
            <label class="grid gap-1">
                <span class="label">Data</span>
                <input class="input" id="global-date" type="date" />
            </label>
            <label class="grid gap-1">
                <span class="label">Ora</span>
                <input class="input" id="global-time" type="time" />
            </label>
            <label class="grid gap-1">
                <span class="label">Comune</span>
                <input class="input" id="global-comune" placeholder="Comune…" list="comuni-datalist" />
            </label>
        </div>
        <div class="text-xs opacity-70 mt-2">La ricerca globale si somma ai filtri per-tabella.</div>
    </div>

    <!-- ========== TELEFONATE ========== -->
    <section class="sec sec--phone rounded-2xl bg-white shadow-card p-4 mb-6">
        <div class="flex items-center justify-between gap-3 mb-3">
            <h3 class="text-sm font-semibold">Telefonate reperibilità</h3>
            <div class="flex items-center gap-2">
                <button class="btn-xs" id="phone-export">⬇️ Scarica Excel</button>
                <button class="btn-xs" data-open-modal="#modal-phone">Nuova</button>
            </div>
        </div>

        <div class="flex flex-wrap items-end gap-2 mb-3">
            <label class="grid gap-1">
                <span class="label">Comune</span>
                <input class="input" id="phone-filter-comune" placeholder="Comune…" list="comuni-datalist" />
            </label>
            <label class="grid gap-1">
                <span class="label">Dal</span>
                <input class="input" id="phone-filter-dal" type="date" />
            </label>
            <label class="grid gap-1">
                <span class="label">Al</span>
                <input class="input" id="phone-filter-al" type="date" />
            </label>
            <div class="ml-auto text-sm opacity-70">10 per pagina</div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="tbl-phone">
                <thead class="text-left">
                    <tr>
                        <th class="px-3 py-2">Data/Ora</th>
                        <th class="px-3 py-2">E/U</th>
                        <th class="px-3 py-2">Ente</th>
                        <th class="px-3 py-2">Comune</th>
                        <th class="px-3 py-2">Sintesi</th>
                        <th class="px-3 py-2">Operatore</th>
                        <th class="px-3 py-2">Azioni</th>
                    </tr>
                </thead>
                <tbody id="phone-body"></tbody>
            </table>
        </div>

        <div class="pager">
            <button class="btn-xs" id="phone-prev">«</button>
            <span id="phone-page" class="pager__label">Pagina 1 di 1</span>
            <button class="btn-xs" id="phone-next">»</button>
        </div>
    </section>

    <!-- ========== SEGNALAZIONI GENERICHE ========== -->
    <section class="sec sec--gen rounded-2xl bg-white shadow-card p-4 mb-6">
        <div class="flex items-center justify-between gap-3 mb-3">
            <h3 class="text-sm font-semibold">Segnalazioni generiche</h3>
            <div class="flex items-center gap-2">
                <button class="btn-xs" id="gen-export">⬇️ Scarica Excel</button>
                <button class="btn-xs" data-open-modal="#modal-gen">Nuova</button>
            </div>
        </div>

        <div class="flex flex-wrap items-end gap-2 mb-3">
            <label class="grid gap-1">
                <span class="label">Comune</span>
                <input class="input" id="gen-filter-comune" placeholder="Comune…" list="comuni-datalist" />
            </label>
            <label class="grid gap-1">
                <span class="label">Dal</span>
                <input class="input" id="gen-filter-dal" type="date" />
            </label>
            <label class="grid gap-1">
                <span class="label">Al</span>
                <input class="input" id="gen-filter-al" type="date" />
            </label>
            <div class="ml-auto text-sm opacity-70">10 per pagina</div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="tbl-gen">
                <thead class="text-left">
                    <tr>
                        <th class="px-3 py-2">Data/Ora</th>
                        <th class="px-3 py-2">E/U</th>
                        <th class="px-3 py-2">Ente</th>
                        <th class="px-3 py-2">Comune</th>
                        <th class="px-3 py-2">Sintesi</th>
                        <th class="px-3 py-2">Operatore</th>
                        <th class="px-3 py-2">Azioni</th>
                    </tr>
                </thead>
                <tbody id="gen-body"></tbody>
            </table>
        </div>

        <div class="pager">
            <button class="btn-xs" id="gen-prev">«</button>
            <span id="gen-page" class="pager__label">Pagina 1 di 1</span>
            <button class="btn-xs" id="gen-next">»</button>
        </div>
    </section>

    <!-- ========== AIB ========== -->
    <section class="sec sec--aib rounded-2xl  bg-white shadow-card p-4 mb-6">
        <div class="flex items-center justify-between gap-3 mb-3">
            <h3 class="text-sm font-semibold">Eventi AIB</h3>
            <div class="flex items-center gap-2">
                <button class="btn-xs" id="aib-export">⬇️ Scarica Excel</button>
                <button class="btn-xs" data-open-modal="#modal-aib">Nuovo</button>
            </div>
        </div>

        <div class="flex flex-wrap items-end gap-2 mb-3">
            <label class="grid gap-1">
                <span class="label">Comune</span>
                <input class="input" id="aib-filter-comune" placeholder="Comune…" list="comuni-datalist" />
            </label>
            <label class="grid gap-1">
                <span class="label">Dal</span>
                <input class="input" id="aib-filter-dal" type="date" />
            </label>
            <label class="grid gap-1">
                <span class="label">Al</span>
                <input class="input" id="aib-filter-al" type="date" />
            </label>
            <div class="ml-auto text-sm opacity-70">10 per pagina</div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="tbl-aib">
                <thead class="text-left">
                    <tr>
                        <th class="px-3 py-2">Data/Ora</th>
                        <th class="px-3 py-2">Comune</th>
                        <th class="px-3 py-2">Località</th>
                        <th class="px-3 py-2">Sintesi</th>
                    </tr>
                </thead>
                <tbody id="aib-body"></tbody>
            </table>
        </div>

        <div class="pager">
            <button class="btn-xs" id="aib-prev">«</button>
            <span id="aib-page" class="pager__label">Pagina 1 di 1</span>
            <button class="btn-xs" id="aib-next">»</button>
        </div>
    </section>

    <!-- ========== EVENTI IN ATTO ========== -->
    <section class="sec sec--ongoing rounded-2xl border border-slate-200 bg-white shadow-card p-4 mb-6">
        <div class="flex items-center justify-between gap-3 mb-3">
            <h3 class="text-sm font-semibold">Eventi in atto</h3>
            <button class="btn-xs" id="ongoing-export">⬇️ Scarica Excel</button>
        </div>

        <div class="flex flex-wrap items-end gap-2 mb-3">
            <label class="grid gap-1">
                <span class="label">Comune</span>
                <input class="input" id="ongoing-filter-comune" placeholder="Comune…" list="comuni-datalist" />
            </label>
            <label class="grid gap-1">
                <span class="label">Dal</span>
                <input class="input" id="ongoing-filter-dal" type="date" />
            </label>
            <label class="grid gap-1">
                <span class="label">Al</span>
                <input class="input" id="ongoing-filter-al" type="date" />
            </label>
            <div class="ml-auto text-sm opacity-70">10 per pagina</div>
        </div>

        <!-- 🔁 CARDS al posto della tabella -->
        <div id="ongoing-cards" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3"></div>

        <div class="pager">
            <button class="btn-xs" id="ongoing-prev">«</button>
            <span id="ongoing-page" class="pager__label">Pagina 1 di 1</span>
            <button class="btn-xs" id="ongoing-next">»</button>
        </div>
        <div class="text-xs opacity-70 mt-2">Suggerimento: clicca una card per aprire i dettagli dell’evento.</div>
    </section>

</div>

<!-- ========== MODALI (HTML puro) ========== -->

<!-- TELEFONATA -->
<div class="c-modal hidden" id="modal-phone" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h3 class="mb-2 text-lg font-semibold">Telefonata reperibilità</h3>
        <p class="text-xs opacity-70 mb-4">Registrazione nuova telefonata</p>

        <form id="form-phone" class="grid gap-4 max-h-[70vh] overflow-auto">
            <div class="grid md:grid-cols-2 gap-4">
                <label class="grid gap-1.5"><span class="label">Entrata/Uscita</span>
                    <select name="direzione" class="input">
                        <option value="E">Entrata</option>
                        <option value="U">Uscita</option>
                    </select>
                </label>

                <label class="grid gap-1.5"><span class="label">Segnalante / Interlocutore (Ente)</span>
                    <input name="ente" class="input" required />
                </label>

                <label class="grid gap-1.5"><span class="label">Recapito telefonico</span>
                    <input name="telefono" class="input" />
                </label>

                <label class="grid gap-1.5"><span class="label">Comune</span>
                    <input name="comune" class="input" list="comuni-datalist" />
                </label>

                <label class="grid gap-1.5"><span class="label">Data chiamata</span>
                    <input name="data" class="input" type="date" />
                </label>

                <label class="grid gap-1.5"><span class="label">Ora chiamata</span>
                    <input name="ora" class="input" type="time" />
                </label>

                <label class="grid gap-1.5 md:col-span-2"><span class="label">Sintesi della telefonata</span>
                    <textarea name="sintesi" class="input" required></textarea>
                </label>
            </div>
            <div class="flex justify-end gap-2 mt-2">
                <button type="button" class="btn" data-close-modal>Chiudi</button>
                <button type="submit" class="btn btn-primary">Salva</button>
            </div>
        </form>
    </div>
</div>

<!-- GENERICO -->
<div class="c-modal hidden" id="modal-gen" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h3 class="mb-2 text-lg font-semibold">Segnalazione generica — Nuovo evento</h3>
        <p class="text-xs opacity-70 mb-4">Da utilizzare per segnalazioni di eventi non AIB.</p>

        <form id="form-gen" class="grid gap-4 max-h-[70vh] overflow-auto">
            <fieldset class="grid md:grid-cols-2 gap-4">
                <label class="grid gap-1.5"><span class="label">Tipologia evento</span>
                    <select name="tipologia" class="input" required>
                        <option value="" disabled selected>Seleziona…</option>
                        <option>Allagamento</option>
                        <option>Frana</option>
                        <option>Incendio</option>
                        <option>Vento</option>
                        <option>Neve/Ghiaccio</option>
                        <option>Blackout</option>
                        <option>Altro</option>
                    </select>
                </label>
                <label class="grid gap-1.5"><span class="label">Comuni interessati</span>
                    <input name="comuni" class="input" placeholder="Inserisci uno o più Comuni separati da virgola" list="comuni-datalist" required />
                </label>
                <label class="grid gap-1.5 md:col-span-2"><span class="label">Note descrittive</span>
                    <textarea name="note" class="input" placeholder="Eventuali note descrittive dell'evento. Non utilizzare per aggiornamenti"></textarea>
                </label>
            </fieldset>
            <div class="flex justify-end gap-2 mt-2">
                <button type="button" class="btn" data-close-modal>Chiudi</button>
                <button type="submit" class="btn btn-primary">Salva</button>
            </div>
        </form>
    </div>
</div>

<!-- AIB -->
<div class="c-modal hidden" id="modal-aib" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h3 class="mb-2 text-lg font-semibold">Segnalazione AIB</h3>
        <p class="text-xs opacity-70 mb-4">Da utilizzare per registrare segnalazioni di eventi incendi boschivi</p>

        <form id="form-aib" class="grid gap-4 max-h-[70vh] overflow-auto">
            <fieldset class="grid md:grid-cols-2 gap-4">
                <label class="grid gap-1.5"><span class="label">Comune</span>
                    <input name="comune" class="input" list="comuni-datalist" placeholder="Selezionare il comune interessato" required />
                </label>
                <label class="grid gap-1.5"><span class="label">Persona di contatto</span>
                    <input name="contatto" class="input" placeholder="Nominativo e recapito" />
                </label>
                <label class="grid gap-1.5"><span class="label">Latitudine</span>
                    <input name="lat" class="input" type="number" step="0.000001" placeholder="45… (decimale)" />
                </label>
                <label class="grid gap-1.5"><span class="label">Longitudine</span>
                    <input name="lon" class="input" type="number" step="0.000001" placeholder="11… (decimale)" />
                </label>
                <div class="col-span-full text-xs">
                    <a class="link" href="https://epsg.io/transform" target="_blank" rel="noopener">Convertitore coordinate</a>
                </div>
                <label class="grid gap-1.5 md:col-span-2"><span class="label">Località</span>
                    <input name="localita" class="input" placeholder="Inserire località evento" />
                </label>
                <label class="grid gap-1.5 md:col-span-2"><span class="label">Note descrittive</span>
                    <textarea name="note" class="input" placeholder="Eventuali note descrittive. Non utilizzare per aggiornamenti"></textarea>
                </label>
            </fieldset>
        </form>

        <div class="flex justify-end gap-2 mt-2">
            <button type="button" class="btn" data-close-modal>Chiudi</button>
            <button type="submit" form="form-aib" class="btn btn-primary">Salva</button>
        </div>
    </div>
</div>

<!-- === MODALI DI MODIFICA === -->
<!-- EDIT PHONE -->
<div class="c-modal hidden" id="modal-edit-phone" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h3 class="mb-2 text-lg font-semibold">Modifica telefonata</h3>
        <form id="form-edit-phone" class="grid gap-4">
            <input type="hidden" name="id" />
            <div class="grid md:grid-cols-2 gap-4">
                <label class="grid gap-1"><span class="label">Data/Ora</span>
                    <input type="datetime-local" name="created_at" class="input" />
                </label>
                <label class="grid gap-1"><span class="label">Direzione</span>
                    <select name="direzione" class="input">
                        <option value="E">Entrata</option>
                        <option value="U">Uscita</option>
                    </select>
                </label>
                <label class="grid gap-1"><span class="label">Ente</span>
                    <input type="text" name="ente" class="input" />
                </label>
                <label class="grid gap-1"><span class="label">Comune</span>
                    <input type="text" name="comune" class="input" list="comuni-datalist" />
                </label>
                <label class="grid gap-1"><span class="label">Telefono</span>
                    <input type="text" name="telefono" class="input" />
                </label>
                <label class="grid gap-1"><span class="label">Operatore</span>
                    <input type="text" name="operatore" class="input" />
                </label>
                <label class="grid gap-1 md:col-span-2"><span class="label">Sintesi</span>
                    <textarea name="sintesi" class="input"></textarea>
                </label>
            </div>
            <div class="flex justify-end gap-2 mt-2">
                <button type="button" class="btn" data-close-modal>Annulla</button>
                <button type="submit" class="btn btn-primary">Salva</button>
            </div>
        </form>
    </div>
</div>

<!-- EDIT GENERICO -->
<div class="c-modal hidden" id="modal-edit-gen" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h3 class="mb-2 text-lg font-semibold">Modifica segnalazione</h3>
        <form id="form-edit-gen" class="grid gap-4">
            <input type="hidden" name="id" />
            <div class="grid md:grid-cols-2 gap-4">
                <label class="grid gap-1"><span class="label">Data/Ora</span>
                    <input type="datetime-local" name="created_at" class="input" />
                </label>
                <label class="grid gap-1"><span class="label">Direzione</span>
                    <select name="direzione" class="input">
                        <option value="E">Entrata</option>
                        <option value="U">Uscita</option>
                    </select>
                </label>
                <label class="grid gap-1"><span class="label">Ente</span>
                    <input type="text" name="ente" class="input" />
                </label>
                <label class="grid gap-1"><span class="label">Comune</span>
                    <input type="text" name="comune" class="input" list="comuni-datalist" />
                </label>
                <label class="grid gap-1"><span class="label">Operatore</span>
                    <input type="text" name="operatore" class="input" />
                </label>
                <label class="grid gap-1 md:col-span-2"><span class="label">Sintesi</span>
                    <textarea name="sintesi" class="input"></textarea>
                </label>
            </div>
            <div class="flex justify-end gap-2 mt-2">
                <button type="button" class="btn" data-close-modal>Annulla</button>
                <button type="submit" class="btn btn-primary">Salva</button>
            </div>
        </form>
    </div>
</div>

<!-- ========== MODALE EVENTO (dettaglio + segnalazioni) ========== -->
<div class="c-modal hidden" id="modal-event" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true" style="max-width:72rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>

        <!-- HEADER MODALE EVENTO -->
        <header class="flex items-start justify-between gap-3 mb-3">
            <div class="min-w-0">
                <h3 id="ev-title" class="text-lg font-semibold truncate">Evento</h3>
                <p id="ev-subtitle" class="text-xs opacity-70 mt-1 truncate">—</p>
            </div>
        </header>

        <div id="ev-body" class="grid gap-4 max-h-[70vh] overflow-auto">
            <!-- Tabella segnalazioni -->
            <section class="rounded-2xl border border-slate-200 bg-white p-4">
                <h4 class="text-sm font-semibold mb-3">Segnalazioni relative all’evento</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-left">
                            <tr>
                                <th class="px-3 py-2">Data</th>
                                <th class="px-3 py-2">Ora</th>
                                <th class="px-3 py-2">Tipo</th>
                                <th class="px-3 py-2">Verso</th>
                                <th class="px-3 py-2">Mitt./Dest.</th>
                                <th class="px-3 py-2">Telefono</th>
                                <th class="px-3 py-2">E-mail</th>
                                <th class="px-3 py-2">Comune</th>
                                <th class="px-3 py-2">Oggetto</th>
                                <th class="px-3 py-2">Priorità</th>
                            </tr>
                        </thead>
                        <tbody id="ev-reports-tbody">
                            <tr>
                                <td colspan="10" class="px-3 py-3 opacity-70">Nessuna segnalazione.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="text-xs opacity-70 mt-2">Suggerimento: clicca una riga per caricarla nel form e modificarla.</p>
            </section>
            <header class="flex items-start justify-between gap-3 mb-3">

                <div class="flex items-center gap-2 shrink-0">
                    <button class="btn-xs" id="ev-export" title="Esporta segnalazioni evento">⬇️ Scarica Excel</button>
                    <button class="btn-xs" id="ev-print" title="Stampa">🖨️ Stampa</button>
                    <button class="btn btn-primary" id="ev-open-form">➕ Nuova segnalazione</button>
                </div>
            </header>
        </div>
    </div>
</div>


<!-- MODALE SOVRAPPOSTA: Nuova/Modifica Comunicazione Evento -->
<div class="c-modal c-modal--overlay hidden" id="modal-ev-form" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true" style="max-width:56rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h4 class="mb-2 text-lg font-semibold">Nuova comunicazione</h4>
        <p class="text-xs opacity-70 mb-4">Compila i campi e salva per aggiungere la segnalazione all’evento.</p>

        <form id="ev-form" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" id="ev-id">
            <input type="hidden" id="ev-edit-index">
            <input type="hidden" id="f-operatore"><!-- valorizzato via JS -->

            <label class="grid gap-1.5">
                <span class="label">Data Comunicazione</span>
                <input id="f-data" class="input" type="text" />
            </label>
            <label class="grid gap-1.5">
                <span class="label">Ora Comunicazione</span>
                <input id="f-ora" class="input" type="text" />
            </label>

            <label class="grid gap-1.5">
                <span class="label">Tipo Comunicazione</span>
                <select id="f-tipo" class="input">
                    <option>FAX</option>
                    <option>Email</option>
                    <option>Telefono</option>
                    <option>PEC</option>
                </select>
            </label>
            <div class="grid gap-1.5">
                <span class="label">Verso</span>
                <div class="flex items-center gap-4">
                    <label class="inline-flex items-center gap-2"><input type="radio" name="f-verso" value="Entrata" checked> Entrata</label>
                    <label class="inline-flex items-center gap-2"><input type="radio" name="f-verso" value="Uscita"> Uscita</label>
                </div>
            </div>

            <label class="grid gap-1.5 md:col-span-2"><span class="label">Mittente/Destinatario</span>
                <input id="f-mitt" class="input" />
            </label>
            <label class="grid gap-1.5"><span class="label">Telefono</span><input id="f-tel" class="input" /></label>
            <label class="grid gap-1.5"><span class="label">E-mail</span><input id="f-mail" class="input" type="email" /></label>

            <label class="grid gap-1.5 md:col-span-2"><span class="label">Indirizzo zona colpita</span>
                <input id="f-indirizzo" class="input" />
            </label>
            <label class="grid gap-1.5"><span class="label">Provincia</span><input id="f-provincia" class="input" /></label>
            <label class="grid gap-1.5"><span class="label">Zona (Comune)</span><input id="f-comune" class="input" /></label>

            <label class="grid gap-1.5 md:col-span-2"><span class="label">Oggetto</span>
                <input id="f-oggetto" class="input" />
            </label>
            <label class="grid gap-1.5 md:col-span-2"><span class="label">Contenuto</span>
                <textarea id="f-contenuto" class="input"></textarea>
            </label>

            <div class="md:col-span-2">
                <span class="label">Priorità</span>
                <div class="flex flex-wrap items-center gap-4 mt-1">
                    <label class="inline-flex items-center gap-2"><input type="radio" name="f-priorita" value="Nessuna" checked> Nessuna</label>
                    <label class="inline-flex items-center gap-2"><input type="radio" name="f-priorita" value="Alta"> Alta</label>
                    <label class="inline-flex items-center gap-2"><input type="radio" name="f-priorita" value="Media"> Media</label>
                    <label class="inline-flex items-center gap-2"><input type="radio" name="f-priorita" value="Bassa"> Bassa</label>
                </div>
            </div>

            <div class="md:col-span-2 flex justify-end gap-2 pt-2">
                <button type="button" class="btn" data-close-modal>Annulla</button>
                <button type="submit" class="btn btn-primary" id="ev-save">Salva</button>
            </div>
        </form>
    </div>
</div>



<!-- Datalist Comuni -->
<datalist id="comuni-datalist"></datalist>

<script type="module">
    /* ===== Utils ===== */
    const $ = s => document.querySelector(s);
    const fmtDT = d => new Intl.DateTimeFormat('it-IT', {
        dateStyle: 'short',
        timeStyle: 'short'
    }).format(d);
    const PREVIEW_MAX = 160;
    const truncate = (str = '', n = PREVIEW_MAX) => str.length > n ? str.slice(0, n).trimEnd() + '…' : str;
    const escCsv = (v) => `"${(v??'').toString().replace(/\r?\n/g,' ').replace(/"/g,'""')}"`;

    /* ===== Read-More modal ===== */
    (function ensureReadMoreModal() {
        if ($('#modal-readmore')) return;
        const wrap = document.createElement('div');
        wrap.className = 'c-modal hidden';
        wrap.id = 'modal-readmore';
        wrap.setAttribute('aria-hidden', 'true');
        wrap.innerHTML = `
      <div class="c-modal__backdrop" data-close-modal></div>
      <div class="c-modal__dialog" role="dialog" aria-modal="true">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h3 id="rm-title" class="mb-2 text-lg font-semibold">Dettagli</h3>
        <div id="rm-body" class="rm-body text-sm"></div>
        <div class="flex justify-end mt-4"><button type="button" class="btn" data-close-modal>Chiudi</button></div>
      </div>`;
        document.body.appendChild(wrap);
    })();

    function openReadMore(title, text) {
        const t = $('#rm-title'),
            b = $('#rm-body');
        if (t) t.textContent = title || 'Dettagli';
        if (b) b.textContent = text || '—';
        openModal('#modal-readmore');
    }

    function addReadMoreCell(td, fullText, title) {
        const preview = document.createElement('span');
        preview.textContent = truncate(fullText || '');
        const space = document.createTextNode(' ');
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'link rm-link';
        btn.textContent = 'Mostra di più';
        btn.addEventListener('click', () => openReadMore(title || 'Dettagli', fullText || ''));
        td.append(preview, space, btn);
    }

    function makeDirBadge(val) {
        const v = (val || '').toString().trim().toUpperCase();
        const isIn = (v === 'E' || v === 'ENTRATA');
        const s = document.createElement('span');
        s.className = 'badge ' + (isIn ? 'badge--in' : 'badge--out');
        s.textContent = isIn ? 'E' : 'U';
        s.title = isIn ? 'Entrata' : 'Uscita';
        return s;
    }

    /* ===== Comuni seed ===== */
    const COMUNI = ['Adria', 'Affi', 'Albignasego', 'Bologna', 'Bussolengo', 'Farra di Soligo', 'Milano', 'Napoli', 'Roma', 'Rovigo', 'Torino', 'Verona', 'Vicenza', 'Venezia'];
    COMUNI.forEach(c => {
        const o = document.createElement('option');
        o.value = c;
        $('#comuni-datalist').appendChild(o);
    });

    /* ===== Store + Persistenza ===== */
    const CONFIG = {
        PERSIST: true,
        KEY: 'sor-dash-v10'
    };

    const TYPES = [
        'sismico', 'vulcanico', 'idraulico', 'idrogeologico', 'maremoto', 'deficit-idrico', 'meteo-avverso', 'incendi-boschivi', 'uomo'
    ];
    const TYPE_LABELS = {
        'sismico': 'Sismico',
        'vulcanico': 'Vulcanico',
        'idraulico': 'Idraulico',
        'idrogeologico': 'Idrogeologico',
        'maremoto': 'Maremoto',
        'deficit-idrico': 'Deficit idrico',
        'meteo-avverso': 'Fenomeni meteo avversi',
        'incendi-boschivi': 'Incendi boschivi',
        'uomo': 'Eventi prodotti dall’uomo'
    };

    /* ===== Helper: segnalazioni demo per ogni tipo ===== */
    function demoReportPack(typeKey, comune) {
        const baseDate = '06/10/2025';
        const packs = {
            'sismico': [{
                    ora: '15:10',
                    tipo: 'Telefono',
                    verso: 'Entrata',
                    mitt: 'Cittadino',
                    tel: '',
                    mail: '',
                    indirizzo: 'Piazza XX',
                    provincia: '',
                    comune,
                    oggetto: 'Scossa avvertita',
                    contenuto: 'Oscillazione lampadari, senza danni',
                    priorita: 'Media'
                },
                {
                    ora: '15:30',
                    tipo: 'Email',
                    verso: 'Entrata',
                    mitt: 'COC ' + comune,
                    tel: '',
                    mail: 'coc@' + comune + '.it',
                    indirizzo: 'Sede COC',
                    provincia: '',
                    comune,
                    oggetto: 'Verifiche edifici',
                    contenuto: 'Avviate squadre tecniche',
                    priorita: 'Alta'
                }
            ],
            'vulcanico': [{
                ora: '12:05',
                tipo: 'PEC',
                verso: 'Entrata',
                mitt: 'INGV',
                tel: '',
                mail: '',
                indirizzo: '',
                provincia: '',
                comune,
                oggetto: 'Tremore in aumento',
                contenuto: 'Aggiornamento parametri',
                priorita: 'Alta'
            }],
            'idraulico': [{
                ora: '14:40',
                tipo: 'Telefono',
                verso: 'Entrata',
                mitt: 'PL',
                tel: '',
                mail: '',
                indirizzo: 'Via Argine dx Po, 12',
                provincia: '',
                comune,
                oggetto: 'Sottopasso critico',
                contenuto: 'Livello in crescita',
                priorita: 'Alta'
            }],
            'idrogeologico': [{
                ora: '09:20',
                tipo: 'Telefono',
                verso: 'Entrata',
                mitt: 'Tecnico comunale',
                tel: '',
                mail: '',
                indirizzo: 'Sentiero Bosco',
                provincia: '',
                comune,
                oggetto: 'Smottamento',
                contenuto: 'Chiusura sentiero consigliata',
                priorita: 'Media'
            }],
            'maremoto': [{
                ora: '07:50',
                tipo: 'FAX',
                verso: 'Entrata',
                mitt: 'Capitaneria',
                tel: '',
                mail: '',
                indirizzo: 'Lungomare',
                provincia: '',
                comune,
                oggetto: 'Allerta informativa',
                contenuto: 'Possibile onda anomala, monitoraggio',
                priorita: 'Media'
            }],
            'deficit-idrico': [{
                ora: '11:10',
                tipo: 'Email',
                verso: 'Entrata',
                mitt: 'Gestore acquedotto',
                tel: '',
                mail: '',
                indirizzo: '',
                provincia: '',
                comune,
                oggetto: 'Riduzione pressione',
                contenuto: 'Punti di rifornimento temporanei',
                priorita: 'Bassa'
            }],
            'meteo-avverso': [{
                ora: '18:25',
                tipo: 'Telefono',
                verso: 'Entrata',
                mitt: 'Cittadino',
                tel: '',
                mail: '',
                indirizzo: 'Via Roma 22',
                provincia: '',
                comune,
                oggetto: 'Albero pericolante',
                contenuto: 'Ramo su carreggiata',
                priorita: 'Media'
            }],
            'incendi-boschivi': [{
                ora: '16:40',
                tipo: 'Telefono',
                verso: 'Entrata',
                mitt: 'Vedetta AIB',
                tel: '',
                mail: '',
                indirizzo: 'Località Bosco Alto',
                provincia: '',
                comune,
                oggetto: 'Fumo avvistato',
                contenuto: 'Sterpaglia in combustione',
                priorita: 'Alta'
            }],
            'uomo': [{
                ora: '10:15',
                tipo: 'Email',
                verso: 'Entrata',
                mitt: 'ARPAV',
                tel: '',
                mail: '',
                indirizzo: 'Zona industriale',
                provincia: '',
                comune,
                oggetto: 'Sversamento',
                contenuto: 'Interruzione temporanea servizi',
                priorita: 'Alta'
            }]
        };
        return (packs[typeKey] || []).map(r => ({
            data: baseDate,
            ...r
        }));
    }

    function demoOngoing() {
        const now = Date.now();
        const city = (i) => COMUNI[(i * 3) % COMUNI.length];
        const descByType = t => ({
            'sismico': 'Scossa avvertita in area urbana, verifiche in corso',
            'vulcanico': 'Aumento tremore, segnalata emissione di ceneri',
            'idraulico': 'Allagamenti diffusi in area golenale',
            'idrogeologico': 'Frana localizzata in frazione montana',
            'maremoto': 'Comunicazione di possibile onda anomala in monitoraggio',
            'deficit-idrico': 'Riduzione pressione idrica in alcuni quartieri',
            'meteo-avverso': 'Vento forte e grandinate sparse',
            'incendi-boschivi': 'Principio di incendio in zona boscata',
            'uomo': 'Interruzione servizi per incidente industriale'
        })[t] || 'Evento';
        const needByType = t => ({
            'sismico': 'Sopralluoghi tecnici su edifici strategici',
            'vulcanico': 'Distribuzione DPI a squadre, monitoraggio qualità aria',
            'idraulico': 'Transennamenti e sacchi di sabbia',
            'idrogeologico': 'Monitoraggio tecnico e chiusura sentiero',
            'maremoto': 'Informazioni alla popolazione nelle aree costiere',
            'deficit-idrico': 'Autobotti e punti di rifornimento temporanei',
            'meteo-avverso': 'Rimozione ostacoli e verifica alberature',
            'incendi-boschivi': 'Squadre AIB inviate per bonifica',
            'uomo': 'Coordinamento con ARPAV e VV.F.'
        })[t] || '';
        return TYPES.map((t, i) => {
            const comune = city(i);
            return {
                id: 300 + i + 1,
                tipo: t,
                comune,
                descrizione: descByType(t),
                necessita: needByType(t),
                aggiornamento: new Date(now - i * 3600e3).toISOString(),
                evacuati: i % 3 === 0 ? 'alcune famiglie' : 'no',
                localita: 'Area interessata',
                operatore: 'Operatore',
                isolati: i % 4 === 0 ? 'sì' : 'no',
                energia: i % 2 === 0 ? 'disservizi sporadici' : 'ok',
                telecom: i % 5 === 0 ? 'degrado' : 'ok',
                reports: demoReportPack(t, comune)
            };
        });
    }

    const state = {
        aib: [{
            id: 1,
            created_at: new Date().toISOString(),
            comune: 'Adria',
            localita: 'Bosco Alto',
            note: 'Fumo avvistato in zona collinare, presenza di sterpaglie secche e vento moderato.',
            contatto: 'Mario 333...',
            lat: 45.05,
            lon: 11.8
        }],
        gen: [{
            id: 101,
            created_at: new Date().toISOString(),
            direzione: 'E',
            ente: 'Privato cittadino',
            telefono: '',
            comune: 'Rovigo',
            sintesi: 'Segnalazione di allagamento sottopasso; richiesta verifica livello.',
            operatore: 'operatore'
        }],
        phone: [{
            id: 201,
            created_at: new Date().toISOString(),
            direzione: 'E',
            ente: 'Comune di Farra di Soligo',
            telefono: '0438...',
            comune: 'Farra di Soligo',
            sintesi: 'COC aperto; monitoraggio frane, nessuna nuova criticità.',
            operatore: 'operatore'
        }],
        /* ====== EVENTI IN ATTO ====== */
        ongoing: demoOngoing(),
        page: {
            aib: 1,
            gen: 1,
            phone: 1,
            ongoing: 1
        },
        global: {
            q: '',
            date: '',
            time: '',
            comune: ''
        },
        ui: {
            currentEventId: null
        }
    };

    const save = () => {
        if (CONFIG.PERSIST) localStorage.setItem(CONFIG.KEY, JSON.stringify(state));
    };
    const load = () => {
        if (!CONFIG.PERSIST) return;
        try {
            const raw = localStorage.getItem(CONFIG.KEY);
            if (raw) {
                const d = JSON.parse(raw);
                if (d?.aib && d?.gen && d?.phone && d?.page) Object.assign(state, d);
            }
        } catch {}
    };
    load();

    /* ===== Filtri ===== */
    function matchesGlobalFilters(row, textFieldsGetter, dateFieldGetter) {
        const {
            q,
            date,
            time,
            comune
        } = state.global;
        if (q) {
            const hay = (textFieldsGetter(row) || '').toLowerCase();
            if (!hay.includes(q.toLowerCase())) return false;
        }
        if (comune) {
            const c = (row.comune || '').toLowerCase();
            if (!c.includes(comune.toLowerCase())) return false;
        }
        const dtRaw = dateFieldGetter(row);
        if (date || time) {
            if (!dtRaw) return false;
            const dt = new Date(dtRaw);
            if (date && dt.toISOString().slice(0, 10) !== date) return false;
            if (time && dt.toISOString().slice(11, 16) !== time) return false;
        }
        return true;
    }

    function applyFilters(rows, {
        comune,
        dal,
        al
    }, pickComune, textPicker, datePicker) {
        const dFrom = dal ? new Date(dal + 'T00:00:00') : null;
        const dTo = al ? new Date(al + 'T23:59:59') : null;
        return rows.filter(r => {
            const dt = new Date(datePicker?.(r) || r.created_at || r.aggiornamento || new Date());
            if (dFrom && dt < dFrom) return false;
            if (dTo && dt > dTo) return false;
            const c = (pickComune(r) || '').toLowerCase();
            if (comune && !c.includes(comune.toLowerCase())) return false;
            return matchesGlobalFilters(r, textPicker, datePicker || (x => x.created_at));
        });
    }

    /* ===== Paginazione ===== */
    const PAGE_SIZE = 10;
    const paginate = (arr, page) => {
        const total = Math.max(1, Math.ceil(arr.length / PAGE_SIZE));
        const p = Math.min(Math.max(1, page), total);
        const i = (p - 1) * PAGE_SIZE;
        return {
            slice: arr.slice(i, i + PAGE_SIZE),
            page: p,
            total
        };
    };

    /* ===== Render AIB ===== */
    function renderAIB() {
        const root = $('#aib-body');
        root.replaceChildren();
        const filters = {
            comune: $('#aib-filter-comune').value.trim(),
            dal: $('#aib-filter-dal').value,
            al: $('#aib-filter-al').value
        };
        const filtered = applyFilters(
            state.aib, filters, r => r.comune,
            r => `${r.comune||''} ${r.localita||''} ${r.note||''} ${r.contatto||''}`, r => r.created_at
        ).sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        const {
            slice,
            page,
            total
        } = paginate(filtered, state.page.aib);
        state.page.aib = page;
        $('#aib-page').textContent = `Pagina ${page} di ${total}`;
        slice.forEach(r => {
            const tr = document.createElement('tr');
            tr.className = 'border-t border-slate-200';
            const tdDt = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2',
                textContent: fmtDT(new Date(r.created_at))
            });
            const tdCom = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2',
                textContent: r.comune || ''
            });
            const tdLoc = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2',
                textContent: r.localita || ''
            });
            const tdSyn = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2'
            });
            addReadMoreCell(tdSyn, r.note || '', `AIB • ${r.comune||'Comune'}${r.localita?' – '+r.localita:''}`);
            tr.append(tdDt, tdCom, tdLoc, tdSyn);
            root.appendChild(tr);
        });
        $('#aib-prev').disabled = page <= 1;
        $('#aib-next').disabled = page >= total;
    }

    /* ===== Render GEN ===== */
    function renderGEN() {
        const root = $('#gen-body');
        root.replaceChildren();
        const filters = {
            comune: $('#gen-filter-comune').value.trim(),
            dal: $('#gen-filter-dal').value,
            al: $('#gen-filter-al').value
        };
        const filtered = applyFilters(
            state.gen, filters, r => r.comune,
            r => `${r.ente||''} ${r.comune||''} ${r.sintesi||''} ${r.operatore||''}`, r => r.created_at
        ).sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        const {
            slice,
            page,
            total
        } = paginate(filtered, state.page.gen);
        state.page.gen = page;
        $('#gen-page').textContent = `Pagina ${page} di ${total}`;
        slice.forEach(r => {
            const tr = document.createElement('tr');
            tr.className = 'border-t border-slate-200';
            tr.dataset.id = r.id;
            const tdDt = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2',
                textContent: fmtDT(new Date(r.created_at))
            });
            const tdDir = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2'
            });
            tdDir.appendChild(makeDirBadge(r.direzione));
            const tdEn = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2',
                textContent: r.ente || ''
            });
            const tdCo = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2',
                textContent: r.comune || ''
            });
            const tdSy = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2'
            });
            addReadMoreCell(tdSy, r.sintesi || '', `Segnalazione • ${r.ente||'Ente'}`);
            const tdOp = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2',
                textContent: r.operatore || ''
            });
            const tdAc = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2'
            });
            tdAc.innerHTML = `<div class="actions">
        <button class="btn-xs btn-ghost" data-action="edit" data-type="gen" data-id="${r.id}">Modifica</button>
        <button class="btn-xs btn-danger" data-action="del" data-type="gen" data-id="${r.id}">Elimina</button>
      </div>`;
            tr.append(tdDt, tdDir, tdEn, tdCo, tdSy, tdOp, tdAc);
            root.appendChild(tr);
        });
        $('#gen-prev').disabled = page <= 1;
        $('#gen-next').disabled = page >= total;
    }

    /* ===== Render PHONE ===== */
    function renderPHONE() {
        const root = $('#phone-body');
        root.replaceChildren();
        const filters = {
            comune: $('#phone-filter-comune').value.trim(),
            dal: $('#phone-filter-dal').value,
            al: $('#phone-filter-al').value
        };
        const filtered = applyFilters(
            state.phone, filters, r => r.comune,
            r => `${r.ente||''} ${r.comune||''} ${r.sintesi||''} ${r.operatore||''}`, r => r.created_at
        ).sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        const {
            slice,
            page,
            total
        } = paginate(filtered, state.page.phone);
        state.page.phone = page;
        $('#phone-page').textContent = `Pagina ${page} di ${total}`;
        slice.forEach(r => {
            const tr = document.createElement('tr');
            tr.className = 'border-t border-slate-200';
            tr.dataset.id = r.id;
            const tdDt = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2',
                textContent: fmtDT(new Date(r.created_at))
            });
            const tdDir = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2'
            });
            tdDir.appendChild(makeDirBadge(r.direzione));
            const tdEn = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2',
                textContent: r.ente || ''
            });
            const tdCo = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2',
                textContent: r.comune || ''
            });
            const tdSy = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2'
            });
            addReadMoreCell(tdSy, r.sintesi || '', `Telefonata • ${r.ente||'Interlocutore'}`);
            const tdOp = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2',
                textContent: r.operatore || ''
            });
            const tdAc = Object.assign(document.createElement('td'), {
                className: 'px-3 py-2'
            });
            tdAc.innerHTML = `<div class="actions">
        <button class="btn-xs btn-ghost" data-action="edit" data-type="phone" data-id="${r.id}">Modifica</button>
        <button class="btn-xs btn-danger" data-action="del" data-type="phone" data-id="${r.id}">Elimina</button>
      </div>`;
            tr.append(tdDt, tdDir, tdEn, tdCo, tdSy, tdOp, tdAc);
            root.appendChild(tr);
        });
        $('#phone-prev').disabled = page <= 1;
        $('#phone-next').disabled = page >= total;
    }

    /* ===== Legend (Eventi in atto) ===== */
    function ensureLegend() {
        if ($('#ongoing-legend')) return;
        const legend = document.createElement('div');
        legend.id = 'ongoing-legend';
        legend.className = 'ongoing-legend';
        legend.innerHTML = TYPES.map(t => `
      <span class="ol-item" data-type="${t}">
        <i class="ol-dot" aria-hidden="true"></i>${TYPE_LABELS[t]}
      </span>
    `).join('');
        const cards = $('#ongoing-cards');
        cards.parentNode.insertBefore(legend, cards);
    }

    /* ===== Render ONGOING (eventi in atto) ===== */
    function renderONGOING() {
        ensureLegend();
        const root = $('#ongoing-cards');
        root.replaceChildren();

        const filters = {
            comune: $('#ongoing-filter-comune').value.trim(),
            dal: $('#ongoing-filter-dal').value,
            al: $('#ongoing-filter-al').value
        };

        const filtered = applyFilters(
            state.ongoing, filters, r => r.comune,
            r => `${r.comune||''} ${r.localita||''} ${r.descrizione||''} ${r.necessita||''} ${r.operatore||''}`,
            r => r.aggiornamento
        ).sort((a, b) => new Date(b.aggiornamento) - new Date(a.aggiornamento));

        const {
            slice,
            page,
            total
        } = paginate(filtered, state.page.ongoing);
        state.page.ongoing = page;
        $('#ongoing-page').textContent = `Pagina ${page} di ${total}`;

        if (!slice.length) {
            const empty = document.createElement('div');
            empty.className = 'text-sm opacity-70 px-3 py-2';
            empty.textContent = 'Nessun evento in atto.';
            root.appendChild(empty);
        }

        slice.forEach(ev => {
            const rawType = (ev.tipo || 'meteo-avverso').toString().toLowerCase().trim();
            const typeKey = TYPES.includes(rawType) ? rawType : 'meteo-avverso';
            const typeLabel = TYPE_LABELS[typeKey];

            const card = document.createElement('article');
            card.className = 'ev-card';
            card.dataset.type = typeKey;
            card.tabIndex = 0;
            card.setAttribute('role', 'button');
            card.addEventListener('click', () => openEventModal(ev.id));
            card.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') openEventModal(ev.id);
            });

            const titolo = ev.descrizione || 'Evento';
            const chi = ev.operatore || '—';
            const quando = fmtDT(new Date(ev.aggiornamento));
            const posto = [ev.comune, ev.localita].filter(Boolean).join(' — ') || ev.comune || '—';

            card.innerHTML = `
        <div class="ev-card__head">
          <h4 class="ev-card__title">${titolo}</h4>
          <span class="ev-card__badge">${typeLabel}</span>
        </div>
        <ul class="ev-card__meta">
          <li><strong>Chi:</strong> ${chi}</li>
          <li><strong>Giorno/Ora:</strong> ${quando}</li>
          <li><strong>Posto:</strong> ${posto}</li>
        </ul>
        <p class="ev-card__desc">${truncate(ev.necessita || ev.descrizione || '')}</p>
        <div class="ev-card__footer">
          <button class="btn btn-primary">Apri dettagli</button>
        </div>
      `;
            root.appendChild(card);
        });

        $('#ongoing-prev').disabled = page <= 1;
        $('#ongoing-next').disabled = page >= total;
    }

    /* ===== Modal Event Helpers ===== */
    function openModal(sel) {
        const m = document.querySelector(sel);
        if (!m) return;
        m.classList.remove('hidden');
        m.classList.add('is-open');
        document.body.style.overflow = 'hidden';

        const dlg = m.querySelector('.c-modal__dialog');
        if (!dlg) return;

        // Aree scrollabili
        const evBody = dlg.querySelector('#ev-body');
        if (evBody) evBody.classList.add('scrollable');
        dlg.querySelectorAll('form').forEach(f => f.classList.add('scrollable'));

        // Barre azioni sticky
        dlg.querySelectorAll('.flex.justify-end').forEach(bar => bar.classList.add('modal-actions'));
    }

    function closeModal(el) {
        if (!el) return;
        el.classList.remove('is-open');
        el.classList.add('hidden');
        if (!document.querySelector('.c-modal.is-open')) document.body.style.overflow = '';
    }

    function openEventModal(eventId) {
        state.ui.currentEventId = eventId;
        const ev = state.ongoing.find(x => x.id === eventId);
        if (!ev) return;
        $('#ev-title').textContent = ev.descrizione || '—';
        const lastCount = (ev.reports?.length || 0);
        $('#ev-subtitle').textContent = `${ev.comune || ''} • Ultimo agg.: ${fmtDT(new Date(ev.aggiornamento))} • Segnalazioni: ${lastCount}`;
        renderEventReports(ev);
        resetEvForm();
        $('#ev-id').value = ev.id;
        openModal('#modal-event');
    }

    function renderEventReports(ev) {
        const tbody = $('#ev-reports-tbody');
        tbody.replaceChildren();
        const rows = (ev.reports || []).map((r, idx) => ({
            ...r,
            _idx: idx
        }));
        if (!rows.length) {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.colSpan = 10;
            td.className = 'px-3 py-3 opacity-70';
            td.textContent = 'Nessuna segnalazione.';
            tr.appendChild(td);
            tbody.appendChild(tr);
            return;
        }
        rows.forEach(r => {
            const tr = document.createElement('tr');
            tr.className = 'border-t border-slate-200 hover:bg-slate-50 cursor-pointer';
            tr.dataset.idx = r._idx;
            tr.addEventListener('click', () => {
                loadReportIntoForm(r._idx);
                openModal('#modal-ev-form');
                $('#ev-save').textContent = 'Salva modifiche';
            });
            [r.data, r.ora, r.tipo, r.verso, r.mitt, r.tel, r.mail, r.comune, r.oggetto, r.priorita].forEach(v => {
                const td = document.createElement('td');
                td.className = 'px-3 py-2';
                td.textContent = v || '';
                tr.appendChild(td);
            });
            tbody.appendChild(tr);
        });
    }

    function resetEvForm() {
        $('#ev-edit-index').value = '';
        $('#ev-form').reset?.();
        $('#f-data').value = '06/10/2025';
        $('#f-ora').value = '16:12';
        $('#f-tipo').value = 'FAX';
        document.querySelector('input[name="f-verso"][value="Entrata"]').checked = true;
        $('#f-mitt').value = 'Pinco Pallo';
        $('#f-tel').value = '12435423431';
        $('#f-mail').value = 'pincopallo@gmail.com';
        $('#f-indirizzo').value = 'Narnia';
        $('#f-provincia').value = 'BL';
        $('#f-comune').value = 'Danta di Cadore';
        $('#f-oggetto').value = 'Lorem Ipsum';
        $('#f-contenuto').value = 'lorem ipsum';
        document.querySelector('input[name="f-priorita"][value="Nessuna"]').checked = true;
        $('#ev-save').textContent = 'Salva';
    }

    function loadReportIntoForm(idx) {
        const ev = state.ongoing.find(x => x.id === state.ui.currentEventId);
        if (!ev) return;
        const r = ev.reports?.[idx];
        if (!r) return;
        $('#ev-edit-index').value = idx;
        $('#f-data').value = r.data || '';
        $('#f-ora').value = r.ora || '';
        $('#f-tipo').value = r.tipo || 'FAX';
        const verso = (r.verso || 'Entrata');
        document.querySelector(`input[name="f-verso"][value="${verso}"]`).checked = true;
        $('#f-mitt').value = r.mitt || '';
        $('#f-tel').value = r.tel || '';
        $('#f-mail').value = r.mail || '';
        $('#f-indirizzo').value = r.indirizzo || '';
        $('#f-provincia').value = r.provincia || '';
        $('#f-comune').value = r.comune || '';
        $('#f-oggetto').value = r.oggetto || '';
        $('#f-contenuto').value = r.contenuto || '';
        document.querySelector(`input[name="f-priorita"][value="${r.priorita||'Nessuna'}"]`).checked = true;
        $('#ev-save').textContent = 'Salva modifiche';
    }

    /* ===== Azioni: Edit/Delete per GEN/PHONE ===== */
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-action]');
        if (!btn) return;
        const {
            action,
            type,
            id
        } = btn.dataset;
        const arr = type === 'gen' ? state.gen : type === 'phone' ? state.phone : null;
        if (!arr) return;

        if (action === 'edit') {
            const item = arr.find(x => String(x.id) === String(id));
            if (!item) return;
            if (type === 'phone') {
                fillForm($('#form-edit-phone'), item);
                openModal('#modal-edit-phone');
            } else {
                fillForm($('#form-edit-gen'), item);
                openModal('#modal-edit-gen');
            }
            return;
        }
        if (action === 'del') {
            if (confirm('Confermi eliminazione?')) {
                const idx = arr.findIndex(x => String(x.id) === String(id));
                if (idx > -1) {
                    arr.splice(idx, 1);
                    save();
                    (type === 'gen' ? renderGEN() : renderPHONE());
                }
            }
        }
    });

    function fillForm(form, obj) {
        for (const el of form.elements) {
            if (!el.name) continue;
            const v = obj[el.name];
            if (el.type === 'datetime-local') el.value = v ? v.slice(0, 16) : '';
            else if (el.type === 'checkbox') el.checked = !!v;
            else el.value = (v ?? '');
        }
    }

    /* ===== Paginazione ===== */
    $('#aib-prev').addEventListener('click', () => {
        state.page.aib--;
        renderAIB();
    });
    $('#aib-next').addEventListener('click', () => {
        state.page.aib++;
        renderAIB();
    });
    $('#gen-prev').addEventListener('click', () => {
        state.page.gen--;
        renderGEN();
    });
    $('#gen-next').addEventListener('click', () => {
        state.page.gen++;
        renderGEN();
    });
    $('#phone-prev').addEventListener('click', () => {
        state.page.phone--;
        renderPHONE();
    });
    $('#phone-next').addEventListener('click', () => {
        state.page.phone++;
        renderPHONE();
    });
    $('#ongoing-prev').addEventListener('click', () => {
        state.page.ongoing--;
        renderONGOING();
    });
    $('#ongoing-next').addEventListener('click', () => {
        state.page.ongoing++;
        renderONGOING();
    });

    /* ===== Filtri per-tabella ===== */
    ['#aib-filter-comune', '#aib-filter-dal', '#aib-filter-al'].forEach(s => $(s).addEventListener('input', () => {
        state.page.aib = 1;
        renderAIB();
    }));
    ['#gen-filter-comune', '#gen-filter-dal', '#gen-filter-al'].forEach(s => $(s).addEventListener('input', () => {
        state.page.gen = 1;
        renderGEN();
    }));
    ['#phone-filter-comune', '#phone-filter-dal', '#phone-filter-al'].forEach(s => $(s).addEventListener('input', () => {
        state.page.phone = 1;
        renderPHONE();
    }));
    ['#ongoing-filter-comune', '#ongoing-filter-dal', '#ongoing-filter-al'].forEach(s => $(s).addEventListener('input', () => {
        state.page.ongoing = 1;
        renderONGOING();
    }));

    /* ===== Filtri globali ===== */
    ['#global-q', '#global-date', '#global-time', '#global-comune'].forEach(sel => {
        $(sel).addEventListener('input', () => {
            state.global.q = $('#global-q').value.trim();
            state.global.date = $('#global-date').value;
            state.global.time = $('#global-time').value;
            state.global.comune = $('#global-comune').value.trim();
            state.page = {
                ...state.page,
                aib: 1,
                gen: 1,
                phone: 1,
                ongoing: 1
            };
            renderAll();
        });
    });

    /* ===== Apertura/chiusura modali ===== */
    document.addEventListener('click', (e) => {
        const opener = e.target.closest('[data-open-modal]');
        if (opener) {
            e.preventDefault();
            openModal(opener.getAttribute('data-open-modal'));
            return;
        }
        if (e.target.closest('[data-close-modal]')) closeModal(e.target.closest('.c-modal'));
        if (e.target.classList.contains('c-modal__backdrop')) closeModal(e.target.closest('.c-modal'));
    });

    /* ===== Submit AIB ===== */
    $('#form-aib').addEventListener('submit', e => {
        e.preventDefault();
        const fd = Object.fromEntries(new FormData(e.currentTarget).entries());
        state.aib.unshift({
            id: Date.now(),
            created_at: new Date().toISOString(),
            comune: fd.comune || '',
            contatto: fd.contatto || '',
            lat: fd.lat ? Number(fd.lat) : null,
            lon: fd.lon ? Number(fd.lon) : null,
            localita: fd.localita || '',
            note: fd.note || ''
        });
        save();
        e.currentTarget.reset();
        closeModal(e.currentTarget.closest('.c-modal'));
        state.page.aib = 1;
        renderAIB();
    });

    /* ===== Submit GEN ===== */
    $('#form-gen').addEventListener('submit', e => {
        e.preventDefault();
        const fd = Object.fromEntries(new FormData(e.currentTarget).entries());
        state.gen.unshift({
            id: Date.now(),
            created_at: new Date().toISOString(),
            direzione: fd.direzione || 'E',
            ente: fd.tipologia ? `Tipologia: ${fd.tipologia}` : (fd.ente || ''),
            telefono: '',
            comune: fd.comuni?.split(',')[0]?.trim() || '',
            sintesi: fd.note || '',
            operatore: 'operatore'
        });
        save();
        e.currentTarget.reset();
        closeModal(e.currentTarget.closest('.c-modal'));
        state.page.gen = 1;
        renderGEN();
    });

    /* ===== Submit PHONE ===== */
    $('#form-phone').addEventListener('submit', e => {
        e.preventDefault();
        const fd = Object.fromEntries(new FormData(e.currentTarget).entries());
        let created_at = new Date();
        if (fd.data) {
            const hhmm = (fd.ora || '12:00') + ':00';
            created_at = new Date(`${fd.
            data}T${hhmm}`);
        }
        state.phone.unshift({
            id: Date.now(),
            created_at: created_at.toISOString(),
            direzione: fd.direzione || 'E',
            ente: fd.ente || '',
            telefono: fd.telefono || '',
            comune: fd.comune || '',
            sintesi: fd.sintesi || '',
            operatore: 'operatore'
        });
        save();
        e.currentTarget.reset();
        closeModal(e.currentTarget.closest('.c-modal'));
        state.page.phone = 1;
        renderPHONE();
    });

    /* ===== Submit EDIT PHONE ===== */
    $('#form-edit-phone').addEventListener('submit', e => {
        e.preventDefault();
        const fd = Object.fromEntries(new FormData(e.currentTarget).entries());
        const idx = state.phone.findIndex(r => String(r.id) === String(fd.id));
        if (idx > -1) {
            state.phone[idx] = {
                ...state.phone[idx],
                created_at: fd.created_at ? new Date(fd.created_at).toISOString() : state.phone[idx].created_at,
                direzione: fd.direzione || state.phone[idx].direzione,
                ente: fd.ente ?? state.phone[idx].ente,
                comune: fd.comune ?? state.phone[idx].comune,
                telefono: fd.telefono ?? state.phone[idx].telefono,
                sintesi: fd.sintesi ?? state.phone[idx].sintesi,
                operatore: fd.operatore ?? state.phone[idx].operatore
            };
            save();
            renderPHONE();
            closeModal($('#modal-edit-phone'));
        }
    });

    /* ===== Submit EDIT GEN ===== */
    $('#form-edit-gen').addEventListener('submit', e => {
        e.preventDefault();
        const fd = Object.fromEntries(new FormData(e.currentTarget).entries());
        const idx = state.gen.findIndex(r => String(r.id) === String(fd.id));
        if (idx > -1) {
            state.gen[idx] = {
                ...state.gen[idx],
                created_at: fd.created_at ? new Date(fd.created_at).toISOString() : state.gen[idx].created_at,
                direzione: fd.direzione || state.gen[idx].direzione,
                ente: fd.ente ?? state.gen[idx].ente,
                comune: fd.comune ?? state.gen[idx].comune,
                sintesi: fd.sintesi ?? state.gen[idx].sintesi,
                operatore: fd.operatore ?? state.gen[idx].operatore
            };
            save();
            renderGEN();
            closeModal($('#modal-edit-gen'));
        }
    });

    /* ===== Submit EV-FORM (nuova o modifica) ===== */
    $('#ev-form').addEventListener('submit', (e) => {
        e.preventDefault();
        const ev = state.ongoing.find(x => x.id === state.ui.currentEventId);
        if (!ev) return;

        const report = {
            data: $('#f-data').value.trim(),
            ora: $('#f-ora').value.trim(),
            tipo: $('#f-tipo').value,
            verso: document.querySelector('input[name="f-verso"]:checked')?.value || 'Entrata',
            mitt: $('#f-mitt').value.trim(),
            tel: $('#f-tel').value.trim(),
            mail: $('#f-mail').value.trim(),
            indirizzo: $('#f-indirizzo').value.trim(),
            provincia: $('#f-provincia').value.trim(),
            comune: $('#f-comune').value.trim(),
            oggetto: $('#f-oggetto').value.trim(),
            contenuto: $('#f-contenuto').value.trim(),
            priorita: document.querySelector('input[name="f-priorita"]:checked')?.value || 'Nessuna'
        };

        const editIdx = $('#ev-edit-index').value;
        if (editIdx !== '' && !Number.isNaN(+editIdx)) {
            ev.reports[+editIdx] = report;
        } else {
            ev.reports = ev.reports || [];
            ev.reports.unshift(report);
        }
        ev.aggiornamento = new Date().toISOString();
        save();
        renderEventReports(ev);
        resetEvForm();
        renderONGOING(); // aggiorna “ultimo aggiornamento”
        closeModal($('#modal-ev-form'));
    });

    /* ===== Export CSV ===== */
    function toCSV(rows, headers, pickers) {
        const head = headers.map(escCsv).join(';');
        const body = rows.map(r => pickers.map(fn => escCsv(fn(r))).join(';')).join('\n');
        return head + '\n' + body;
    }

    function downloadCSV(filename, csv) {
        const blob = new Blob([csv], {
            type: 'text/csv;charset=utf-8;'
        });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename.endsWith('.csv') ? filename : `${filename}.csv`;
        document.body.appendChild(a);
        a.click();
        a.remove();
        URL.revokeObjectURL(url);
    }

    function exportAIB() {
        const filters = {
            comune: $('#aib-filter-comune').value.trim(),
            dal: $('#aib-filter-dal').value,
            al: $('#aib-filter-al').value
        };
        const filtered = applyFilters(state.aib, filters, r => r.comune, r => `${r.comune||''} ${r.localita||''} ${r.note||''}`, r => r.created_at)
            .sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        const {
            slice,
            page
        } = paginate(filtered, state.page.aib);
        const headers = ['Data/Ora', 'Comune', 'Località', 'Sintesi'];
        const pickers = [r => fmtDT(new Date(r.created_at)), r => r.comune || '', r => r.localita || '', r => r.note || ''];
        downloadCSV(`aib_p${page}`, toCSV(slice, headers, pickers));
    }

    function exportGEN() {
        const filters = {
            comune: $('#gen-filter-comune').value.trim(),
            dal: $('#gen-filter-dal').value,
            al: $('#gen-filter-al').value
        };
        const filtered = applyFilters(state.gen, filters, r => r.comune, r => `${r.ente||''} ${r.comune||''} ${r.sintesi||''}`, r => r.created_at)
            .sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        const {
            slice,
            page
        } = paginate(filtered, state.page.gen);
        const headers = ['Data/Ora', 'Direzione', 'Ente', 'Comune', 'Sintesi', 'Operatore'];
        const pickers = [r => fmtDT(new Date(r.created_at)), r => r.direzione || '', r => r.ente || '', r => r.comune || '', r => r.sintesi || '', r => r.operatore || ''];
        downloadCSV(`segnalazioni_generiche_p${page}`, toCSV(slice, headers, pickers));
    }

    function exportPHONE() {
        const filters = {
            comune: $('#phone-filter-comune').value.trim(),
            dal: $('#phone-filter-dal').value,
            al: $('#phone-filter-al').value
        };
        const filtered = applyFilters(state.phone, filters, r => r.comune, r => `${r.ente||''} ${r.comune||''} ${r.sintesi||''}`, r => r.created_at)
            .sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        const {
            slice,
            page
        } = paginate(filtered, state.page.phone);
        const headers = ['Data/Ora', 'Direzione', 'Ente', 'Comune', 'Sintesi', 'Operatore', 'Telefono'];
        const pickers = [r => fmtDT(new Date(r.created_at)), r => r.direzione || '', r => r.ente || '', r => r.comune || '', r => r.sintesi || '', r => r.operatore || '', r => r.telefono || ''];
        downloadCSV(`telefonate_p${page}`, toCSV(slice, headers, pickers));
    }

    function exportONGOING() {
        const filters = {
            comune: $('#ongoing-filter-comune').value.trim(),
            dal: $('#ongoing-filter-dal').value,
            al: $('#ongoing-filter-al').value
        };
        const filtered = applyFilters(state.ongoing, filters, r => r.comune, r => `${r.comune||''} ${r.descrizione||''} ${r.necessita||''}`, r => r.aggiornamento)
            .sort((a, b) => new Date(b.aggiornamento) - new Date(a.aggiornamento));
        const {
            slice,
            page
        } = paginate(filtered, state.page.ongoing);
        const headers = ['Comune', 'Descrizione', 'Necessità', 'Aggiornamento', 'Evacuati', 'Isolati', 'Energia', 'Telecom'];
        const pickers = [r => r.comune || '', r => r.descrizione || '', r => r.necessita || '', r => fmtDT(new Date(r.aggiornamento)), r => r.evacuati || '', r => r.isolati || '', r => r.energia || '', r => r.telecom || ''];
        downloadCSV(`eventi_in_atto_p${page}`, toCSV(slice, headers, pickers));
    }

    /* ===== Export & Print binding ===== */
    $('#aib-export').addEventListener('click', exportAIB);
    $('#gen-export').addEventListener('click', exportGEN);
    $('#phone-export').addEventListener('click', exportPHONE);
    $('#ongoing-export').addEventListener('click', exportONGOING);

    $('#ev-export').addEventListener('click', () => {
        const ev = state.ongoing.find(x => x.id === state.ui.currentEventId);
        if (!ev) return;
        const rows = ev.reports || [];
        const headers = ['Data', 'Ora', 'Tipo', 'Verso', 'Mittente/Destinatario', 'Telefono', 'E-mail', 'Comune', 'Oggetto', 'Priorità'];
        const pickers = [r => r.data, r => r.ora, r => r.tipo, r => r.verso, r => r.mitt, r => r.tel, r => r.mail, r => r.comune, r => r.oggetto, r => r.priorita];
        downloadCSV(`evento_${ev.id}_segnalazioni`, toCSV(rows, headers, pickers));
    });

    $('#ev-print').addEventListener('click', () => {
        const dlg = document.querySelector('#modal-event .c-modal__dialog');
        if (!dlg) return;
        const css = document.querySelector('style')?.textContent || '';
        const win = window.open('', '_blank', 'width=1024,height=768');
        win.document.write(`<html><head><title>Stampa evento</title><style>${css}</style></head><body>${dlg.innerHTML}</body></html>`);
        win.document.close();
        win.focus();
        win.print();
        win.close();
    });

    // Bottone "Nuova segnalazione" nella modale evento
    $('#ev-open-form')?.addEventListener('click', () => {
        resetEvForm();
        openModal('#modal-ev-form');
    });

    /* ===== CSS ===== */
    const css = `
/* —— base —— */
*{box-sizing:border-box} html,body{height:100%}
body{ margin:0; font:14px/1.45 system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif; color:#0f172a; background:#f6f8fb }

/* —— palette —— */
:root{
  --primary:#2563eb; --primary-50:#eff6ff;
  --primary-600:#1d4ed8; --primary-700:#1e40af;

  --muted:#64748b; --muted-50:#f1f5f9;
  --card:#ffffff; --line:#e2e8f0;
  --row-alt:#fafbff; --row-hover:#eef6ff;

  /* —— palette tipi evento —— */
  --ev-sismico:#ef4444;           --ev-sismico-50:#fef2f2;
  --ev-vulcanico:#b91c1c;         --ev-vulcanico-50:#fee2e2;
  --ev-idraulico:#06b6d4;         --ev-idraulico-50:#ecfeff;
  --ev-idrogeologico:#059669;     --ev-idrogeologico-50:#ecfdf5;
  --ev-maremoto:#0ea5e9;          --ev-maremoto-50:#f0f9ff;
  --ev-deficit-idrico:#a16207;    --ev-deficit-idrico-50:#fefce8;
  --ev-meteo-avverso:#7c3aed;     --ev-meteo-avverso-50:#f5f3ff;
  --ev-incendi-boschivi:#f97316;  --ev-incendi-boschivi-50:#fff7ed;
  --ev-uomo:#475569;              --ev-uomo-50:#f1f5f9;

  /* —— palette sezioni —— */
  --sec-phone:#10b981;    /* verde */
  --sec-gen:#8b5cf6;      /* viola */
  --sec-aib:#f97316;      /* arancio */
  --sec-ongoing:#2563eb;  /* blu */
}

/* —— utility —— */
.p-6{padding:1.5rem} .mb-4{margin-bottom:1rem} .mb-6{margin-bottom:1.5rem}
.grid{display:grid} .gap-3{gap:.75rem} .gap-4{gap:1rem}
.flex{display:flex} .flex-wrap{flex-wrap:wrap} .items-center{align-items:center}
.items-start{align-items:flex-start} .justify-between{justify-content:space-between}
.justify-end{justify-content:flex-end} .shrink-0{flex-shrink:0}
.rounded-2xl{border-radius:1rem}
.text-sm{font-size:.875rem} .text-xs{font-size:.75rem}
.text-xl{font-size:1.25rem} .font-semibold{font-weight:600}
.opacity-70{opacity:.7} .opacity-75{opacity:.75}
.link{color:var(--primary); text-decoration:underline; cursor:pointer}
.shadow-card{box-shadow:0 1px 2px rgba(0,0,0,.05),0 8px 24px rgba(15,23,42,.06)}

/* —— form —— */
.input{ height:2.5rem; border:1px solid var(--line); border-radius:.75rem; padding:.25rem .75rem; font-size:.875rem; background:#fff; color:#0f172a }
textarea.input{min-height:5.5rem; padding:.5rem .75rem}
.label{font-size:.8rem; color:#334155}

/* —— bottoni —— */
.btn{border:1px solid var(--line); border-radius:.75rem; padding:.5rem .75rem; font-size:.875rem; background:#fff; color:#0f172a; cursor:pointer; transition:background .15s, box-shadow .15s, transform .06s}
.btn:hover{background:var(--muted-50)}
.btn:active{transform:translateY(1px)}

.btn-primary{
  background:var(--primary); color:#fff; border-color:var(--primary);
  box-shadow:0 1px 0 rgba(0,0,0,.04), 0 6px 16px rgba(37,99,235,.18);
}
.btn-primary:hover{
  background:var(--primary-600); border-color:var(--primary-600);
  box-shadow:0 2px 0 rgba(0,0,0,.05), 0 10px 24px rgba(29,78,216,.22);
}
.btn-primary:active{ background:var(--primary-700); border-color:var(--primary-700) }

.btn-xs{border:1px solid #e5e7eb; border-radius:.5rem; padding:.25rem .5rem; font-size:.75rem; background:#fff; cursor:pointer}
.btn-ghost{background:transparent; border-color:transparent}
.btn-danger{background:#fee2e2; border-color:#fecaca}
.btn-danger:hover{background:#fecaca}
.actions{display:flex; gap:.25rem}

/* —— sezioni con accento colore —— */
.sec{
  --accent:var(--muted); --thead:var(--muted-50);
  border:1px solid var(--line); border-left:8px solid var(--accent); background:var(--card)
}
.sec h3{color:var(--accent); margin:0}
.sec thead{background:var(--thead)}
/* mapping sezioni -> colori */
.sec--phone{   --accent:var(--sec-phone);   --thead:color-mix(in oklab, var(--sec-phone) 8%, #fff) }
.sec--gen{     --accent:var(--sec-gen);     --thead:color-mix(in oklab, var(--sec-gen) 8%, #fff) }
.sec--aib{     --accent:var(--sec-aib);     --thead:color-mix(in oklab, var(--sec-aib) 8%, #fff) }
.sec--ongoing{ --accent:var(--sec-ongoing); --thead:color-mix(in oklab, var(--sec-ongoing) 8%, #fff) }

/* —— tabelle —— */
table{border-collapse:separate; border-spacing:0; width:100%}
thead th{border-bottom:1px solid var(--line); font-weight:600; padding:.5rem .75rem}
tbody td{padding:.5rem .75rem}
tbody tr:nth-child(even){background:var(--row-alt)}
tbody tr:hover{background:var(--row-hover)}
.border-slate-200{border-color:var(--line)}
.border-t{border-top:1px solid var(--line)}

/* —— pager —— */
.pager{display:flex; align-items:center; gap:.5rem; justify-content:center; margin-top:.75rem}
.pager__label{font-size:.85rem; opacity:.75}

/* —— badge E/U —— */
.badge{display:inline-block; padding:.15rem .5rem; border-radius:.5rem; font-weight:600; font-size:.75rem; border:1px solid transparent; line-height:1}
.badge--in{background:#ecfdf5; border-color:#bbf7d0; color:#166534}
.badge--out{background:#fff1f2; border-color:#fecdd3; color:#991b1b}

/* —— modali: ON-SCREEN + SCROLL INTERNO —— */
.c-modal{position:fixed; inset:0; z-index:1000; display:none}
.c-modal.is-open{display:block}
.c-modal.hidden{display:none}
.c-modal__backdrop{position:absolute; inset:0; background:rgba(0,0,0,.65)}
.c-modal__dialog{
  position:relative; max-width:72rem; width:min(96vw, 72rem);
  margin:4vh auto; background:#fff; border:1px solid var(--line);
  border-radius:1rem; box-shadow:0 10px 30px rgba(0,0,0,.2);
  padding:1.25rem; max-height:92vh;
  display:flex; flex-direction:column; overflow:hidden;
}
/* Aree scrollabili all'interno del dialog */
.c-modal__dialog > .scrollable,
.c-modal__dialog form.scrollable{ flex:1 1 auto; overflow:auto; min-height:0 }

/* Barra azioni sticky in fondo alla modale */
.modal-actions{
  position:sticky; bottom:-1px; background:#fff;
  padding-top:.75rem; margin-top:.25rem; border-top:1px solid var(--line);
}

/* overlay sopra la modale evento */
.c-modal--overlay{ z-index:1100; }

/* —— cards “Eventi in atto” con colore per tipo —— */
.ev-card{
  --ev: var(--ev-meteo-avverso); --ev-50: var(--ev-meteo-avverso-50);
  border:1px solid var(--line); border-left:8px solid var(--ev);
  border-radius:1rem; background:#fff; padding:1rem;
  box-shadow:0 1px 2px rgba(0,0,0,.04);
  display:flex; flex-direction:column; gap:.5rem;
  cursor:pointer; transition:transform .06s ease, box-shadow .12s ease, background .12s ease;
}
.ev-card:hover{transform:translateY(-1px); box-shadow:0 6px 16px rgba(0,0,0,.06); background:var(--ev-50)}
.ev-card__head{display:flex; align-items:start; justify-content:space-between; gap:.5rem}
.ev-card__title{font-weight:700; line-height:1.3; margin:0}
.ev-card__badge{
  font-size:.7rem; border:1px solid color-mix(in oklab, var(--ev) 55%, white);
  background: color-mix(in oklab, var(--ev) 10%, white);
  color: color-mix(in oklab, var(--ev) 65%, black);
  border-radius:.5rem; padding:.15rem .5rem
}
.ev-card__meta{margin:0; padding:0; list-style:none; font-size:.85rem; color:#334155; display:grid; gap:.15rem}
.ev-card__desc{font-size:.85rem; color:#475569; margin-top:.25rem}
.ev-card__footer{margin-top:.25rem; display:flex; justify-content:flex-end}

/* mapping: data-type -> palette */
.ev-card[data-type="sismico"]{           --ev:var(--ev-sismico);           --ev-50:var(--ev-sismico-50) }
.ev-card[data-type="vulcanico"]{         --ev:var(--ev-vulcanico);         --ev-50:var(--ev-vulcanico-50) }
.ev-card[data-type="idraulico"]{         --ev:var(--ev-idraulico);         --ev-50:var(--ev-idraulico-50) }
.ev-card[data-type="idrogeologico"]{     --ev:var(--ev-idrogeologico);     --ev-50:var(--ev-idrogeologico-50) }
.ev-card[data-type="maremoto"]{          --ev:var(--ev-maremoto);          --ev-50:var(--ev-maremoto-50) }
.ev-card[data-type="deficit-idrico"]{    --ev:var(--ev-deficit-idrico);    --ev-50:var(--ev-deficit-idrico-50) }
.ev-card[data-type="meteo-avverso"]{     --ev:var(--ev-meteo-avverso);     --ev-50:var(--ev-meteo-avverso-50) }
.ev-card[data-type="incendi-boschivi"]{  --ev:var(--ev-incendi-boschivi);  --ev-50:var(--ev-incendi-boschivi-50) }
.ev-card[data-type="uomo"]{              --ev:var(--ev-uomo);              --ev-50:var(--ev-uomo-50) }

/* —— legenda eventi in atto —— */
.ongoing-legend{
  display:flex; flex-wrap:wrap; gap:.5rem .75rem; margin:.25rem 0 .75rem 0; align-items:center
}
.ol-item{display:inline-flex; align-items:center; gap:.4rem; font-size:.8rem; color:#334155; border:1px solid var(--line); border-radius:.75rem; padding:.2rem .5rem; background:#fff}
.ol-dot{width:.85rem; height:.85rem; border-radius:999px; display:inline-block; background:var(--ev)}
.ol-item[data-type="sismico"]{           --ev:var(--ev-sismico) }
.ol-item[data-type="vulcanico"]{         --ev:var(--ev-vulcanico) }
.ol-item[data-type="idraulico"]{         --ev:var(--ev-idraulico) }
.ol-item[data-type="idrogeologico"]{     --ev:var(--ev-idrogeologico) }
.ol-item[data-type="maremoto"]{          --ev:var(--ev-maremoto) }
.ol-item[data-type="deficit-idrico"]{    --ev:var(--ev-deficit-idrico) }
.ol-item[data-type="meteo-avverso"]{     --ev:var(--ev-meteo-avverso) }
.ol-item[data-type="incendi-boschivi"]{  --ev:var(--ev-incendi-boschivi) }
.ol-item[data-type="uomo"]{              --ev:var(--ev-uomo) }

/* —— stampa —— */
@media print{
  body{background:#fff}
  .btn,.btn-xs{display:none}
  .c-modal__dialog{box-shadow:none}
}

/* Bottone chiusura modale */
.c-modal__close{
  position:absolute;
  top:.75rem;
  right:.75rem;
  background:transparent;
  border:none;
  font-size:1.25rem;
  color:#475569;
  cursor:pointer;
  line-height:1;
}
.c-modal__close:hover{ color:#0f172a; }

`;
    const style = document.createElement('style');
    style.textContent = css;
    document.head.appendChild(style);

    /* ===== Avvio ===== */
    function renderAll() {
        renderAIB();
        renderGEN();
        renderPHONE();
        renderONGOING();
    }
    renderAll();
</script>