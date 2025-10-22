<div class="p-6" id="app">
    <header class="mb-4 flex items-center justify-between">
        <h2 class="text-xl font-semibold">Dashboard SOR</h2>
        <button class="btn btn-primary" data-open-modal="#modal-gen">📝 Nuova segnalazione generica</button>
    </header>

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
        <div class="flex justify-end mt-3">
            <button class="btn btn-xs" id="global-reset" type="button">Reset</button>
        </div>

        <div class="text-xs opacity-70 mt-2">La ricerca globale si somma ai filtri per-tabella.</div>
    </div>

    <!-- ========== SEGNALAZIONI GENERICHE ========== -->
    <section class="sec sec--gen border-slate-200 rounded-2xl bg-white shadow-card p-4 mb-6">
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

            <!-- 🔹 Bottone Reset accanto ai filtri -->
            <button class="btn btn-xs mb-2" id="gen-filters-reset" type="button">Reset</button>

            <!-- info paginazione -->
            <div class="text-sm opacity-70 ml-auto mt-5">10 per pagina</div>
        </div>


        <!-- 🔴🟠🟢 Legenda priorità (restyling = come legenda eventi) -->
        <div id="gen-prio-legend" class="ongoing-legend prio-legend" aria-label="Legenda priorità">
            <span class="ol-item" data-prio="alta"><i class="ol-dot" aria-hidden="true"></i>Alta</span>
            <span class="ol-item" data-prio="media"><i class="ol-dot" aria-hidden="true"></i>Media</span>
            <span class="ol-item" data-prio="bassa"><i class="ol-dot" aria-hidden="true"></i>Bassa</span>
            <span class="ol-item" data-prio="nessuna"><i class="ol-dot" aria-hidden="true"></i>Nessuna</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="tbl-gen">
                <thead class="text-left">
                    <tr>
                        <th class="px-3 py-2">Data/Ora</th>
                        <th class="px-3 py-2">E/U</th>
                        <th class="px-3 py-2">Ente/Tipologia</th>
                        <th class="px-3 py-2">Comuni/Frazioni</th>
                        <th class="px-3 py-2 w-sintesi">Sintesi</th>
                        <th class="px-3 py-2">Operatore</th>
                        <th class="px-3 py-2">Evento</th>
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

    <!-- ========== EVENTI IN ATTO ========== -->
    <section class="sec sec--ongoing rounded-2xl border border-slate-200 bg-white shadow-card p-4 mb-6">
        <div class="flex items-center justify-between gap-3 mb-3">
            <h3 class="text-sm font-semibold">Eventi in atto</h3>
            <div class="flex items-center gap-2">
                <button class="btn-xs" id="ongoing-toggle-status" title="Filtro stato">Tutti</button>
                <button class="btn-xs" id="ongoing-all-reports">📋 Tutte le comunicazioni</button>
                <button class="btn-xs" id="ongoing-export">⬇️ Scarica Excel</button>
            </div>
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

            <!-- 🔹 Bottone Reset accanto ai filtri -->
            <button class="btn btn-xs mb-2" id="ongoing-filters-reset" type="button">Reset</button>

            <!-- info paginazione -->
            <div class="text-sm opacity-70 ml-auto mt-5">10 per pagina</div>
        </div>


        <div id="ongoing-cards" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3"></div>

        <div class="pager">
            <button class="btn-xs" id="ongoing-prev">«</button>
            <span id="ongoing-page" class="pager__label">Pagina 1 di 1</span>
            <button class="btn-xs" id="ongoing-next">»</button>
        </div>
        <div class="text-xs opacity-70 mt-2">Suggerimento: clicca una card per aprire i dettagli dell’evento.</div>
    </section>
</div>

<!-- ========== MODALI ========== -->

<!-- GENERICO (CREA) -->
<div class="c-modal hidden" id="modal-gen" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h3 class="mb-2 text-lg font-semibold">Segnalazione generica — Nuovo evento</h3>
        <p class="text-xs opacity-70 mb-4">Modulo normalizzato: con campi base + campi specifici per tipologia.</p>

        <form id="form-gen" class="grid gap-4 max-h-[70vh] overflow-auto">
            <fieldset class="grid md:grid-cols-2 gap-4">
                <label class="grid gap-1.5">
                    <span class="label">Tipologia evento</span>
                    <select name="tipologia" id="gen-tipologia" class="input" required>
                        <option value="" disabled selected>Seleziona…</option>
                        <option value="sismico">Sismico</option>
                        <option value="vulcanico">Vulcanico</option>
                        <option value="idraulico">Idraulico</option>
                        <option value="idrogeologico">Idrogeologico</option>
                        <option value="maremoto">Maremoto</option>
                        <option value="deficit-idrico">Deficit idrico</option>
                        <option value="meteo-avverso">Fenomeni meteo avversi</option>
                        <option value="aib">AIB (Incendi boschivi)</option>
                        <option value="uomo">Evento prodotto dall’uomo</option>
                        <option value="altro">Altro</option>
                    </select>
                </label>

                <!-- Priorità -->
                <label class="grid gap-1.5">
                    <span class="label">Priorità</span>
                    <div class="flex flex-wrap items-center gap-4 mt-1">
                        <label class="inline-flex items-center gap-2"><input type="radio" name="priorita" value="Nessuna" checked /> Nessuna</label>
                        <label class="inline-flex items-center gap-2"><input type="radio" name="priorita" value="Alta" /> Alta</label>
                        <label class="inline-flex items-center gap-2"><input type="radio" name="priorita" value="Media" /> Media</label>
                        <label class="inline-flex items-center gap-2"><input type="radio" name="priorita" value="Bassa" /> Bassa</label>
                    </div>
                </label>

                <label class="grid gap-1.5 md:col-span-2">
                    <span class="label">Aree interessate (Comuni e Frazioni)</span>
                    <div class="tag-input" id="gen-aree" data-datalist="comuni-datalist" data-placeholder="Scrivi Comune o Frazione e premi Invio"></div>
                    <input type="hidden" name="aree" id="gen-aree-hidden" />
                    <span class="text-xs opacity-70">Esempio: “Verona”, “Verona - Avesa”, “Farra di Soligo - Soligo”.</span>
                </label>

                <label class="grid gap-1.5 md:col-span-2">
                    <span class="label">Note descrittive</span>
                    <textarea name="note" class="input" placeholder="Eventuali note descrittive dell'evento. Non utilizzare per aggiornamenti"></textarea>
                </label>

                <!-- Associazione evento -->
                <label class="grid gap-1.5 md:col-span-2">
                    <span class="label">Associa a evento in atto</span>
                    <select name="event_id" id="gen-event-select" class="input">
                        <option value="">— Nessuna associazione —</option>
                        <option value="__new__">[+ Crea nuovo evento]</option>
                    </select>
                    <span class="text-xs opacity-70 mt-1">Se scegli “Crea nuovo evento”, verrà creato un evento in “Eventi in atto” con questa segnalazione.</span>
                </label>
            </fieldset>

            <!-- SPECIFICI PER TIPO -->
            <fieldset>
                <legend class="text-sm font-semibold mb-1">Campi specifici</legend>
                <div id="gen-specific"></div>
            </fieldset>

            <div class="flex justify-end gap-2 mt-2">
                <button type="button" class="btn" data-close-modal>Chiudi</button>
                <button type="reset" class="btn">Reset</button>
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
                <label class="grid gap-1">
                    <span class="label">Data/Ora</span>
                    <input type="datetime-local" name="created_at" class="input" />
                </label>
                <label class="grid gap-1">
                    <span class="label">Direzione</span>
                    <select name="direzione" class="input">
                        <option value="E">Entrata</option>
                        <option value="U">Uscita</option>
                    </select>
                </label>

                <!-- Priorità -->
                <label class="grid gap-1">
                    <span class="label">Priorità</span>
                    <select name="priorita" class="input">
                        <option>Nessuna</option>
                        <option>Alta</option>
                        <option selected>Media</option>
                        <option>Bassa</option>
                    </select>
                </label>

                <label class="grid gap-1 md:col-span-2">
                    <span class="label">Aree interessate (Comuni e Frazioni)</span>
                    <div class="tag-input" id="edit-aree" data-datalist="comuni-datalist"></div>
                    <input type="hidden" name="aree_json" id="edit-aree-hidden" />
                </label>
                <label class="grid gap-1">
                    <span class="label">Operatore</span>
                    <input type="text" name="operatore" class="input" />
                </label>
                <label class="grid gap-1 md:col-span-2">
                    <span class="label">Sintesi</span>
                    <textarea name="sintesi" class="input"></textarea>
                </label>

                <!-- 🔗 Associazione evento -->
                <label class="grid gap-1 md:col-span-2">
                    <span class="label">Associa a evento in atto</span>
                    <select name="event_id" id="edit-gen-event" class="input">
                        <option value="">— Nessuna associazione —</option>
                        <option value="__new__">[+ Crea nuovo evento]</option>
                    </select>
                    <span class="text-xs opacity-70 mt-1">Scegli un evento oppure crea un nuovo evento da questa segnalazione.</span>
                </label>
            </div>
            <div class="flex justify-end gap-2 mt-2">
                <button type="button" class="btn" data-close-modal>Annulla</button>
                <button type="reset" class="btn">Reset</button>
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

        <header class="flex items-start justify-between gap-3 mb-3">
            <div class="min-w-0">
                <h3 id="ev-title" class="text-lg font-semibold truncate">Evento</h3>
                <p id="ev-subtitle" class="text-xs opacity-70 mt-1 truncate">—</p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <button class="btn-xs" id="ev-areas-edit">Aree interessate</button>
                <button class="btn-xs" id="ev-export" title="Esporta segnalazioni evento">⬇️ Scarica Excel</button>
                <button class="btn-xs" id="ev-print" title="Stampa">🖨️ Stampa</button>
                <button class="btn-xs" id="ev-toggle-open" title="Cambia stato evento">Chiudi evento</button>
                <button class="btn btn-xs btn-primary" id="ev-open-form">➕ Nuova segnalazione</button>
            </div>

        </header>

        <div id="ev-body" class="grid gap-4 max-h-[70vh] overflow-auto">
            <section class="rounded-2xl border border-slate-200 bg-white p-4">
                <h4 class="text-sm font-semibold mb-2">Aree interessate</h4>
                <div id="ev-areas" class="tags"></div>
            </section>

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
                                <th class="px-3 py-2">Aree (Comune/Frazione)</th>
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
        </div>
    </div>
</div>

<!-- MODALE SOVRAPPOSTA: Nuova/Modifica Comunicazione Evento -->
<div class="c-modal c-modal--overlay hidden" id="modal-ev-form" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true" style="max-width:56rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h4 class="mb-2 text-lg font-semibold">Inserisci Nuova Comunicazione</h4>

        <form id="ev-form" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" id="ev-id" />
            <input type="hidden" id="ev-edit-index" />
            <input type="hidden" id="f-operatore" />

            <!-- ======== BASE ======== -->
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
                    <option value="" selected>Seleziona...</option>
                    <option>FAX</option>
                    <option>Email</option>
                    <option>Telefono</option>
                    <option>PEC</option>
                </select>
            </label>

            <div class="grid gap-1.5">
                <span class="label">Verso</span>
                <div class="flex items-center gap-4">
                    <label class="inline-flex items-center gap-2"><input type="radio" name="f-verso" value="Entrata" checked /> Entrata</label>
                    <label class="inline-flex items-center gap-2"><input type="radio" name="f-verso" value="Uscita" /> Uscita</label>
                </div>
            </div>

            <label class="grid gap-1.5 md:col-span-2"><span class="label">Mittente/Destinatario</span><input id="f-mitt" class="input" /></label>
            <label class="grid gap-1.5"><span class="label">Telefono</span><input id="f-tel" class="input" /></label>
            <label class="grid gap-1.5"><span class="label">E-mail</span><input id="f-mail" class="input" type="email" /></label>
            <label class="grid gap-1.5 md:col-span-2"><span class="label">Indirizzo zona colpita</span><input id="f-indirizzo" class="input" /></label>

            <label class="grid gap-1.5">
                <span class="label">Provincia</span>
                <select id="f-provincia" class="input">
                    <option value="">Tutte le province...</option>
                </select>
            </label>
            <label class="grid gap-1.5">
                <span class="label">Zona (Comune)</span>
                <select id="f-comune" class="input" disabled>
                    <option value="">Prima seleziona una provincia...</option>
                </select>
            </label>

            <label class="grid gap-1.5 md:col-span-2">
                <span class="label">Aree interessate (Comuni e Frazioni)</span>
                <div class="tag-input" id="ev-aree-input" data-datalist="comuni-datalist"></div>
            </label>

            <label class="grid gap-1.5 md:col-span-2"><span class="label">Oggetto</span><input id="f-oggetto" class="input" /></label>
            <label class="grid gap-1.5 md:col-span-2"><span class="label">Contenuto</span><textarea id="f-contenuto" class="input"></textarea></label>

            <div class="md:col-span-2">
                <span class="label">Priorità</span>
                <div class="flex flex-wrap items-center gap-4 mt-1">
                    <label class="inline-flex items-center gap-2"><input type="radio" name="f-priorita" value="Nessuna" checked /> Nessuna</label>
                    <label class="inline-flex items-center gap-2"><input type="radio" name="f-priorita" value="Alta" /> Alta</label>
                    <label class="inline-flex items-center gap-2"><input type="radio" name="f-priorita" value="Media" /> Media</label>
                    <label class="inline-flex items-center gap-2"><input type="radio" name="f-priorita" value="Bassa" /> Bassa</label>
                </div>
            </div>

            <!-- ======== SPECIFICI ======== -->
            <div class="md:col-span-2">
                <legend class="text-sm font-semibold mb-1">Campi specifici</legend>
                <div id="ev-specific"></div>
            </div>

            <div class="md:col-span-2 flex justify-end gap-2 pt-2">
                <button type="button" class="btn" data-close-modal>Annulla</button>
                <button type="reset" class="btn">Reset</button>
                <button type="submit" class="btn btn-primary" id="ev-save">💾 Salva Comunicazione</button>
            </div>

        </form>
    </div>
</div>

<!-- MODALE: Tutte le comunicazioni (tutti gli eventi) — al TOP -->
<div class="c-modal c-modal--top hidden" id="modal-all-reports" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true" style="max-width:90rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h3 class="mb-3 text-lg font-semibold">Tutte le comunicazioni — Eventi in atto</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr>
                        <th class="px-3 py-2">Data</th>
                        <th class="px-3 py-2">Ora</th>
                        <th class="px-3 py-2">Evento</th>
                        <th class="px-3 py-2">Tipo</th>
                        <th class="px-3 py-2">Verso</th>
                        <th class="px-3 py-2">Mitt./Dest.</th>
                        <th class="px-3 py-2">Telefono</th>
                        <th class="px-3 py-2">E-mail</th>
                        <th class="px-3 py-2">Oggetto</th>
                        <th class="px-3 py-2">Priorità</th>
                    </tr>
                </thead>
                <tbody id="all-reports-tbody"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========== MODALE: Dettagli Segnalazione Generica ========== -->
<div class="c-modal hidden" id="modal-gen-info" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true" style="max-width:48rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h3 class="mb-2 text-lg font-semibold">Dettagli segnalazione</h3>

        <div id="gen-info-body" class="grid gap-3"></div>

        <div class="flex justify-end mt-3 gap-2">
            <button type="button" class="btn" data-close-modal>Chiudi</button>
            <button type="button" class="btn btn-primary" id="gen-info-copy">Copia JSON</button>
        </div>
    </div>
</div>

<!-- Datalist Comuni -->
<datalist id="comuni-datalist"></datalist>

<script type="module">
    /* ===== Utils ===== */
    const $ = (s) => document.querySelector(s);
    const fmtDT = (d) =>
        new Intl.DateTimeFormat("it-IT", {
            dateStyle: "short",
            timeStyle: "short"
        }).format(d);
    const PREVIEW_MAX = 160;
    const truncate = (str = "", n = PREVIEW_MAX) =>
        (str.length > n ? str.slice(0, n).trimEnd() + "…" : str);
    const nowIT = () => {
        const d = new Date();
        const pad = (n) => String(n).padStart(2, "0");
        return {
            date: `${pad(d.getDate())}/${pad(d.getMonth() + 1)}/${d.getFullYear()}`,
            time: `${pad(d.getHours())}:${pad(d.getMinutes())}`
        };
    };
    const toITParts = (d) => {
        const pad = (n) => String(n).padStart(2, "0");
        return {
            date: `${pad(d.getDate())}/${pad(d.getMonth() + 1)}/${d.getFullYear()}`,
            time: `${pad(d.getHours())}:${pad(d.getMinutes())}`
        };
    };
    const parseIT = (dateStr, timeStr = "00:00") => {
        const [dd, mm, yyyy] = (dateStr || "").split("/");
        const [HH, MM] = (timeStr || "00:00").split(":");
        return new Date(Number(yyyy), Number(mm) - 1, Number(dd), Number(HH), Number(MM));
    };

    /* ===== SweetAlert helpers ===== */
    const toast = (title, text = "", icon = "success", timer = 1700) => {
        Swal.fire({
            title,
            text,
            icon,
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer,
            timerProgressBar: true
        });
    };
    const confirmDelete = (
            title = "Eliminare la segnalazione?",
            text = "Questa azione non può essere annullata."
        ) =>
        Swal.fire({
            title,
            text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sì, elimina",
            cancelButtonText: "Annulla",
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
        });

    function fallbackCopy(text) {
        try {
            const ta = document.createElement("textarea");
            ta.value = text;
            ta.style.position = "fixed";
            ta.style.left = "-9999px";
            document.body.appendChild(ta);
            ta.select();
            document.execCommand("copy");
            document.body.removeChild(ta);
            toast("Copiato negli appunti", "JSON della segnalazione copiato.");
        } catch {
            toast("Errore copia", "Impossibile copiare il JSON.", "error");
        }
    }

    /* ===== Tag Input ===== */
    class TagInput {
        constructor(root, {
            placeholder = "Aggiungi e premi Invio",
            datalistId = null
        } = {}) {
            this.root = root;
            this.values = [];
            this.placeholder = placeholder;
            this.datalistId = datalistId;
            this.render();
        }
        render() {
            this.root.classList.add("tag-input--wrap");
            this.root.innerHTML = `<div class="tags" role="list"></div><div class="tag-input__control"><input class="tag-input__field" ${
        this.datalistId ? `list="${this.datalistId}"` : ""
      } placeholder="${this.placeholder}"/></div>`;
            this.tagsEl = this.root.querySelector(".tags");
            this.inputEl = this.root.querySelector(".tag-input__field");
            this.inputEl.addEventListener("keydown", (e) => {
                if (e.key === "Enter" && this.inputEl.value.trim()) {
                    e.preventDefault();
                    this.add(this.inputEl.value.trim());
                    this.inputEl.value = "";
                } else if (e.key === "Backspace" && !this.inputEl.value && this.values.length) {
                    this.remove(this.values.length - 1);
                }
            });
        }
        setValues(arr) {
            this.values = Array.isArray(arr) ? arr.filter(Boolean) : [];
            this.refresh();
        }
        add(v) {
            if (!v) return;
            if (!this.values.includes(v)) this.values.push(v);
            this.refresh();
        }
        remove(idx) {
            this.values.splice(idx, 1);
            this.refresh();
        }
        refresh() {
            this.tagsEl.replaceChildren();
            this.values.forEach((val, i) => {
                const tag = document.createElement("span");
                tag.className = "tag";
                tag.innerHTML = `<span class="tag__text">${val}</span><button class="tag__x" title="Rimuovi" aria-label="Rimuovi">×</button>`;
                tag.querySelector(".tag__x").addEventListener("click", () => this.remove(i));
                this.tagsEl.appendChild(tag);
            });
            this.root.dispatchEvent(new CustomEvent("change", {
                detail: this.values.slice()
            }));
        }
    }

    /* ===== Comuni & Province seed (UI) ===== */
    const COMUNI = [
        "Adria", "Affi", "Albignasego", "Bologna", "Bussolengo", "Farra di Soligo", "Milano", "Napoli", "Roma", "Rovigo", "Torino", "Verona", "Vicenza", "Venezia",
    ];
    COMUNI.forEach((c) => {
        const o = document.createElement("option");
        o.value = c;
        $("#comuni-datalist").appendChild(o);
    });
    const PROVINCE = {
        VR: ["Verona", "Affi", "Bussolengo"],
        VI: ["Vicenza"],
        VE: ["Venezia"],
        RO: ["Rovigo", "Adria"],
        TV: ["Farra di Soligo"],
        BO: ["Bologna"],
        MI: ["Milano"],
        NA: ["Napoli"],
        RM: ["Roma"],
        TO: ["Torino"],
    };

    /* ===== Tipi evento ===== */
    const TYPES = [
        "sismico", "vulcanico", "idraulico", "idrogeologico", "maremoto", "deficit-idrico", "meteo-avverso", "aib", "uomo", "altro",
    ];
    const TYPE_LABELS = {
        sismico: "Sismico",
        vulcanico: "Vulcanico",
        idraulico: "Idraulico",
        idrogeologico: "Idrogeologico",
        maremoto: "Maremoto",
        "deficit-idrico": "Deficit Idrico",
        "meteo-avverso": "Meteo Avverso",
        aib: "AIB",
        uomo: "Prodotti dall'uomo",
        altro: "Altro",
    };

    /* ===== Schemi specifici (GEN form) ===== */
    const SPEC_SCHEMAS = {
        sismico: [{
                id: "magnitudo",
                label: "Magnitudo (se disponibile)"
            },
            {
                id: "intensita",
                label: "Intensità MCS/EMS"
            },
            {
                id: "coordinate",
                label: "Coordinate epicentro"
            },
            {
                id: "danni",
                label: "Danni segnalati (testo)",
                type: "textarea"
            },
        ],
        vulcanico: [{
                id: "tremore",
                label: "Tremore vulcanico (trend)"
            },
            {
                id: "cenere",
                label: "Ricaduta ceneri (aree)"
            },
            {
                id: "dpi",
                label: "DPI distribuiti (qtà)"
            },
        ],
        idraulico: [{
                id: "livello",
                label: "Livello idrometrico (m)"
            },
            {
                id: "argine",
                label: "Criticità arginale (sì/no)"
            },
            {
                id: "sottopassi",
                label: "Sottopassi allagati (#)"
            },
        ],
        idrogeologico: [{
                id: "tipologia_frana",
                label: "Tipologia frana"
            },
            {
                id: "volume",
                label: "Volume stimato (mc)"
            },
            {
                id: "viabilita",
                label: "Interferenza viabilità (testo)",
                type: "textarea"
            },
        ],
        maremoto: [{
                id: "allerta",
                label: "Livello allerta"
            },
            {
                id: "aree_costiere",
                label: "Aree costiere interessate"
            },
        ],
        "deficit-idrico": [{
                id: "pressione",
                label: "Riduzione pressione (%)"
            },
            {
                id: "autobotti",
                label: "Autobotti in servizio (#)"
            },
        ],
        "meteo-avverso": [{
                id: "fenomeno",
                label: "Fenomeno prevalente (vento, grandine…)"
            },
            {
                id: "intensita",
                label: "Intensità"
            },
            {
                id: "danni_diffusi",
                label: "Danni diffusi? (sì/no)"
            },
        ],
        aib: [{
                id: "superficie",
                label: "Superficie percorsa dal fuoco (ha)"
            },
            {
                id: "combustibile",
                label: "Tipo combustibile (bosco, sterpaglie…)"
            },
            {
                id: "coordinate",
                label: "Coordinate/Località puntuale"
            },
            {
                id: "mezzi",
                label: "Mezzi impiegati (AIB/VVF/CAI…)"
            },
            {
                id: "meteo",
                label: "Condizioni meteo (vento, umidità…)"
            },
        ],
        uomo: [{
                id: "tipologia",
                label: "Tipologia incidente (sversamento, industriale…)"
            },
            {
                id: "ente_coinvolto",
                label: "Ente/Azienda coinvolta"
            },
            {
                id: "impatti",
                label: "Impatti su servizi/ambiente",
                type: "textarea"
            },
        ],
        altro: [{
            id: "descrizione",
            label: "Descrizione dettagli (testo)",
            type: "textarea"
        }],
    };

    function renderSpecific(container, type, prefix) {
        container.innerHTML = "";
        const schema = SPEC_SCHEMAS[type] || [];
        if (!schema.length) {
            container.innerHTML = `<div class="text-xs opacity-70">Nessun campo aggiuntivo per questa tipologia.</div>`;
            return;
        }
        const grid = document.createElement("div");
        grid.className = "grid md:grid-cols-2 gap-3";
        schema.forEach((f) => {
            const wrap = document.createElement("label");
            wrap.className = "grid gap-1.5";
            wrap.innerHTML =
                `<span class="label">${f.label}</span>` +
                (f.type === "textarea" ?
                    `<textarea class="input" id="${prefix}-${f.id}"></textarea>` :
                    `<input class="input" id="${prefix}-${f.id}"/>`);
            grid.appendChild(wrap);
        });
        container.appendChild(grid);
    }

    /* ===== Stato (backend only) ===== */
    const state = {
        gen: [],
        ongoing: [],
        page: {
            gen: 1,
            ongoing: 1
        },
        global: {
            q: "",
            date: "",
            time: "",
            comune: ""
        },
        ui: {
            currentEventId: null,
            genInfoJson: null,
            ongoingStatus: "all"
        },
    };

    /* ===== Helpers eventi ===== */
    function prioClass(p = "Nessuna") {
        const k = (p || "").toLowerCase();
        return k === "alta" ? "prio--alta" : k === "media" ? "prio--media" : k === "bassa" ? "prio--bassa" : "prio--nessuna";
    }

    function makePrioBadge(p = "Nessuna") {
        const span = document.createElement("span");
        span.className = "prio-badge " + prioClass(p);
        span.textContent = p || "Nessuna";
        return span;
    }

    function makeDirBadge(val) {
        const v = (val || "").toString().trim().toUpperCase();
        const isIn = v === "E" || v === "ENTRATA";
        const s = document.createElement("span");
        s.className = "badge " + (isIn ? "badge--in" : "badge--out");
        s.textContent = isIn ? "E" : "U";
        s.title = isIn ? "Entrata" : "Uscita";
        return s;
    }

    function addReadMoreCell(td, fullText, title) {
        const preview = document.createElement("span");
        preview.textContent = truncate(fullText || "");
        const space = document.createTextNode(" ");
        const btn = document.createElement("button");
        btn.type = "button";
        btn.className = "link rm-link";
        btn.textContent = "Mostra di più";
        btn.addEventListener("click", () => openReadMore(title || "Dettagli", fullText || ""));
        td.append(preview, space, btn);
    }

    /* ===== Build select eventi ===== */
    function populateEventSelect(selectEl, selectedId = "", withCreate = true) {
        if (!selectEl) return;
        selectEl.querySelectorAll("option").forEach((o, i) => {
            if (i > 0) o.remove();
        });
        if (withCreate) {
            const create = document.createElement("option");
            create.value = "__new__";
            create.textContent = "[+ Crea nuovo evento]";
            selectEl.appendChild(create);
        }
        state.ongoing.forEach((ev) => {
            const opt = document.createElement("option");
            opt.value = String(ev.id);
            const typeLabel = TYPE_LABELS[ev.tipo] || ev.tipo;
            const areas = (ev.aree || []).join(", ");
            opt.textContent = `[${typeLabel}] ${areas}`;
            selectEl.appendChild(opt);
        });
        selectEl.value = selectedId ? String(selectedId) : "";
    }

    /* ===== Read-More modal ===== */
    (function ensureReadMoreModal() {
        if ($("#modal-readmore")) return;
        const wrap = document.createElement("div");
        wrap.className = "c-modal hidden";
        wrap.id = "modal-readmore";
        wrap.setAttribute("aria-hidden", "true");
        wrap.innerHTML = `<div class="c-modal__backdrop" data-close-modal></div><div class="c-modal__dialog" role="dialog" aria-modal="true"><button type="button" class="c-modal__close" data-close-modal>✕</button><h3 id="rm-title" class="mb-2 text-lg font-semibold">Dettagli</h3><div id="rm-body" class="rm-body text-sm"></div><div class="flex justify-end mt-4"><button type="button" class="btn" data-close-modal>Chiudi</button></div></div>`;
        document.body.appendChild(wrap);
    })();

    function openReadMore(title, text) {
        const t = $("#rm-title"),
            b = $("#rm-body");
        if (t) t.textContent = title || "Dettagli";
        if (b) b.textContent = text || "—";
        openModal("#modal-readmore");
    }

    /* ===== Modal helpers ===== */
    function openModal(sel) {
        const m = document.querySelector(sel);
        if (!m) return;
        if (sel === "#modal-gen") {
            populateEventSelect($("#gen-event-select"), "", true);
            renderEvPreview($("#gen-event-select").value, $("#gen-event-select"));
        }
        m.classList.remove("hidden");
        m.classList.add("is-open");
        document.body.style.overflow = "hidden";
    }
    document.getElementById("modal-event")?.classList.add("c-modal--super");

    function closeModal(el) {
        if (!el) return;
        el.classList.remove("is-open");
        el.classList.add("hidden");
        if (!document.querySelector(".c-modal.is-open")) document.body.style.overflow = "";
    }

    /* ===== API layer (Fortify session + JSON) ===== */
    const API = {
        base: "/api/sor",
        csrf() {
            return document.querySelector('meta[name="csrf-token"]')?.content || "";
        },
        async _req(path, {
            method = "GET",
            params = null,
            body = null
        } = {}) {
            const url = new URL(API.base + path, location.origin);
            if (params) Object.entries(params).forEach(([k, v]) => (v ?? v === 0) && url.searchParams.set(k, v));
            const isJSON = body && !(body instanceof FormData);
            const res = await fetch(url.toString(), {
                method,
                credentials: "include",
                headers: {
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    ...(isJSON ? {
                        "Content-Type": "application/json"
                    } : {}),
                    ...(method !== "GET" ? {
                        "X-CSRF-TOKEN": API.csrf()
                    } : {}),
                },
                body: isJSON ? JSON.stringify(body) : body,
            });
            if (!res.ok) {
                const txt = await res.text().catch(() => "");
                throw new Error(`HTTP ${res.status} ${res.statusText}\n${txt}`);
            }
            const ctype = res.headers.get("content-type") || "";
            return ctype.includes("application/json") ? res.json() : res;
        },

        // --- Segnalazioni ---
        listSegnalazioni(params) {
            return this._req("/segnalazioni", {
                params
            });
        },
        createSegnalazione(payload) {
            return this._req("/segnalazioni", {
                method: "POST",
                body: payload
            });
        },
        updateSegnalazione(id, payload) {
            return this._req(`/segnalazioni/${id}`, {
                method: "PATCH",
                body: payload
            });
        },
        deleteSegnalazione(id) {
            return this._req(`/segnalazioni/${id}`, {
                method: "DELETE"
            });
        },
        exportSegnalazioni(params) {
            return this._req("/segnalazioni/export.csv", {
                params
            });
        },

        // --- Eventi ---
        listEventi(params) {
            return this._req("/eventi", {
                params
            });
        },
        getEvento(id) {
            return this._req(`/eventi/${id}`);
        },
        createEvento(payload) {
            return this._req("/eventi", {
                method: "POST",
                body: payload
            });
        },
        toggleEvento(id) {
            return this._req(`/eventi/${id}/toggle`, {
                method: "PATCH"
            });
        },
        addComunicazione(eventoId, payload) {
            return this._req(`/eventi/${eventoId}/comunicazioni`, {
                method: "POST",
                body: payload
            });
        },
        exportEventi(params) {
            return this._req("/eventi/export.csv", {
                params
            });
        },
    };

    /* ===== Mapper API <-> UI ===== */
    const mapSegToUI = (s) => ({
        id: s.id,
        created_at: s.creata_il,
        direzione: s.direzione, // "E" | "U"
        tipologia: s.tipologia,
        aree: s.aree || [],
        sintesi: s.sintesi || "",
        operatore: s.operatore || "",
        event_id: s.evento_id ? String(s.evento_id) : "",
        priorita: s.priorita || "Nessuna",
    });
    const mapEvToUI = (e) => ({
        id: e.id,
        tipo: e.tipologia,
        descrizione: e.descrizione || "",
        aggiornamento: e.aggiornato_il,
        operatore: e.operatore || "",
        aree: e.aree || [],
        open: !!e.aperto,
    });
    const mapComToUI = (c) => {
        const dt = c.comunicata_il ? new Date(c.comunicata_il) : null;
        const itDate = dt ? dt.toLocaleDateString("it-IT") : "";
        const itTime = dt ? dt.toTimeString().slice(0, 5) : "";
        return {
            data: itDate,
            ora: itTime,
            tipo: c.tipo || "—",
            verso: c.verso || "Entrata",
            mitt: c.mitt_dest || "",
            tel: c.telefono || "",
            mail: c.email || "",
            indirizzo: c.indirizzo || "",
            provincia: c.provincia || "",
            comune: c.comune || "",
            aree: c.aree || [],
            oggetto: c.oggetto || "",
            priorita: c.priorita || "Nessuna",
            contenuto: c.contenuto || "",
        };
    };

    /* ===== Caricamento da backend ===== */
    async function refreshGEN() {
        const params = {
            page: state.page.gen,
            per_page: 10,
            q: state.global.q || null,
            comune: state.global.comune || null,
            date: state.global.date || null,
            time: state.global.time || null,
            dal: $("#gen-filter-dal").value || null,
            al: $("#gen-filter-al").value || null,
        };
        const res = await API.listSegnalazioni(params); // {data, meta}
        state.gen = (res.data || []).map(mapSegToUI);
        $("#gen-page").textContent = `Pagina ${res.meta.current_page} di ${res.meta.last_page}`;
        $("#gen-prev").disabled = res.meta.current_page <= 1;
        $("#gen-next").disabled = res.meta.current_page >= res.meta.last_page;
        renderGEN();
    }

    async function refreshONGOING() {
        const params = {
            page: state.page.ongoing,
            per_page: 10,
            q: state.global.q || null,
            comune: state.global.comune || null,
            date: state.global.date || null,
            time: state.global.time || null,
            dal: $("#ongoing-filter-dal").value || null,
            al: $("#ongoing-filter-al").value || null,
            status: state.ui.ongoingStatus, // "all" | "open" | "closed"
        };
        const res = await API.listEventi(params); // {data, meta}
        state.ongoing = (res.data || []).map(mapEvToUI);
        $("#ongoing-page").textContent = `Pagina ${res.meta.current_page} di ${res.meta.last_page}`;
        $("#ongoing-prev").disabled = res.meta.current_page <= 1;
        $("#ongoing-next").disabled = res.meta.current_page >= res.meta.last_page;
        renderONGOING();
    }

    // avvio
    (async function init() {
        await Promise.all([refreshGEN(), refreshONGOING()]);
        if (window.lucide) lucide.createIcons();
    })();

    /* ===== Render: GENERICHE (usa dati già paginati/filtrati dal backend) ===== */
    function renderGEN() {
        const root = $("#gen-body");
        root.replaceChildren();

        state.gen.forEach((r) => {
            const tr = document.createElement("tr");
            tr.className = "border-t border-slate-200";
            tr.dataset.id = r.id;
            tr.classList.add("prio-row", prioClass(r.priorita));

            const tdDt = Object.assign(document.createElement("td"), {
                className: "px-3 py-2",
                textContent: r.created_at ? fmtDT(new Date(r.created_at)) : "—",
            });

            const tdDir = Object.assign(document.createElement("td"), {
                className: "px-3 py-2"
            });
            tdDir.appendChild(makeDirBadge(r.direzione));

            const tdTp = Object.assign(document.createElement("td"), {
                className: "px-3 py-2",
                textContent: TYPE_LABELS[r.tipologia] || r.tipologia || "",
            });

            const tdAr = Object.assign(document.createElement("td"), {
                className: "px-3 py-2",
                textContent: (r.aree || []).join(", "),
            });

            const tdSy = Object.assign(document.createElement("td"), {
                className: "px-3 py-2 w-sintesi"
            });
            addReadMoreCell(tdSy, r.sintesi || "", "Segnalazione");

            const tdOp = Object.assign(document.createElement("td"), {
                className: "px-3 py-2",
                textContent: r.operatore || "",
            });

            const tdEv = Object.assign(document.createElement("td"), {
                className: "px-3 py-2"
            });
            if (r.event_id) {
                const btn = document.createElement("button");
                btn.type = "button";
                btn.className = "link ev-link";
                btn.dataset.openEvent = String(r.event_id);
                btn.textContent = `Evento #${r.event_id}`;
                tdEv.appendChild(btn);
            } else {
                tdEv.textContent = "—";
            }

            const tdAc = document.createElement("td");
            tdAc.className = "px-3 py-2";
            tdAc.innerHTML = `
        <div class="actions">
          <button class="btn-xs btn-ghost" title="Dettagli" data-action="info" data-type="gen" data-id="${r.id}">ℹ️</button>
          <button class="btn-xs btn-ghost" title="Modifica" data-action="edit" data-type="gen" data-id="${r.id}">✏️</button>
          <button class="btn-xs btn-danger" title="Elimina" data-action="del" data-type="gen" data-id="${r.id}">🗑️</button>
        </div>`;

            tr.append(tdDt, tdDir, tdTp, tdAr, tdSy, tdOp, tdEv, tdAc);
            root.appendChild(tr);
        });

        if (window.lucide) lucide.createIcons();
    }

    /* ===== Legend + ONGOING ===== */
    function ensureLegend() {
        if ($("#ongoing-legend")) return;
        const legend = document.createElement("div");
        legend.id = "ongoing-legend";
        legend.className = "ongoing-legend";
        legend.innerHTML = TYPES.map((t) => `<span class="ol-item" data-type="${t}"><i class="ol-dot" aria-hidden="true"></i>${TYPE_LABELS[t]}</span>`).join("");
        const cards = $("#ongoing-cards");
        cards.parentNode.insertBefore(legend, cards);
    }

    function renderONGOING() {
        ensureLegend();
        const root = $("#ongoing-cards");
        root.replaceChildren();

        if (!state.ongoing.length) {
            const empty = document.createElement("div");
            empty.className = "text-sm opacity-70 px-3 py-2";
            empty.textContent = "Nessun evento in atto.";
            root.appendChild(empty);
            return;
        }

        state.ongoing.forEach((ev) => {
            const typeKey = TYPES.includes(ev.tipo) ? ev.tipo : "altro";
            const typeLabel = TYPE_LABELS[typeKey];
            const isOpen = ev.open !== false;
            const quando = ev.aggiornamento ? fmtDT(new Date(ev.aggiornamento)) : "—";
            const aree = (ev.aree || []).join(", ");

            const card = document.createElement("article");
            card.className = "ev-card";
            card.dataset.type = typeKey;
            card.tabIndex = 0;
            card.setAttribute("role", "button");
            card.addEventListener("click", () => openEventModal(ev.id));
            card.innerHTML = `
        <div class="ev-card__head">
          <h4 class="ev-card__title">${ev.descrizione || "Evento"}</h4>
          <div class="ev-card__chips">
            <span class="ev-card__status ${isOpen ? "is-open" : "is-closed"}">${isOpen ? "Aperto" : "Chiuso"}</span>
            <span class="ev-card__badge">${typeLabel}</span>
          </div>
        </div>
        <ul class="ev-card__meta">
          <li><strong>Ultimo agg.:</strong> ${quando}</li>
          <li><strong>Aree:</strong> ${aree || "—"}</li>
        </ul>`;
            root.appendChild(card);
        });
    }

    function updateEventStatusUI(ev) {
        const st = document.querySelector("#ev-subtitle .ev-inline-status");
        if (st) {
            st.classList.toggle("is-open", ev.open !== false);
            st.classList.toggle("is-closed", ev.open === false);
            st.textContent = ev.open !== false ? "Aperto" : "Chiuso";
        }
        const btn = $("#ev-toggle-open");
        if (btn) {
            btn.textContent = ev.open !== false ? "Chiudi evento" : "Riapri evento";
            btn.title = btn.textContent;
        }
    }

    /* ===== Evento: open modal + popolamento dal backend ===== */
    async function openEventModal(eventId) {
        state.ui.currentEventId = eventId;
        const full = await API.getEvento(eventId); // include comunicazioni
        const ev = mapEvToUI(full);
        ev.reports = (full.comunicazioni || []).map(mapComToUI);

        $("#ev-title").textContent = ev.descrizione || "—";
        const subtitle = $("#ev-subtitle");
        subtitle.textContent = `${TYPE_LABELS[ev.tipo] || ev.tipo} • Ultimo agg.: ${fmtDT(new Date(ev.aggiornamento))} `;
        const st = document.createElement("span");
        st.className = `ev-inline-status ${ev.open !== false ? "is-open" : "is-closed"}`;
        st.textContent = ev.open !== false ? "Aperto" : "Chiuso";
        subtitle.appendChild(st);

        renderEventAreas(ev);
        renderEventReports(ev);
        resetEvForm(ev.tipo, ev.aree);
        updateEventStatusUI(ev);
        $("#ev-id").value = ev.id;
        openModal("#modal-event");
    }

    function renderEventAreas(ev) {
        const wrap = $("#ev-areas");
        wrap.replaceChildren();
        (ev.aree || []).forEach((a) => {
            const tag = document.createElement("span");
            tag.className = "tag";
            tag.textContent = a;
            wrap.appendChild(tag);
        });
    }

    function renderEventReports(ev) {
        const tbody = $("#ev-reports-tbody");
        tbody.replaceChildren();

        const rows = (ev.reports || []).map((r, idx) => ({
            ...r,
            _idx: idx
        }));
        if (!rows.length) {
            const tr = document.createElement("tr");
            const td = document.createElement("td");
            td.colSpan = 10;
            td.className = "px-3 py-3 opacity-70";
            td.textContent = "Nessuna segnalazione.";
            tr.appendChild(td);
            tbody.appendChild(tr);
            return;
        }

        rows.forEach((r) => {
            const tr = document.createElement("tr");
            tr.className = "border-t border-slate-200 hover:bg-slate-50 cursor-pointer";
            tr.classList.add("prio-row", prioClass(r.priorita));
            tr.dataset.idx = r._idx;

            tr.addEventListener("click", () => {
                loadReportIntoForm(r._idx);
                openModal("#modal-ev-form");
                $("#ev-save").textContent = "Salva modifiche";
            });

            const tdData = document.createElement("td");
            tdData.className = "px-3 py-2";
            tdData.textContent = r.data || "";
            tr.appendChild(tdData);

            const tdOra = document.createElement("td");
            tdOra.className = "px-3 py-2";
            tdOra.textContent = r.ora || "";
            tr.appendChild(tdOra);

            const tdTipo = document.createElement("td");
            tdTipo.className = "px-3 py-2";
            tdTipo.textContent = r.tipo || "";
            tr.appendChild(tdTipo);

            const tdVerso = document.createElement("td");
            tdVerso.className = "px-3 py-2 text-center";
            tdVerso.dataset.verso = "1";
            const raw = (r.verso || "").trim().toUpperCase();
            const dir = raw.startsWith("U") ? "U" : "E";
            tdVerso.appendChild(makeDirBadge(dir));
            tr.appendChild(tdVerso);

            const cells = [r.mitt, r.tel, r.mail, (r.aree || []).join(", "), r.oggetto];
            cells.forEach((v) => {
                const td = document.createElement("td");
                td.className = "px-3 py-2";
                td.textContent = v || "";
                tr.appendChild(td);
            });

            const tdPr = document.createElement("td");
            tdPr.className = "px-3 py-2";
            tdPr.appendChild(makePrioBadge(r.priorita || "Nessuna"));
            tr.appendChild(tdPr);

            tbody.appendChild(tr);
        });
    }

    /* ===== Dynamic specific forms (EV) ===== */
    function resetEvForm(type, areas) {
        $("#ev-edit-index").value = "";
        $("#ev-form").reset?.();
        const {
            date,
            time
        } = nowIT();
        $("#f-data").value = date;
        $("#f-ora").value = time;
        $("#f-tipo").value = "";
        document.querySelector('input[name="f-verso"][value="Entrata"]').checked = true;
        $("#f-mitt").value = "";
        $("#f-tel").value = "";
        $("#f-mail").value = "";
        $("#f-indirizzo").value = "";
        $("#f-oggetto").value = "";
        $("#f-contenuto").value = "";
        document.querySelector('input[name="f-priorita"][value="Nessuna"]').checked = true;
        evAreeInput.setValues(areas || []);
        populateProvinceSelect();
        $("#f-comune").innerHTML = `<option value="">Prima seleziona una provincia...</option>`;
        $("#f-comune").disabled = true;
        const container = $("#ev-specific");
        container.innerHTML = "";
        const hint = document.createElement("div");
        hint.className = "text-xs opacity-70";
        hint.textContent = `Tipologia evento: ${TYPE_LABELS[type] || type || "—"}. Aggiungi eventuali dettagli nella comunicazione.`;
        container.appendChild(hint);
    }

    function loadReportIntoForm(idx) {
        // Carica dalla tabella già popolata (ev.reports in modale evento)
        const ev = {
            reports: []
        };
        const trs = Array.from($("#ev-reports-tbody")?.querySelectorAll("tr") || []);
        // usa state.ui.currentEventId + getEvento se vuoi ricaricare; qui usiamo state corrente
        const currentIdx = Number(idx);
        if (Number.isNaN(currentIdx)) return;

        // Non abbiamo i dati grezzi qui: openEventModal ha ev.reports; ricarichiamo dall'ultima fetch:
        // per semplicità, ripetiamo l'ultima lettura dal DOM mappando le celle (sufficiente per prefill)
        const row = trs.find((r) => String(r.dataset.idx) === String(idx));
        if (!row) return;

        const cells = row.querySelectorAll("td");
        $("#ev-edit-index").value = idx;
        $("#f-data").value = cells[0]?.textContent?.trim() || "";
        $("#f-ora").value = cells[1]?.textContent?.trim() || "";
        $("#f-tipo").value = cells[2]?.textContent?.trim() || "";
        const badge = cells[3]?.querySelector(".badge");
        const verso = badge?.title === "Uscita" ? "Uscita" : "Entrata";
        const radio = document.querySelector(`input[name="f-verso"][value="${verso}"]`);
        if (radio) radio.checked = true;
        $("#f-mitt").value = cells[4]?.textContent?.trim() || "";
        $("#f-tel").value = cells[5]?.textContent?.trim() || "";
        $("#f-mail").value = cells[6]?.textContent?.trim() || "";
        // Aree / Oggetto non si ricostruiscono facilmente dal DOM del dettaglio -> lasciamo vuoti
    }

    /* ===== Province/Comuni selects ===== */
    function populateProvinceSelect(selected = "") {
        const sel = $("#f-provincia");
        sel.innerHTML = "";
        const first = new Option("Tutte le province...", "");
        sel.add(first);
        Object.keys(PROVINCE)
            .sort()
            .forEach((k) => sel.add(new Option(`${k}`, k)));
        sel.value = selected || "";
        $("#f-comune").disabled = !sel.value;
    }

    function populateComuniSelect(prov, selected = "") {
        const comuneSel = $("#f-comune");
        comuneSel.innerHTML = "";
        if (!prov) {
            comuneSel.add(new Option("Prima seleziona una provincia...", ""));
            comuneSel.disabled = true;
            return;
        }
        (PROVINCE[prov] || []).forEach((c) => comuneSel.add(new Option(c, c)));
        comuneSel.disabled = false;
        comuneSel.value = selected || "";
    }
    $("#f-provincia").addEventListener("change", (e) => populateComuniSelect(e.target.value));

    /* ===== RESET HANDLERS ===== */
    document.getElementById("form-gen").addEventListener("reset", (e) => {
        genAree.setValues([]);
        const tipSel = document.getElementById("gen-tipologia");
        if (tipSel) tipSel.value = "";
        const sp = document.getElementById("gen-specific");
        if (sp) sp.innerHTML = "";
        const sel = document.getElementById("gen-event-select");
        if (sel) {
            sel.value = "";
            renderEvPreview("", sel);
        }
        const hid = document.getElementById("gen-aree-hidden");
        if (hid) hid.value = "[]";
    });

    document.getElementById("form-edit-gen").addEventListener("reset", (e) => {
        const form = e.currentTarget;
        try {
            const initial = JSON.parse(form.dataset.initialAree || "[]");
            editAree.setValues(initial);
            const hid = document.getElementById("edit-aree-hidden");
            if (hid) hid.value = JSON.stringify(initial);
        } catch {
            editAree.setValues([]);
        }
        const sel = document.getElementById("edit-gen-event");
        if (sel) renderEvPreview(sel.value, sel);
    });

    document.getElementById("ev-form").addEventListener("reset", () => {
        // ripristina il form secondo la tipologia/aree dell’evento corrente (se aperto in modale)
        // non abbiamo l'oggetto evento qui; lasciamo le aree vuote
        evAreeInput.setValues([]);
    });

    /* ===== Clicks: open event link + azioni gen + copia JSON + close modals ===== */
    document.addEventListener("click", (e) => {
        const evBtn = e.target.closest("[data-open-event]");
        if (evBtn) {
            const id = +evBtn.dataset.openEvent;
            if (!Number.isNaN(id)) openEventModal(id);
            return;
        }

        const opener = e.target.closest("[data-open-modal]");
        if (opener) {
            e.preventDefault();
            openModal(opener.getAttribute("data-open-modal"));
            return;
        }

        const btn = e.target.closest("[data-action]");
        if (btn) {
            const {
                action,
                type,
                id
            } = btn.dataset;
            if (type !== "gen") return;
            if (action === "info") {
                openGenInfoModal(id);
                return;
            }
            if (action === "edit") {
                const item = state.gen.find((x) => String(x.id) === String(id));
                if (!item) return;
                fillForm($("#form-edit-gen"), {
                    ...item,
                    aree_json: JSON.stringify(item.aree || [])
                });
                populateEventSelect($("#edit-gen-event"), item.event_id || "", true);
                renderEvPreview($("#edit-gen-event").value, $("#edit-gen-event"));
                editAree.setValues(item.aree || []);
                $("#form-edit-gen").dataset.initialAree = JSON.stringify(item.aree || []);
                openModal("#modal-edit-gen");
                return;
            }
            if (action === "del") {
                confirmDelete().then(async (res) => {
                    if (!res.isConfirmed) return;
                    await API.deleteSegnalazione(id);
                    await refreshGEN();
                    toast("Eliminata!", "Rimossa dal backend.", "success");
                });
                return;
            }
        }

        if (e.target.id === "gen-info-copy" || e.target.closest("#gen-info-copy")) {
            const data = state.ui.genInfoJson ?? {};
            const text = JSON.stringify(data, null, 2);
            if (navigator.clipboard?.writeText) {
                navigator.clipboard
                    .writeText(text)
                    .then(() => toast("Copiato negli appunti", "JSON della segnalazione copiato."))
                    .catch(() => fallbackCopy(text));
            } else {
                fallbackCopy(text);
            }
            return;
        }

        if (e.target.closest("[data-close-modal]") || e.target.classList.contains("c-modal__backdrop")) {
            closeModal(e.target.closest(".c-modal"));
        }
    });

    /* ===== Bottone: nuova comunicazione dall’evento ===== */
    $("#ev-open-form").addEventListener("click", () => {
        // recupera l’evento corrente dal titolo/subtitle già settati; reset semplice:
        $("#ev-save").textContent = "💾 Salva Comunicazione";
        const defaultAreas = []; // non conosciamo qui ev.aree; si precompilerà a mano
        resetEvForm("altro", defaultAreas);
        openModal("#modal-ev-form");
    });

    /* ===== Paginazione (backend) ===== */
    $("#gen-prev").addEventListener("click", async () => {
        state.page.gen = Math.max(1, state.page.gen - 1);
        await refreshGEN();
    });
    $("#gen-next").addEventListener("click", async () => {
        state.page.gen += 1;
        await refreshGEN();
    });
    $("#ongoing-prev").addEventListener("click", async () => {
        state.page.ongoing = Math.max(1, state.page.ongoing - 1);
        await refreshONGOING();
    });
    $("#ongoing-next").addEventListener("click", async () => {
        state.page.ongoing += 1;
        await refreshONGOING();
    });

    /* ===== Toggle stato evento (backend) ===== */
    $("#ev-toggle-open")?.addEventListener("click", async () => {
        const id = state.ui.currentEventId;
        if (!id) return;
        await API.toggleEvento(id);
        await refreshONGOING();
        const full = await API.getEvento(id);
        updateEventStatusUI(mapEvToUI(full));
        toast("Stato evento aggiornato", "", "info", 1400);
    });

    $("#gen-event-select").addEventListener("change", (e) => {
        renderEvPreview(e.target.value, e.target);
    });
    $("#edit-gen-event").addEventListener("change", (e) => {
        renderEvPreview(e.target.value, e.target);
    });

    /* ===== Form helpers ===== */
    function fillForm(form, obj) {
        for (const el of form.elements) {
            if (!el.name) continue;
            const v = obj[el.name];
            if (el.type === "datetime-local") el.value = v ? v.slice(0, 16) : "";
            else if (el.type === "checkbox") el.checked = !!v;
            else el.value = v ?? "";
        }
    }

    /* ===== Submit GENERICO (CREA) -> backend ===== */
    $("#form-gen").addEventListener("submit", async (e) => {
        e.preventDefault();
        const fd = Object.fromEntries(new FormData(e.currentTarget).entries());
        const tipologia = $("#gen-tipologia").value || "altro";
        const priorita = (fd.priorita || "Nessuna").trim();
        const aree = genAree.values.slice();
        const chosenEvent = $("#gen-event-select").value;

        let evento_id = null;
        if (chosenEvent === "__new__") {
            const ev = await API.createEvento({
                tipologia,
                descrizione: fd.note || `Evento ${TYPE_LABELS[tipologia] || tipologia}`,
                aree,
                aperto: true,
            });
            evento_id = ev.id;
        } else if (chosenEvent) {
            evento_id = chosenEvent;
        }

        await API.createSegnalazione({
            direzione: "E",
            tipologia,
            aree,
            sintesi: fd.note || "",
            operatore: "operatore",
            priorita,
            evento_id,
        });

        if (evento_id) {
            await API.addComunicazione(evento_id, {
                comunicata_il: new Date().toISOString(),
                tipo: "—",
                verso: "Entrata",
                aree,
                oggetto: fd.note || `Segnalazione ${TYPE_LABELS[tipologia] || tipologia}`,
                contenuto: fd.note || "",
                priorita,
            });
        }

        closeModal($("#modal-gen"));
        e.currentTarget.reset();
        genAree.setValues([]);
        $("#gen-specific").innerHTML = "";
        await Promise.all([refreshGEN(), refreshONGOING()]);
        toast("Segnalazione aggiunta!", "Salvata su backend.");
    });

    $("#gen-tipologia").addEventListener("change", () => {
        const t = $("#gen-tipologia").value || "altro";
        renderSpecific($("#gen-specific"), t, "gensp");
    });

    /* ===== Submit GENERICO (EDIT) -> backend ===== */
    $("#form-edit-gen").addEventListener("submit", async (e) => {
        e.preventDefault();
        const fd = Object.fromEntries(new FormData(e.currentTarget).entries());
        const id = fd.id;
        let evento_id = (fd.event_id || "").trim() || null;

        if (evento_id === "__new__") {
            const base = state.gen.find((x) => String(x.id) === String(id));
            const ev = await API.createEvento({
                tipologia: base?.tipologia || "altro",
                descrizione: fd.sintesi || base?.sintesi || "Evento",
                aree: editAree.values.slice(),
                aperto: true,
            });
            evento_id = ev.id;

            await API.addComunicazione(ev.id, {
                comunicata_il: new Date().toISOString(),
                tipo: "—",
                verso: (fd.direzione || "E").toUpperCase() === "U" ? "Uscita" : "Entrata",
                aree: editAree.values.slice(),
                oggetto: fd.sintesi || base?.sintesi || "",
                contenuto: fd.sintesi || base?.sintesi || "",
                priorita: fd.priorita || "Nessuna",
            });
        }

        await API.updateSegnalazione(id, {
            creata_il: fd.created_at ? new Date(fd.created_at).toISOString() : null,
            direzione: fd.direzione,
            aree: editAree.values.slice(),
            sintesi: fd.sintesi,
            operatore: fd.operatore,
            priorita: fd.priorita,
            evento_id,
        });

        closeModal($("#modal-edit-gen"));
        await Promise.all([refreshGEN(), refreshONGOING()]);
        toast("Modifica salvata!", "Aggiornata su backend.");
    });

    /* ===== Submit EV-FORM -> backend (aggiunge nuova comunicazione) ===== */
    $("#ev-form").addEventListener("submit", async (e) => {
        e.preventDefault();
        const id = state.ui.currentEventId;
        if (!id) return;

        const d = $("#f-data").value.trim();
        const t = $("#f-ora").value.trim();
        const iso = d && t ? parseIT(d, t).toISOString() : null;

        const payload = {
            comunicata_il: iso,
            tipo: $("#f-tipo").value || "—",
            verso: document.querySelector('input[name="f-verso"]:checked')?.value || "Entrata",
            mitt_dest: $("#f-mitt").value.trim(),
            telefono: $("#f-tel").value.trim(),
            email: $("#f-mail").value.trim(),
            indirizzo: $("#f-indirizzo").value.trim(),
            provincia: $("#f-provincia").value,
            comune: $("#f-comune").value,
            aree: evAreeInput.values.slice(),
            oggetto: $("#f-oggetto").value.trim(),
            contenuto: $("#f-contenuto").value.trim(),
            priorita: document.querySelector('input[name="f-priorita"]:checked')?.value || "Nessuna",
        };

        await API.addComunicazione(id, payload);
        closeModal($("#modal-ev-form"));
        await openEventModal(id); // ricarica dettaglio
        await refreshONGOING();
        toast("Comunicazione salvata!", "Registrata su backend.");
    });

    /* ===== Modifica aree evento (solo UI) ===== */
    $("#ev-areas-edit").addEventListener("click", () => {
        Swal.fire({
            title: "Modifica Aree interessate",
            html: `<div class="tag-input" id="swal-areas" data-datalist="comuni-datalist"></div>`,
            didOpen: () => {
                const root = Swal.getHtmlContainer().querySelector("#swal-areas");
                const ti = new TagInput(root, {
                    datalistId: "comuni-datalist"
                });
                // Non abbiamo il dettaglio ev.aree qui; lasciamo vuoto per edit libero
                ti.setValues([]);
                root.addEventListener("change", (e) => {
                    root.dataset.values = JSON.stringify(e.detail || []);
                });
            },
            showCancelButton: true,
            confirmButtonText: "Chiudi",
            cancelButtonText: "Annulla",
        });
    });

    /* ===== All reports modal (placeholder: non avendo endpoint dedicato) ===== */
    document.getElementById("ongoing-all-reports").addEventListener("click", () => {
        const tbody = $("#all-reports-tbody");
        tbody.replaceChildren();
        const tr = document.createElement("tr");
        tr.innerHTML = `<td colspan="10" class="px-3 py-3 opacity-70">Usa il dettaglio evento per vedere le comunicazioni. (Endpoint aggregato non disponibile)</td>`;
        tbody.appendChild(tr);
        openModal("#modal-all-reports");
    });

    /* ===== Export delegati al backend ===== */
    function appendQuery(url, obj) {
        Object.entries(obj).forEach(([k, v]) => {
            if (v !== null && v !== undefined && v !== "") url.searchParams.set(k, v);
        });
    }
    $("#gen-export").addEventListener("click", () => {
        const url = new URL(API.base + "/segnalazioni/export.csv", location.origin);
        appendQuery(url, {
            page: state.page.gen,
            per_page: 10,
            q: state.global.q || null,
            comune: $("#gen-filter-comune").value || state.global.comune || null,
            date: state.global.date || null,
            time: state.global.time || null,
            dal: $("#gen-filter-dal").value || null,
            al: $("#gen-filter-al").value || null,
        });
        location.href = url.toString();
    });
    $("#ongoing-export").addEventListener("click", () => {
        const url = new URL(API.base + "/eventi/export.csv", location.origin);
        appendQuery(url, {
            page: state.page.ongoing,
            per_page: 10,
            q: state.global.q || null,
            comune: $("#ongoing-filter-comune").value || state.global.comune || null,
            date: state.global.date || null,
            time: state.global.time || null,
            dal: $("#ongoing-filter-dal").value || null,
            al: $("#ongoing-filter-al").value || null,
            status: state.ui.ongoingStatus,
        });
        location.href = url.toString();
    });
    $("#ev-export").addEventListener("click", () => {
        const id = state.ui.currentEventId;
        if (!id) return;
        const url = new URL(API.base + `/eventi/${id}/export.csv`, location.origin);
        location.href = url.toString();
    });
    // Print evento (UI)
    $("#ev-print").addEventListener("click", () => {
        const dlg = document.querySelector("#modal-event .c-modal__dialog");
        if (!dlg) return;
        const css = document.querySelector("style")?.textContent || "";
        const win = window.open("", "_blank", "width=1024,height=768");
        win.document.write(`<html><head><title>Stampa evento</title><style>${css}</style></head><body>${dlg.innerHTML}</body></html>`);
        win.document.close();
        win.focus();
        win.print();
        win.close();
        toast("Pronto per la stampa", "La finestra di stampa è stata aperta.", "info", 1400);
    });

    /* ===== Tag inputs ===== */

    let genAree, editAree, evAreeInput;
    genAree = new TagInput($("#gen-aree"), {
        datalistId: "comuni-datalist"
    });
    editAree = new TagInput($("#edit-aree"), {
        datalistId: "comuni-datalist"
    });
    evAreeInput = new TagInput($("#ev-aree-input"), {
        datalistId: "comuni-datalist"
    });

    $("#gen-aree").addEventListener("change", (e) => {
        $("#gen-aree-hidden").value = JSON.stringify(e.detail || []);
    });
    $("#edit-aree").addEventListener("change", (e) => {
        $("#edit-aree-hidden").value = JSON.stringify(e.detail || []);
    });


    /* ===== Global & tab filters -> backend ===== */
    ["#gen-filter-comune", "#gen-filter-dal", "#gen-filter-al"].forEach((s) =>
        $(s).addEventListener("input", async () => {
            state.page.gen = 1;
            await refreshGEN();
        })
    );
    ["#ongoing-filter-comune", "#ongoing-filter-dal", "#ongoing-filter-al"].forEach((s) =>
        $(s).addEventListener("input", async () => {
            state.page.ongoing = 1;
            await refreshONGOING();
        })
    );
    ["#global-q", "#global-date", "#global-time", "#global-comune"].forEach((sel) => {
        $(sel).addEventListener("input", async () => {
            state.global.q = $("#global-q").value.trim();
            state.global.date = $("#global-date").value;
            state.global.time = $("#global-time").value;
            state.global.comune = $("#global-comune").value.trim();
            state.page = {
                ...state.page,
                gen: 1,
                ongoing: 1
            };
            await Promise.all([refreshGEN(), refreshONGOING()]);
        });
    });

    /* ===== Info modal: righe + open ===== */
    function genInfoRows(rec) {
        const typeLabel = TYPE_LABELS[rec.tipologia] || rec.tipologia || "—";
        const created = new Date(rec.created_at || Date.now());
        const when = fmtDT(created);
        const evText = rec.event_id ? `Evento #${rec.event_id}` : "—";
        return [
            ["ID", String(rec.id)],
            ["Data/Ora", when],
            ["Direzione", (rec.direzione || "E").toUpperCase() === "U" ? "Uscita (U)" : "Entrata (E)"],
            ["Tipologia", typeLabel],
            ["Aree interessate", (rec.aree || []).join(", ") || "—"],
            ["Operatore", rec.operatore || "—"],
            ["Priorità", rec.priorita || "Nessuna"],
            ["Evento associato", evText],
            ["Sintesi", rec.sintesi || "—"],
        ];
    }

    function openGenInfoModal(id) {
        const rec = state.gen.find((x) => String(x.id) === String(id));
        if (!rec) return;
        const body = document.querySelector("#gen-info-body");
        if (!body) return;
        const rows = genInfoRows(rec);
        const tbl = document.createElement("table");
        tbl.className = "w-full text-sm";
        tbl.innerHTML = `<tbody>${rows
      .map(([k, v]) => `<tr class="border-t border-slate-200"><td class="px-3 py-2 font-semibold w-44">${k}</td><td class="px-3 py-2">${v}</td></tr>`)
      .join("")}</tbody>`;
        body.replaceChildren(tbl);
        const pr = rec.priorita || "Nessuna";
        const dir = (rec.direzione || "E").toUpperCase() === "U" ? "U" : "E";
        const prBadge = makePrioBadge(pr);
        const dirBadge = makeDirBadge(dir);
        const tds = body.querySelectorAll("tbody tr td:nth-child(2)");
        if (tds[2]) {
            tds[2].textContent = "";
            tds[2].appendChild(dirBadge.cloneNode(true));
        }
        if (tds[6]) {
            tds[6].textContent = "";
            tds[6].appendChild(prBadge);
        }
        const payload = {
            id: rec.id,
            created_at: rec.created_at,
            direzione: rec.direzione,
            tipologia: rec.tipologia,
            tipologia_label: TYPE_LABELS[rec.tipologia] || rec.tipologia || null,
            aree: rec.aree || [],
            operatore: rec.operatore || null,
            priorita: rec.priorita || "Nessuna",
            event_id: rec.event_id || null,
            sintesi: rec.sintesi || "",
        };
        state.ui.genInfoJson = payload;
        openModal("#modal-gen-info");
    }

    /* ===== Pulsante filtro stato (all/open/closed) ===== */
    const toggleBtn = $("#ongoing-toggle-status");

    function updateToggleBtn() {
        if (!toggleBtn) return;
        toggleBtn.textContent =
            state.ui.ongoingStatus === "all" ? "Tutti" : state.ui.ongoingStatus === "open" ? "Solo aperti" : "Solo chiusi";
        toggleBtn.title = toggleBtn.textContent;
    }
    if (toggleBtn) {
        updateToggleBtn();
        toggleBtn.addEventListener("click", async () => {
            state.ui.ongoingStatus =
                state.ui.ongoingStatus === "all" ? "open" : state.ui.ongoingStatus === "open" ? "closed" : "all";
            state.page.ongoing = 1;
            updateToggleBtn();
            await refreshONGOING();
        });
    }

    /* ===== Anteprima comunicazioni evento nelle modali GEN ===== */
    function ensureEvPreviewBox(afterEl, boxId) {
        let box = document.getElementById(boxId);
        if (!box) {
            box = document.createElement("section");
            box.id = boxId;
            box.className = "ev-preview shadow-card";
            afterEl.parentElement.insertAdjacentElement("afterend", box);
        }
        return box;
    }

    function renderEvPreview(evId, mountEl) {
        const box = ensureEvPreviewBox(mountEl, mountEl.id + "-preview");
        box.replaceChildren();

        const head = document.createElement("div");
        head.className = "ev-preview__head";
        head.innerHTML = `<h5 class="ev-preview__title">Comunicazioni evento</h5>
      <div class="ev-preview__meta text-xs opacity-70"></div>`;
        box.appendChild(head);

        if (!evId || evId === "__new__") {
            box.appendChild(document.createElement("div")).outerHTML =
                `<div class="ev-preview__empty">Nessun evento selezionato.
         Se scegli “Crea nuovo evento”, questa segnalazione diventerà la prima comunicazione.</div>`;
            return;
        }

        const ev = state.ongoing.find((e) => String(e.id) === String(evId));
        if (!ev) {
            box.appendChild(document.createElement("div")).outerHTML =
                `<div class="ev-preview__empty">Evento #${evId} non presente nella pagina corrente.</div>`;
            return;
        }

        head.querySelector(".ev-preview__meta").innerHTML =
            `<strong>${TYPE_LABELS[ev.tipo] || ev.tipo}</strong> — ${(ev.aree || []).join(", ") || "—"}
       <span class="ev-inline-status ${ev.open !== false ? "is-open" : "is-closed"}" style="margin-left:.35rem">${ev.open !== false ? "Aperto" : "Chiuso"}</span>`;

        const wrap = document.createElement("div");
        wrap.className = "ev-preview__empty text-xs opacity-70";
        wrap.textContent = "Le comunicazioni complete sono visibili nel dettaglio evento.";
        box.appendChild(wrap);
    }

    /* ===== RESET FILTRI ===== */
    async function resetGlobalFilters() {
        $("#global-q").value = "";
        $("#global-date").value = "";
        $("#global-time").value = "";
        $("#global-comune").value = "";
        state.global = {
            q: "",
            date: "",
            time: "",
            comune: ""
        };
        state.page.gen = 1;
        state.page.ongoing = 1;
        await Promise.all([refreshGEN(), refreshONGOING()]);
    }
    async function resetGenFilters() {
        $("#gen-filter-comune").value = "";
        $("#gen-filter-dal").value = "";
        $("#gen-filter-al").value = "";
        state.page.gen = 1;
        await refreshGEN();
    }
    async function resetOngoingFilters() {
        $("#ongoing-filter-comune").value = "";
        $("#ongoing-filter-dal").value = "";
        $("#ongoing-filter-al").value = "";
        state.page.ongoing = 1;
        await refreshONGOING();
    }
    document.getElementById("global-reset")?.addEventListener("click", resetGlobalFilters);
    document.getElementById("gen-filters-reset")?.addEventListener("click", resetGenFilters);
    document.getElementById("ongoing-filters-reset")?.addEventListener("click", resetOngoingFilters);
</script>