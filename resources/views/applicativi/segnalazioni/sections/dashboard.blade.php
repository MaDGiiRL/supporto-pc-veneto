<!-- resources/views/dashboard.blade.php -->

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- (Opzionale) Lucide per altre icone già presenti altrove -->
<script src="https://unpkg.com/lucide@latest"></script>

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
    const fmtDT = (d) => new Intl.DateTimeFormat("it-IT", {
        dateStyle: "short",
        timeStyle: "short"
    }).format(d);
    const PREVIEW_MAX = 160;
    const truncate = (str = "", n = PREVIEW_MAX) => (str.length > n ? str.slice(0, n).trimEnd() + "…" : str);
    const escCsv = (v) => `"${(v??"").toString().replace(/\r?\n/g," ").replace(/"/g,'""')}"`;
    const nowIT = () => {
        const d = new Date();
        const pad = (n) => String(n).padStart(2, "0");
        return {
            date: `${pad(d.getDate())}/${pad(d.getMonth()+1)}/${d.getFullYear()}`,
            time: `${pad(d.getHours())}:${pad(d.getMinutes())}`,
        };
    };
    const toITParts = (d) => {
        const pad = (n) => String(n).padStart(2, "0");
        return {
            date: `${pad(d.getDate())}/${pad(d.getMonth()+1)}/${d.getFullYear()}`,
            time: `${pad(d.getHours())}:${pad(d.getMinutes())}`,
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
    const confirmDelete = (title = "Eliminare la segnalazione?", text = "Questa azione non può essere annullata.") => Swal.fire({
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
            this.root.innerHTML = `<div class="tags" role="list"></div><div class="tag-input__control"><input class="tag-input__field" ${this.datalistId?`list="${this.datalistId}"`:""} placeholder="${this.placeholder}"/></div>`;
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
    /* ===== Comuni & Province seed ===== */
    const COMUNI = ["Adria", "Affi", "Albignasego", "Bologna", "Bussolengo", "Farra di Soligo", "Milano", "Napoli", "Roma", "Rovigo", "Torino", "Verona", "Vicenza", "Venezia", ];
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
    const TYPES = ["sismico", "vulcanico", "idraulico", "idrogeologico", "maremoto", "deficit-idrico", "meteo-avverso", "aib", "uomo", "altro", ];
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
        }, {
            id: "intensita",
            label: "Intensità MCS/EMS"
        }, {
            id: "coordinate",
            label: "Coordinate epicentro"
        }, {
            id: "danni",
            label: "Danni segnalati (testo)",
            type: "textarea"
        }, ],
        vulcanico: [{
            id: "tremore",
            label: "Tremore vulcanico (trend)"
        }, {
            id: "cenere",
            label: "Ricaduta ceneri (aree)"
        }, {
            id: "dpi",
            label: "DPI distribuiti (qtà)"
        }, ],
        idraulico: [{
            id: "livello",
            label: "Livello idrometrico (m)"
        }, {
            id: "argine",
            label: "Criticità arginale (sì/no)"
        }, {
            id: "sottopassi",
            label: "Sottopassi allagati (#)"
        }, ],
        idrogeologico: [{
            id: "tipologia_frana",
            label: "Tipologia frana"
        }, {
            id: "volume",
            label: "Volume stimato (mc)"
        }, {
            id: "viabilita",
            label: "Interferenza viabilità (testo)",
            type: "textarea"
        }, ],
        maremoto: [{
            id: "allerta",
            label: "Livello allerta"
        }, {
            id: "aree_costiere",
            label: "Aree costiere interessate"
        }, ],
        "deficit-idrico": [{
            id: "pressione",
            label: "Riduzione pressione (%)"
        }, {
            id: "autobotti",
            label: "Autobotti in servizio (#)"
        }, ],
        "meteo-avverso": [{
            id: "fenomeno",
            label: "Fenomeno prevalente (vento, grandine…)"
        }, {
            id: "intensita",
            label: "Intensità"
        }, {
            id: "danni_diffusi",
            label: "Danni diffusi? (sì/no)"
        }, ],
        aib: [{
            id: "superficie",
            label: "Superficie percorsa dal fuoco (ha)"
        }, {
            id: "combustibile",
            label: "Tipo combustibile (bosco, sterpaglie…)"
        }, {
            id: "coordinate",
            label: "Coordinate/Località puntuale"
        }, {
            id: "mezzi",
            label: "Mezzi impiegati (AIB/VVF/CAI…)"
        }, {
            id: "meteo",
            label: "Condizioni meteo (vento, umidità…)"
        }, ],
        uomo: [{
            id: "tipologia",
            label: "Tipologia incidente (sversamento, industriale…)"
        }, {
            id: "ente_coinvolto",
            label: "Ente/Azienda coinvolta"
        }, {
            id: "impatti",
            label: "Impatti su servizi/ambiente",
            type: "textarea"
        }, ],
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
            wrap.innerHTML = `<span class="label">${f.label}</span>` + (f.type === "textarea" ? `<textarea class="input" id="${prefix}-${f.id}"></textarea>` : `<input class="input" id="${prefix}-${f.id}"/>`);
            grid.appendChild(wrap);
        });
        container.appendChild(grid);
    }

    /* ===== Demo data ===== */
    function demoReportPack(aree) {
        const {
            date,
            time
        } = nowIT();
        return [{
            data: date,
            ora: time,
            tipo: "Telefono",
            verso: "Entrata",
            mitt: "Cittadino",
            tel: "",
            mail: "",
            indirizzo: "",
            provincia: "VR",
            comune: "Verona",
            aree,
            oggetto: "Segnalazione iniziale",
            priorita: "Media",
            contenuto: "Oscillazione lampadari, senza danni",
        }, ];
    }

    function demoOngoing() {
        const now = Date.now();
        const city = (i) => COMUNI[(i * 3) % COMUNI.length];
        const typeSeq = ["sismico", "idraulico", "aib", "meteo-avverso", "uomo"];
        const descByType = (t) => ({
            sismico: "Scossa avvertita in area urbana, verifiche in corso",
            idraulico: "Allagamenti diffusi in area golenale",
            aib: "Incendio di interfaccia in zona boscata",
            "meteo-avverso": "Vento forte e grandinate sparse",
            uomo: "Interruzione servizi per incidente industriale",
        } [t] || "Evento");
        return typeSeq.map((t, i) => {
            const c = city(i);
            const fraz = i % 2 === 0 ? `${c} - Centro` : `${c} - Frazione Nord`;
            return {
                id: 300 + i + 1,
                tipo: t,
                descrizione: descByType(t),
                aggiornamento: new Date(now - i * 3600e3).toISOString(),
                operatore: "Operatore",
                aree: [c, fraz],
                reports: demoReportPack([c, fraz]),
            };
        });
    }

    /* ===== Store + Persistenza ===== */
    const CONFIG = {
        PERSIST: true,
        KEY: "sor-dash-v18-ux-pill-openfilter"
    };
    const state = {
        gen: [],
        ongoing: demoOngoing(),
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
    (function seedGen() {
        const pr = ["Alta", "Media", "Bassa", "Nessuna"];
        for (let i = 0; i < 12; i++) {
            const dt = new Date(Date.now() - i * 3600 * 1000);
            state.gen.push({
                id: 1000 + i,
                created_at: dt.toISOString(),
                direzione: i % 5 === 0 ? "U" : "E",
                tipologia: TYPES[i % TYPES.length],
                aree: [COMUNI[i % COMUNI.length], `${COMUNI[i%COMUNI.length]} - Centro`],
                sintesi: "Segnalazione di esempio",
                operatore: "operatore",
                event_id: "",
                priorita: pr[i % pr.length],
            });
        }
    })();

    /* === Bridge cross-pagina: BroadcastChannel + storage === */
    const SOR_BC = (typeof BroadcastChannel !== 'undefined') ? new BroadcastChannel('sor') : null;

    function sorBroadcast() {
        try {
            SOR_BC?.postMessage({
                type: 'state',
                key: CONFIG.KEY,
                ts: Date.now()
            });
        } catch {}
    }

    /* Sostituisci la funzione save() con questa */
    const save = () => {
        if (CONFIG.PERSIST) localStorage.setItem(CONFIG.KEY, JSON.stringify(state));
        // notifica stessa pagina (se usi SOR.subscribe in dashboard)
        try {
            typeof __sorNotify === 'function' && __sorNotify();
        } catch {}
        // notifica altre pagine
        sorBroadcast();
    };

    /* Alla fine di load(), invia uno snapshot iniziale */
    (function afterLoadPing() {
        try {
            sorBroadcast();
        } catch {}
    })();

    const load = () => {
        if (!CONFIG.PERSIST) return;
        try {
            const raw = localStorage.getItem(CONFIG.KEY);
            if (raw) {
                const d = JSON.parse(raw);
                if (d?.gen && d?.ongoing) Object.assign(state, d);
            }
        } catch {}
    };
    load();


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

    /* ===== Render: GENERICHE ===== */
    function renderGEN() {
        const root = $("#gen-body");
        root.replaceChildren();
        const filters = {
            comune: $("#gen-filter-comune").value.trim(),
            dal: $("#gen-filter-dal").value,
            al: $("#gen-filter-al").value,
        };
        const filtered = applyFilters(state.gen, filters, (r) => `${r.tipologia||""} ${(r.aree||[]).join(" ")} ${r.sintesi||""} ${r.operatore||""}`, (r) => r.created_at).sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        const {
            slice,
            page,
            total
        } = paginate(filtered, state.page.gen);
        state.page.gen = page;
        $("#gen-page").textContent = `Pagina ${page} di ${total}`;
        slice.forEach((r) => {
            const tr = document.createElement("tr");
            tr.className = "border-t border-slate-200";
            tr.dataset.id = r.id;
            tr.classList.add("prio-row", prioClass(r.priorita));
            const tdDt = Object.assign(document.createElement("td"), {
                className: "px-3 py-2",
                textContent: fmtDT(new Date(r.created_at)),
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
                className: "px-3 py-2 w-sintesi",
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
                const ev = state.ongoing.find((x) => String(x.id) === String(r.event_id));
                const btn = document.createElement("button");
                btn.type = "button";
                btn.className = "link ev-link";
                btn.dataset.openEvent = String(r.event_id);
                btn.textContent = ev ? `[${TYPE_LABELS[ev.tipo]||ev.tipo}] ${(ev.aree||[]).join(", ")}` : `Evento #${r.event_id}`;
                tdEv.appendChild(btn);
            } else {
                tdEv.textContent = "—";
            }
            const tdAc = document.createElement("td");
            tdAc.className = "px-3 py-2";
            tdAc.innerHTML = `<div class="actions"><button class="btn-xs btn-ghost" title="Dettagli" data-action="info" data-type="gen" data-id="${r.id}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="hi" width="18" height="18" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041.02a.75.75 0 01.409.67v3.86m-.75-7.1h.008v.008H11.25V8.7z"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></button><button class="btn-xs btn-ghost" title="Modifica" data-action="edit" data-type="gen" data-id="${r.id}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="hi" width="18" height="18" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.125 2.125 0 113.005 3.004L7.5 19.86l-4 1 1-4L16.862 4.487z"/></svg></button><button class="btn-xs btn-danger" title="Elimina" data-action="del" data-type="gen" data-id="${r.id}"><svg xmlns="http://www.w3.org/2000/svg" class="hi" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2m2 0l-1 13a2 2 0 01-2 2H9a2 2 0 01-2-2L6 7"/></svg></button></div>`;
            tr.append(tdDt, tdDir, tdTp, tdAr, tdSy, tdOp, tdEv, tdAc);
            root.appendChild(tr);
        });
        $("#gen-prev").disabled = page <= 1;
        $("#gen-next").disabled = page >= total;
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
        const filters = {
            comune: $("#ongoing-filter-comune").value.trim(),
            dal: $("#ongoing-filter-dal").value,
            al: $("#ongoing-filter-al").value,
        };
        let filtered = applyFilters(state.ongoing, filters, (r) => `${(r.aree||[]).join(" ")} ${r.descrizione||""} ${r.operatore||""}`, (r) => r.aggiornamento).sort((a, b) => new Date(b.aggiornamento) - new Date(a.aggiornamento)); // Filtro stato (all/open/closed)
        if (state.ui.ongoingStatus === "open") {
            filtered = filtered.filter(e => e.open !== false);
        } else if (state.ui.ongoingStatus === "closed") {
            filtered = filtered.filter(e => e.open === false);
        }
        const {
            slice,
            page,
            total
        } = paginate(filtered, state.page.ongoing);
        state.page.ongoing = page;
        $("#ongoing-page").textContent = `Pagina ${page} di ${total}`;
        if (!slice.length) {
            const empty = document.createElement("div");
            empty.className = "text-sm opacity-70 px-3 py-2";
            empty.textContent = "Nessun evento in atto.";
            root.appendChild(empty);
        }
        slice.forEach((ev) => {
            const typeKey = TYPES.includes(ev.tipo) ? ev.tipo : "altro";
            const typeLabel = TYPE_LABELS[typeKey];
            const isOpen = ev.open !== false;
            const quando = fmtDT(new Date(ev.aggiornamento));
            const aree = (ev.aree || []).join(", ");
            const card = document.createElement("article");
            card.className = "ev-card";
            card.dataset.type = typeKey;
            card.tabIndex = 0;
            card.setAttribute("role", "button");
            card.addEventListener("click", () => openEventModal(ev.id));
            card.innerHTML = `<div class="ev-card__head"><h4 class="ev-card__title">${ev.descrizione||"Evento"}</h4><div class="ev-card__chips"><span class="ev-card__status ${isOpen?"is-open":"is-closed"}">${isOpen?"Aperto":"Chiuso"}</span><span class="ev-card__badge">${typeLabel}</span></div></div><ul class="ev-card__meta"><li><strong>Ultimo agg.:</strong> ${quando}</li><li><strong>Aree:</strong> ${aree||"—"}</li></ul>`;
            root.appendChild(card);
        });
        $("#ongoing-prev").disabled = page <= 1;
        $("#ongoing-next").disabled = page >= total;
    }

    function updateEventStatusUI(ev) {
        // pill nello subtitle
        const st = document.querySelector("#ev-subtitle .ev-inline-status");
        if (st) {
            st.classList.toggle("is-open", ev.open !== false);
            st.classList.toggle("is-closed", ev.open === false);
            st.textContent = ev.open !== false ? "Aperto" : "Chiuso";
        }
        // bottone toggle
        const btn = $("#ev-toggle-open");
        if (btn) {
            btn.textContent = ev.open !== false ? "Chiudi evento" : "Riapri evento";
            btn.title = btn.textContent;
        }
    }


    /* ===== Evento: open modal + popolamento ===== */
    function openEventModal(eventId) {
        state.ui.currentEventId = eventId;
        const ev = state.ongoing.find((x) => x.id === eventId);
        if (!ev) return;
        $("#ev-title").textContent = ev.descrizione || "—";
        const subtitle = $("#ev-subtitle");
        subtitle.textContent = `${TYPE_LABELS[ev.tipo]||ev.tipo} • Ultimo agg.: ${fmtDT(new Date(ev.aggiornamento))} `;
        const st = document.createElement("span");
        st.className = `ev-inline-status ${ev.open!==false?"is-open":"is-closed"}`;
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

            // Data
            const tdData = document.createElement("td");
            tdData.className = "px-3 py-2";
            tdData.textContent = r.data || "";
            tr.appendChild(tdData);

            // Ora
            const tdOra = document.createElement("td");
            tdOra.className = "px-3 py-2";
            tdOra.textContent = r.ora || "";
            tr.appendChild(tdOra);

            // Tipo
            const tdTipo = document.createElement("td");
            tdTipo.className = "px-3 py-2";
            tdTipo.textContent = r.tipo || "";
            tr.appendChild(tdTipo);

            // Verso -> badge E/U
            const tdVerso = document.createElement("td");
            tdVerso.className = "px-3 py-2 text-center";
            tdVerso.dataset.verso = "1";
            const raw = (r.verso || "").trim().toUpperCase();
            const dir = raw.startsWith("U") ? "U" : "E";
            tdVerso.appendChild(makeDirBadge(dir));
            tr.appendChild(tdVerso);

            // Mitt./Tel/Mail/Aree/Oggetto
            const cells = [r.mitt, r.tel, r.mail, (r.aree || []).join(", "), r.oggetto];
            cells.forEach((v) => {
                const td = document.createElement("td");
                td.className = "px-3 py-2";
                td.textContent = v || "";
                tr.appendChild(td);
            });

            // Priorità (badge)
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
        hint.textContent = `Tipologia evento: ${TYPE_LABELS[type]||type||"—"}. Aggiungi eventuali dettagli nella comunicazione.`;
        container.appendChild(hint);
    }

    function loadReportIntoForm(idx) {
        const ev = state.ongoing.find((x) => x.id === state.ui.currentEventId);
        if (!ev) return;
        const r = ev.reports?.[idx];
        if (!r) return;
        $("#ev-edit-index").value = idx;
        $("#f-data").value = r.data || "";
        $("#f-ora").value = r.ora || "";
        $("#f-tipo").value = r.tipo || "";
        const verso = r.verso || "Entrata";
        const radio = document.querySelector(`input[name="f-verso"][value="${verso}"]`);
        if (radio) radio.checked = true;
        $("#f-mitt").value = r.mitt || "";
        $("#f-tel").value = r.tel || "";
        $("#f-mail").value = r.mail || "";
        $("#f-indirizzo").value = r.indirizzo || "";
        $("#f-oggetto").value = r.oggetto || "";
        $("#f-contenuto").value = r.contenuto || "";
        const p = r.priorita || "Nessuna";
        const pr = document.querySelector(`input[name="f-priorita"][value="${p}"]`);
        if (pr) pr.checked = true;
        evAreeInput.setValues(r.aree || []);
        populateProvinceSelect(r.provincia || "");
        populateComuniSelect(r.provincia || "", r.comune || "");
    }

    /* ===== Province/Comuni selects ===== */
    function populateProvinceSelect(selected = "") {
        const sel = $("#f-provincia");
        sel.innerHTML = "";
        const first = new Option("Tutte le province...", "");
        sel.add(first);
        Object.keys(PROVINCE).sort().forEach((k) => sel.add(new Option(`${k}`, k)));
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
        }(PROVINCE[prov] || []).forEach((c) => comuneSel.add(new Option(c, c)));
        comuneSel.disabled = false;
        comuneSel.value = selected || "";
    }
    $("#f-provincia").addEventListener("change", (e) => populateComuniSelect(e.target.value));


    /* ===== RESET HANDLERS ===== */

    // a) CREAZIONE GENERICA
    document.getElementById("form-gen").addEventListener("reset", (e) => {
        // pulisci TagInput
        genAree.setValues([]);
        // azzera tipologia e campi specifici
        const tipSel = document.getElementById("gen-tipologia");
        if (tipSel) tipSel.value = "";
        const sp = document.getElementById("gen-specific");
        if (sp) sp.innerHTML = "";
        // azzera associazione evento + anteprima
        const sel = document.getElementById("gen-event-select");
        if (sel) {
            sel.value = "";
            renderEvPreview("", sel);
        }
        // sync hidden
        const hid = document.getElementById("gen-aree-hidden");
        if (hid) hid.value = "[]";
    });

    // b) EDIT GENERICA
    // quando apri la modale EDIT memorizza le aree iniziali (aggiungi questa riga dove già fai fillForm)
    ///  ➜ cerca il blocco "if (action === 'edit') { ... }" e subito dopo editAree.setValues(...)
    ///     aggiungi:
    ///     $("#form-edit-gen").dataset.initialAree = JSON.stringify(item.aree || []);

    document.getElementById("form-edit-gen").addEventListener("reset", (e) => {
        const form = e.currentTarget;
        // ripristina TagInput alle aree originali caricate all'apertura
        try {
            const initial = JSON.parse(form.dataset.initialAree || "[]");
            editAree.setValues(initial);
            const hid = document.getElementById("edit-aree-hidden");
            if (hid) hid.value = JSON.stringify(initial);
        } catch {
            editAree.setValues([]);
        }
        // rinfresca anteprima evento collegato
        const sel = document.getElementById("edit-gen-event");
        if (sel) renderEvPreview(sel.value, sel);
    });

    // c) FORM COMUNICAZIONE EVENTO
    document.getElementById("ev-form").addEventListener("reset", () => {
        // ripristina il form secondo la tipologia e le aree dell'evento corrente
        const ev = state.ongoing.find(x => x.id === state.ui.currentEventId);
        if (ev) {
            resetEvForm(ev.tipo, ev.aree);
        } else {
            // fallback: svuota
            evAreeInput.setValues([]);
        }
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
            const arr = state.gen;
            if (action === "edit") {
                const item = arr.find((x) => String(x.id) === String(id));
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
                confirmDelete().then((res) => {
                    if (!res.isConfirmed) return;
                    const idx = arr.findIndex((x) => String(x.id) === String(id));
                    if (idx > -1) {
                        arr.splice(idx, 1);
                        save();
                        renderGEN();
                        toast("Eliminata!", "La segnalazione è stata rimossa.", "success");
                    }
                });
            }
        }

        if (e.target.id === "gen-info-copy" || e.target.closest("#gen-info-copy")) {
            const data = state.ui.genInfoJson ?? {};
            const text = JSON.stringify(data, null, 2);
            if (navigator.clipboard?.writeText) {
                navigator.clipboard.writeText(text).then(() => toast("Copiato negli appunti", "JSON della segnalazione copiato.")).catch(() => fallbackCopy(text));
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
        const ev = state.ongoing.find((x) => x.id === state.ui.currentEventId);
        if (!ev) return;
        resetEvForm(ev.tipo, ev.aree);
        $("#ev-save").textContent = "💾 Salva Comunicazione";
        openModal("#modal-ev-form");
    });

    /* ===== Paginazione ===== */
    $("#gen-prev").addEventListener("click", () => {
        state.page.gen = Math.max(1, state.page.gen - 1);
        renderGEN();
    });
    $("#gen-next").addEventListener("click", () => {
        state.page.gen += 1;
        renderGEN();
    });
    $("#ongoing-prev").addEventListener("click", () => {
        state.page.ongoing = Math.max(1, state.page.ongoing - 1);
        renderONGOING();
    });
    $("#ongoing-next").addEventListener("click", () => {
        state.page.ongoing += 1;
        renderONGOING();
    });

    $("#ev-toggle-open")?.addEventListener("click", () => {
        const ev = state.ongoing.find(x => x.id === state.ui.currentEventId);
        if (!ev) return;
        ev.open = ev.open === false ? true : false; // toggle
        ev.aggiornamento = new Date().toISOString();
        save();
        updateEventStatusUI(ev);
        renderONGOING();
        toast(ev.open !== false ? "Evento riaperto" : "Evento chiuso", "", "info", 1400);
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
    /* ===== Submit GENERICO (CREA) ===== */
    $("#form-gen").addEventListener("submit", (e) => {
        e.preventDefault();
        const fd = Object.fromEntries(new FormData(e.currentTarget).entries());
        const aree = genAree.values.slice();
        const tipologia = $("#gen-tipologia").value || "altro";
        const priorita = (fd.priorita || "Nessuna").trim();
        const chosenEvent = $("#gen-event-select").value;
        const rec = {
            id: Date.now(),
            created_at: new Date().toISOString(),
            direzione: "E",
            tipologia,
            aree,
            sintesi: fd.note || "",
            operatore: "operatore",
            event_id: "",
            priorita,
        };
        if (chosenEvent) {
            let evId;
            if (chosenEvent === "__new__") {
                evId = Date.now();
                state.ongoing.unshift({
                    id: evId,
                    tipo: tipologia,
                    descrizione: rec.sintesi || `Evento ${TYPE_LABELS[tipologia]||tipologia}`,
                    aggiornamento: new Date().toISOString(),
                    operatore: rec.operatore,
                    aree: aree.slice(),
                    open: true,
                    reports: [makeInitialReportFromGen(rec)],
                });
                toast("Nuovo evento creato", "L’evento è stato aggiunto in 'Eventi in atto'.");
            } else {
                evId = chosenEvent;
                const exists = state.ongoing.some((ev) => String(ev.id) === String(evId));
                if (!exists) {
                    const newEvId = Number(evId) || Date.now();
                    evId = newEvId;
                    state.ongoing.unshift({
                        id: newEvId,
                        tipo: tipologia,
                        descrizione: rec.sintesi || `Evento ${TYPE_LABELS[tipologia]||tipologia}`,
                        aggiornamento: new Date().toISOString(),
                        operatore: rec.operatore,
                        aree: aree.slice(),
                        open: true,
                        reports: [makeInitialReportFromGen(rec)],
                    });
                    toast("Nuovo evento creato", "L’evento (ID personalizzato) è stato aggiunto in 'Eventi in atto'.");
                } else {
                    // ⬅️ QUI la novità: quando associ a un evento ESISTENTE, aggiungi la comunicazione iniziale
                    attachGenToEvent(evId, rec);
                }
            }
            rec.event_id = String(evId);
        }
        state.gen.unshift(rec);
        save();
        e.currentTarget.reset();
        genAree.setValues([]);
        $("#gen-specific").innerHTML = "";
        closeModal(e.currentTarget.closest(".c-modal"));
        state.page.gen = 1;
        renderGEN();
        renderONGOING();
        toast("Segnalazione aggiunta!", "La segnalazione generica è stata salvata.");
    });
    $("#gen-tipologia").addEventListener("change", () => {
        const t = $("#gen-tipologia").value || "altro";
        renderSpecific($("#gen-specific"), t, "gensp");
    });

    /* ===== Submit GENERICO (EDIT) ===== */
    $("#form-edit-gen").addEventListener("submit", (e) => {
        e.preventDefault();
        const fd = Object.fromEntries(new FormData(e.currentTarget).entries());
        const idx = state.gen.findIndex((r) => String(r.id) === String(fd.id));
        if (idx > -1) {
            const eventChoiceOriginal = (fd.event_id || "").trim();
            let finalEventId = "";
            const recBefore = state.gen[idx];
            state.gen[idx] = {
                ...recBefore,
                created_at: fd.created_at ? new Date(fd.created_at).toISOString() : recBefore.created_at,
                direzione: fd.direzione || recBefore.direzione,
                aree: editAree.values.slice(),
                sintesi: fd.sintesi ?? recBefore.sintesi,
                operatore: fd.operatore ?? recBefore.operatore,
                priorita: (fd.priorita || recBefore.priorita || "Nessuna").trim(),
            };
            let eventChoice = eventChoiceOriginal;
            if (eventChoice === "__new__") {
                finalEventId = String(Date.now());
                const baseRec = state.gen[idx];
                state.ongoing.unshift({
                    id: Number(finalEventId),
                    tipo: baseRec.tipologia || "altro",
                    descrizione: baseRec.sintesi || "Evento",
                    aggiornamento: new Date().toISOString(),
                    operatore: baseRec.operatore || "operatore",
                    aree: baseRec.aree.slice(),
                    open: true,
                    reports: [makeInitialReportFromGen(baseRec)],
                });
            } else if (eventChoice) {
                const exists = state.ongoing.some((ev) => String(ev.id) === String(eventChoice));
                if (!exists) {
                    const newEvId = Number(eventChoice) || Date.now();
                    eventChoice = String(newEvId);
                    const baseRec = state.gen[idx];
                    state.ongoing.unshift({
                        id: newEvId,
                        tipo: baseRec.tipologia || "altro",
                        descrizione: baseRec.sintesi || "Evento",
                        aggiornamento: new Date().toISOString(),
                        operatore: baseRec.operatore || "operatore",
                        aree: baseRec.aree.slice(),
                        open: true,
                        reports: [makeInitialReportFromGen(baseRec)],
                    });
                } else {
                    // ⬅️ NOVITÀ: collego la generica all’evento esistente aggiungendo la comunicazione iniziale
                    attachGenToEvent(eventChoice, state.gen[idx]);
                }
                finalEventId = eventChoice;
            } else {
                finalEventId = "";
            }
            state.gen[idx].event_id = finalEventId;
            save();
            renderGEN();
            renderONGOING();
            closeModal($("#modal-edit-gen"));
            toast("Modifica salvata!", "La segnalazione è stata aggiornata.");
        }
    });

    /* ===== Submit EV-FORM ===== */
    $("#ev-form").addEventListener("submit", (e) => {
        e.preventDefault();
        const ev = state.ongoing.find((x) => x.id === state.ui.currentEventId);
        if (!ev) return;
        const report = {
            data: $("#f-data").value.trim(),
            ora: $("#f-ora").value.trim(),
            tipo: $("#f-tipo").value || "—",
            verso: document.querySelector('input[name="f-verso"]:checked')?.value || "Entrata",
            mitt: $("#f-mitt").value.trim(),
            tel: $("#f-tel").value.trim(),
            mail: $("#f-mail").value.trim(),
            indirizzo: $("#f-indirizzo").value.trim(),
            provincia: $("#f-provincia").value,
            comune: $("#f-comune").value,
            aree: evAreeInput.values.slice(),
            oggetto: $("#f-oggetto").value.trim(),
            contenuto: $("#f-contenuto").value.trim(),
            priorita: document.querySelector('input[name="f-priorita"]:checked')?.value || "Nessuna",
        };
        const editIdx = $("#ev-edit-index").value;
        if (editIdx !== "" && !Number.isNaN(+editIdx)) ev.reports[+editIdx] = report;
        else {
            ev.reports = ev.reports || [];
            ev.reports.unshift(report);
        }
        ev.aggiornamento = new Date().toISOString();
        ev.open = true;
        updateEventStatusUI(ev);
        save();
        renderEventReports(ev);
        resetEvForm(ev.tipo, ev.aree);
        renderONGOING();
        closeModal($("#modal-ev-form"));
        toast("Segnalazione evento salvata!", "La comunicazione è stata registrata.");
    });

    /* ===== Modifica aree evento ===== */
    $("#ev-areas-edit").addEventListener("click", () => {
        const ev = state.ongoing.find((x) => x.id === state.ui.currentEventId);
        if (!ev) return;
        Swal.fire({
            title: "Modifica Aree interessate",
            html: `<div class="tag-input" id="swal-areas" data-datalist="comuni-datalist"></div>`,
            didOpen: () => {
                const root = Swal.getHtmlContainer().querySelector("#swal-areas");
                const ti = new TagInput(root, {
                    datalistId: "comuni-datalist"
                });
                ti.setValues(ev.aree || []);
                root.addEventListener("change", (e) => {
                    root.dataset.values = JSON.stringify(e.detail || []);
                });
            },
            showCancelButton: true,
            confirmButtonText: "Salva",
            cancelButtonText: "Annulla",
        }).then((res) => {
            if (!res.isConfirmed) return;
            const root = Swal.getHtmlContainer()?.querySelector("#swal-areas");
            const vals = root?.dataset?.values ? JSON.parse(root.dataset.values) : ev.aree;
            ev.aree = vals || [];
            save();
            renderEventAreas(ev);
            renderONGOING();
            toast("Aree aggiornate", "Le aree interessate dell’evento sono state aggiornate.");
        });
    });

    document.getElementById("ongoing-all-reports").addEventListener("click", () => {
        const tbody = $("#all-reports-tbody");
        tbody.replaceChildren();

        const dialog = document.querySelector("#modal-all-reports .c-modal__dialog");

        // --- Box “ultimi 5 eventi aperti” (chips)
        let openBox = dialog.querySelector("#all-reports-open-events");
        if (!openBox) {
            openBox = document.createElement("section");
            openBox.id = "all-reports-open-events";
            openBox.className = "mb-3 p-3 rounded-xl bg-slate-50 border border-slate-200";
            dialog.insertBefore(openBox, dialog.querySelector(".overflow-x-auto"));
        }

        const openEvents = state.ongoing
            .filter(e => e.open !== false)
            .sort((a, b) => new Date(b.aggiornamento) - new Date(a.aggiornamento))
            .slice(0, 5);

        openBox.innerHTML = openEvents.length ?
            "<h4 class='text-sm font-semibold mb-2'>Ultimi 5 eventi aperti</h4>" +
            "<div class='grid md:grid-cols-2 xl:grid-cols-3 gap-2'>" +
            openEvents.map(e => `
            <button type="button" data-open-event="${e.id}" class="ev-chip" data-type="${e.tipo}">
                <span class="ev-chip__title">${e.descrizione || "Evento"}</span>
                <span class="ev-chip__meta">${(e.aree || []).join(", ") || "—"}</span>
                <span class="ev-chip__status ${e.open !== false ? "is-open" : "is-closed"}">
                    ${e.open !== false ? "Aperto" : "Chiuso"}
                </span>
            </button>`).join("") +
            "</div>" :
            "<p class='text-xs opacity-70'>Nessun evento attualmente aperto.</p>";

        // --- TUTTE LE COMUNICAZIONI (entrata e uscita di tutti gli eventi)
        const rows = [];
        state.ongoing.forEach(ev => {
            (ev.reports || []).forEach(r => {
                const ts = parseIT(r.data, r.ora).getTime();
                rows.push({
                    evId: ev.id,
                    eventoType: ev.tipo,
                    eventoOpen: ev.open !== false,
                    eventoText: ev.descrizione || `[${TYPE_LABELS[ev.tipo] || ev.tipo}]`,
                    eventoAreas: (ev.aree || []).join(", "),
                    when: Number.isFinite(ts) ? ts : 0,
                    data: r.data || "",
                    ora: r.ora || "",
                    tipo: r.tipo || "",
                    verso: r.verso || "",
                    mitt: r.mitt || "",
                    tel: r.tel || "",
                    mail: r.mail || "",
                    oggetto: r.oggetto || "",
                    priorita: r.priorita || "Nessuna",
                });
            });
        });
        rows.sort((a, b) => b.when - a.when);

        if (!rows.length) {
            const tr = document.createElement("tr");
            tr.innerHTML = `<td colspan="10" class="px-3 py-3 opacity-70">Nessuna comunicazione disponibile.</td>`;
            tbody.appendChild(tr);
        } else {
            rows.forEach(r => {
                const tr = document.createElement("tr");
                tr.className = "border-t border-slate-200 prio-row " + prioClass(r.priorita);

                const td = txt => {
                    const el = document.createElement("td");
                    el.className = "px-3 py-2";
                    el.textContent = txt || "";
                    return el;
                };

                // Data / Ora
                tr.appendChild(td(r.data));
                tr.appendChild(td(r.ora));

                // Evento (solo link)
                const tdEvt = document.createElement("td");
                tdEvt.className = "px-3 py-2";
                tdEvt.innerHTML = `
                <button type="button" class="link ev-link" data-open-event="${r.evId}">
                    ${r.eventoText} — ${r.eventoAreas || "—"}
                </button>`;
                tr.appendChild(tdEvt);

                // Tipo
                tr.appendChild(td(r.tipo));

                // === Verso con badge E / U (come Segnalazioni generiche) ===
                const tdVerso = document.createElement("td");
                tdVerso.className = "px-3 py-2 text-center";

                const raw = (r.verso || "").trim().toUpperCase();
                const dir = raw.startsWith("U") ? "U" : "E"; // default Entrata

                tdVerso.appendChild(makeDirBadge(dir)); // usa lo stesso helper della tabella principale
                tr.appendChild(tdVerso);

                // Mittente / Tel / Mail / Oggetto
                ["mitt", "tel", "mail", "oggetto"].forEach(k => tr.appendChild(td(r[k])));

                // Priorità (badge)
                const tdPr = document.createElement("td");
                tdPr.className = "px-3 py-2";
                tdPr.appendChild(makePrioBadge(r.priorita));
                tr.appendChild(tdPr);

                tbody.appendChild(tr);
            });
        }

        openModal("#modal-all-reports");
    });



    /* ===== Export CSV ===== */
    function toCSV(rows, headers, pickers) {
        const head = headers.map(escCsv).join(";");
        const body = rows.map((r) => pickers.map((fn) => escCsv(fn(r))).join(";")).join("\n");
        return head + "\n" + body;
    }

    function downloadCSV(filename, csv) {
        const blob = new Blob([csv], {
            type: "text/csv;charset=utf-8;"
        });
        const url = URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = filename.endsWith(".csv") ? filename : `${filename}.csv`;
        document.body.appendChild(a);
        a.click();
        a.remove();
        URL.revokeObjectURL(url);
    }

    function exportGEN() {
        const filters = {
            comune: $("#gen-filter-comune").value.trim(),
            dal: $("#gen-filter-dal").value,
            al: $("#gen-filter-al").value,
        };
        const filtered = applyFilters(state.gen, filters, (r) => `${r.tipologia||""} ${(r.aree||[]).join(" ")} ${r.sintesi||""}`, (r) => r.created_at).sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        const {
            slice,
            page
        } = paginate(filtered, state.page.gen);
        const headers = ["Data/Ora", "Direzione", "Tipologia", "Aree", "Sintesi", "Operatore", "Priorità", "Evento", ];
        const pickers = [(r) => fmtDT(new Date(r.created_at)), (r) => r.direzione || "", (r) => TYPE_LABELS[r.tipologia] || r.tipologia || "", (r) => (r.aree || []).join(", "), (r) => r.sintesi || "", (r) => r.operatore || "", (r) => r.priorita || "Nessuna", (r) => (r.event_id ? r.event_id : ""), ];
        downloadCSV(`segnalazioni_generiche_p${page}`, toCSV(slice, headers, pickers));
        toast("Esportazione completata", "File CSV generato.");
    }

    function exportONGOING() {
        const filters = {
            comune: $("#ongoing-filter-comune").value.trim(),
            dal: $("#ongoing-filter-dal").value,
            al: $("#ongoing-filter-al").value,
        };
        let filtered = applyFilters(state.ongoing, filters, (r) => `${(r.aree||[]).join(" ")} ${r.descrizione||""}`, (r) => r.aggiornamento).sort((a, b) => new Date(b.aggiornamento) - new Date(a.aggiornamento));
        if (state.ui.ongoingStatus === "open") {
            filtered = filtered.filter(e => e.open !== false);
        } else if (state.ui.ongoingStatus === "closed") {
            filtered = filtered.filter(e => e.open === false);
        }
        const {
            slice,
            page
        } = paginate(filtered, state.page.ongoing);
        const headers = ["Tipologia", "Aree", "Descrizione", "Aggiornamento", "Stato"];
        const pickers = [(r) => TYPE_LABELS[r.tipo] || r.tipo, (r) => (r.aree || []).join(", "), (r) => r.descrizione || "", (r) => fmtDT(new Date(r.aggiornamento)), (r) => (r.open !== false ? "Aperto" : "Chiuso"), ];
        downloadCSV(`eventi_in_atto_p${page}`, toCSV(slice, headers, pickers));
        toast("Esportazione completata", "File CSV generato.");
    }
    $("#gen-export").addEventListener("click", exportGEN);
    $("#ongoing-export").addEventListener("click", exportONGOING);
    $("#ev-export").addEventListener("click", () => {
        const ev = state.ongoing.find((x) => x.id === state.ui.currentEventId);
        if (!ev) return;
        const rows = ev.reports || [];
        const headers = ["Data", "Ora", "Tipo", "Verso", "Mittente/Destinatario", "Telefono", "E-mail", "Aree", "Oggetto", "Priorità", ];
        const pickers = [(r) => r.data, (r) => r.ora, (r) => r.tipo, (r) => r.verso, (r) => r.mitt, (r) => r.tel, (r) => r.mail, (r) => (r.aree || []).join(", "), (r) => r.oggetto, (r) => r.priorita, ];
        downloadCSV(`evento_${ev.id}_segnalazioni`, toCSV(rows, headers, pickers));
        toast("Esportazione evento", "CSV delle segnalazioni generato.");
    });
    // Print evento
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
    const genAree = new TagInput($("#gen-aree"), {
        datalistId: "comuni-datalist"
    });
    const editAree = new TagInput($("#edit-aree"), {
        datalistId: "comuni-datalist"
    });
    const evAreeInput = new TagInput($("#ev-aree-input"), {
        datalistId: "comuni-datalist"
    });
    $("#gen-aree").addEventListener("change", (e) => {
        $("#gen-aree-hidden").value = JSON.stringify(e.detail || []);
    });
    $("#edit-aree").addEventListener("change", (e) => {
        $("#edit-aree-hidden").value = JSON.stringify(e.detail || []);
    });

    /* ===== Global filters ===== */
    ["#gen-filter-comune", "#gen-filter-dal", "#gen-filter-al"].forEach((s) => $(s).addEventListener("input", () => {
        state.page.gen = 1;
        renderGEN();
    }));
    ["#ongoing-filter-comune", "#ongoing-filter-dal", "#ongoing-filter-al"].forEach((s) => $(s).addEventListener("input", () => {
        state.page.ongoing = 1;
        renderONGOING();
    }));
    ["#global-q", "#global-date", "#global-time", "#global-comune"].forEach((sel) => {
        $(sel).addEventListener("input", () => {
            state.global.q = $("#global-q").value.trim();
            state.global.date = $("#global-date").value;
            state.global.time = $("#global-time").value;
            state.global.comune = $("#global-comune").value.trim();
            state.page = {
                ...state.page,
                gen: 1,
                ongoing: 1
            };
            renderGEN();
            renderONGOING();
        });
    });

    /* ===== Helpers filtro/paginazione ===== */
    function matchesGlobalFilters(row, textGetter, dateGetter) {
        const {
            q,
            date,
            time,
            comune
        } = state.global;
        if (q) {
            const hay = (textGetter(row) || "").toLowerCase();
            if (!hay.includes(q.toLowerCase())) return false;
        }
        if (comune) {
            const areas = (row.aree || []).join(" ").toLowerCase();
            if (!areas.includes(comune.toLowerCase())) return false;
        }
        const dtRaw = dateGetter(row);
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
    }, textPicker, datePicker) {
        const dFrom = dal ? new Date(dal + "T00:00:00") : null;
        const dTo = al ? new Date(al + "T23:59:59") : null;
        return rows.filter((r) => {
            const dt = new Date(datePicker?.(r) || r.created_at || r.aggiornamento || new Date());
            if (dFrom && dt < dFrom) return false;
            if (dTo && dt > dTo) return false;
            if (comune) {
                const areas = (r.aree || []).map((x) => x.toLowerCase());
                if (!areas.some((a) => a.includes(comune.toLowerCase()))) return false;
            }
            return matchesGlobalFilters(r, textPicker, datePicker || ((x) => x.created_at));
        });
    }
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

    /* ===== Info modal: righe + open ===== */
    function genInfoRows(rec) {
        const typeLabel = TYPE_LABELS[rec.tipologia] || rec.tipologia || "—";
        const ev = rec.event_id ? state.ongoing.find((x) => String(x.id) === String(rec.event_id)) : null;
        const evText = rec.event_id ? (ev ? `[${TYPE_LABELS[ev.tipo]||ev.tipo}] ${(ev.aree||[]).join(", ")}` : `Evento #${rec.event_id}`) : "—";
        const created = new Date(rec.created_at || Date.now());
        const when = fmtDT(created);
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
        tbl.innerHTML = `<tbody>${rows.map(([k,v])=>`<tr class="border-t border-slate-200"><td class="px-3 py-2 font-semibold w-44">${k}</td><td class="px-3 py-2">${v}</td></tr>`).join("")}</tbody>`;
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

    /* ===== CSS inject ===== */
    const css = `
*{box-sizing:border-box} html,body{height:100%}
body{ margin:0; font:14px/1.5 system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif; color:#0f172a; background:#f6f8fb }
:root{
--primary:#2563eb; --primary-50:#eff6ff; --primary-600:#1d4ed8; --primary-700:#1e40af;
--muted:#64748b; --muted-50:#f1f5f9; --card:#ffffff; --line:#e2e8f0;

--ev-sismico:#dc2626; --ev-sismico-50:#fef2f2;
--ev-vulcanico:#9a3412; --ev-vulcanico-50:#fff7ed;
--ev-idraulico:#0ea5e9; --ev-idraulico-50:#e0f2fe;
--ev-idrogeologico:#10b981; --ev-idrogeologico-50:#d1fae5;
--ev-maremoto:#0284c7; --ev-maremoto-50:#e0f2fe;
--ev-deficit-idrico:#a16207; --ev-deficit-idrico-50:#fefce8;
--ev-meteo-avverso:#7c3aed; --ev-meteo-avverso-50:#f3e8ff;
--ev-aib:#f97316; --ev-aib-50:#ffedd5;
--ev-uomo:#334155; --ev-uomo-50:#e2e8f0;

--sec-gen:#8b5cf6; --sec-ongoing:#2563eb;

--prio-alta:#fee2e2; --prio-alta-line:#ef4444; --prio-alta-text:#991b1b;
--prio-media:#fff7ed; --prio-media-line:#f59e0b; --prio-media-text:#92400e;
--prio-bassa:#ecfdf5; --prio-bassa-line:#10b981; --prio-bassa-text:#065f46;
--prio-nessuna:#f1f5f9; --prio-nessuna-line:#94a3b8; --prio-nessuna-text:#334155;
}

.p-6{padding:2rem} .mb-4{margin-bottom:1rem} .mb-6{margin-bottom:1.5rem}
.grid{display:grid} .gap-3{gap:.75rem} .gap-4{gap:1rem}
.flex{display:flex} .flex-wrap{flex-wrap:wrap} .items-center{align-items:center}
.items-start{align-items:flex-start} .justify-between{justify-content:space-between}
.rounded-2xl{border-radius:1rem}
.text-sm{font-size:.875rem} .text-xs{font-size:.75rem} .text-xl{font-size:1.25rem} .font-semibold{font-weight:600}
.link{color:var(--primary); text-decoration:underline; cursor:pointer}
.shadow-card{box-shadow:0 1px 2px rgba(0,0,0,.05),0 8px 24px rgba(15,23,42,.06)}
.input{ height:2.5rem; border:1px solid var(--line); border-radius:.75rem; padding:.25rem .75rem; font-size:.875rem; background:#fff; color:#0f172a }
textarea.input{min-height:5.5rem; padding:.5rem .75rem}
.label{font-size:.8rem; color:#334155}
.btn{border:1px solid var(--line); border-radius:.75rem; padding:.55rem .8rem; font-size:.875rem; background:#fff; color:#0f172a; cursor:pointer; transition:background .15s, box-shadow .15s, transform .06s}
.btn:hover{background:var(--muted-50)} .btn:active{transform:translateY(1px)}
.btn-primary{ background:var(--primary); color:#fff; border-color:var(--primary); box-shadow:0 1px 0 rgba(0,0,0,.04), 0 6px 16px rgba(37,99,235,.18) }
.btn-primary:hover{ background:var(--primary-600); border-color:var(--primary-600); box-shadow:0 2px 0 rgba(0,0,0,.05), 0 10px 24px rgba(29,78,216,.22) }
.btn-primary:active{ background:var(--primary-700); border-color:var(--primary-700) }
.btn-xs{border:1px solid #e5e7eb; border-radius:.5rem; padding:.25rem .5rem; font-size:.75rem; background:#fff; cursor:pointer; display:inline-flex; align-items:center; gap:.25rem}
.btn-ghost{background:transparent; border-color:transparent}
.btn-danger{background:#fee2e2; border-color:#fecaca}
.actions{display:flex; gap:.25rem}
.actions .hi{display:inline-block; vertical-align:middle}

.sec{ --accent:#64748b; --thead:#f1f5f9; border:1px solid var(--line); border-left:8px solid var(--accent); background:var(--card); padding:1.25rem 1.25rem 1rem; }
.sec h3{color:var(--accent); margin:0} .sec thead{background:var(--thead)}
.sec--gen{ --accent:var(--sec-gen); --thead:color-mix(in oklab, var(--sec-gen) 8%, #fff) }
.sec--ongoing{ --accent:var(--sec-ongoing); --thead:color-mix(in oklab, var(--sec-ongoing) 8%, #fff) }

table{border-collapse:separate; border-spacing:0; width:100%}
thead th{border-bottom:1px solid var(--line); font-weight:600; padding:.6rem .75rem; text-align:center}
tbody td{padding:.55rem .75rem}
tbody tr:nth-child(even){background:#fafbff}
.border-slate-200{border-color:var(--line)} .border-t{border-top:1px solid var(--line)}
.pager{display:flex; align-items:center; gap:.5rem; justify-content:center; margin-top:.75rem} .pager__label{font-size:.85rem; opacity:.75}
.badge{display:inline-block; padding:.2rem .55rem; border-radius:.5rem; font-weight:600; font-size:.75rem; border:1px solid transparent; line-height:1}
.badge--in{background:#ecfdf5; border-color:#bbf7d0; color:#166534}
.badge--out{background:#fff1f2; border-color:#fecdd3; color:#991b1b}

.c-modal{position:fixed; inset:0; z-index:1000; display:none}
.c-modal.is-open{display:block} .c-modal.hidden{display:none}
.c-modal__backdrop{position:absolute; inset:0; background:rgba(0,0,0,.65)}
/* ===== FIX: scroll per le modali ===== */
.c-modal__dialog {
  position: relative;
  max-width: 72rem;
  width: min(96vw, 72rem);
  margin: 4vh auto;
  background: #fff;
  border: 1px solid var(--line);
  border-radius: 1rem;
  box-shadow: 0 10px 30px rgba(0, 0, 0, .2);
  padding: 1.25rem;

  /* ⬇️ Abilita scroll interno alla modale */
  max-height: calc(100svh - 8vh);
  overflow: auto;
  -webkit-overflow-scrolling: touch;
  overscroll-behavior: contain;

  display: flex;
  flex-direction: column;
}

/* Mobile: margini e altezza ottimizzati */
@media (max-width: 640px) {
  .c-modal__dialog {
    margin: 2vh auto;
    max-height: calc(100svh - 4vh);
  }
}
.c-modal--overlay{ z-index:1100 }
/* TOP assoluto per “Tutte le comunicazioni” */
.c-modal--top{ z-index:1200 }

.c-modal__close{ position:absolute; top:.75rem; right:.75rem; background:transparent; border:none; font-size:1.25rem; color:#475569; cursor:pointer; line-height:1 }

.ev-card{
--ev:var(--ev-meteo-avverso); --ev-50:var(--ev-meteo-avverso-50);
border:1px solid var(--line); border-left:8px solid var(--ev); border-radius:1rem; background:#fff; padding:1rem 1rem 0.85rem;
box-shadow:0 1px 2px rgba(0,0,0,.04); display:flex; flex-direction:column; gap:.5rem; cursor:pointer;
transition:transform .06s ease, box-shadow .12s ease, background .12s ease;
}
.ev-card:hover{transform:translateY(-1px); box-shadow:0 6px 16px rgba(0,0,0,.06); background:var(--ev-50)}
.ev-card__head{display:flex; align-items:start; justify-content:space-between; gap:.5rem}
.ev-card__title{font-weight:700; line-height:1.3; margin:0}
.ev-card__chips{display:flex; align-items:center; gap:.4rem}
.ev-card__badge{ font-size:.7rem; border:1px solid color-mix(in oklab, var(--ev) 55%, white); background: color-mix(in oklab, var(--ev) 15%, white); color: color-mix(in oklab, var(--ev) 70%, black); border-radius:.5rem; padding:.15rem .5rem }
.ev-card__status{font-size:.7rem; border-radius:999px; padding:.15rem .55rem; border:1px solid transparent; font-weight:700}
.ev-card__status.is-open{ background:#dcfce7; color:#166534; border-color:#bbf7d0 }
.ev-card__status.is-closed{ background:#e5e7eb; color:#374151; border-color:#d1d5db }
.ev-card__meta{margin:0; padding:0; list-style:none; font-size:.87rem; color:#334155; display:grid; gap:.15rem}

.ev-inline-status{ display:inline-block; margin-left:.5rem; padding:.1rem .5rem; font-size:.7rem; border-radius:999px; border:1px solid transparent; font-weight:700 }
.ev-inline-status.is-open{ background:#dcfce7; color:#166534; border-color:#bbf7d0 }
.ev-inline-status.is-closed{ background:#e5e7eb; color:#374151; border-color:#d1d5db }

/* Colori card per tipo */
.ev-card[data-type="sismico"]{--ev:var(--ev-sismico); --ev-50:var(--ev-sismico-50)}
.ev-card[data-type="vulcanico"]{--ev:var(--ev-vulcanico); --ev-50:var(--ev-vulcanico-50)}
.ev-card[data-type="idraulico"]{--ev:var(--ev-idraulico); --ev-50:var(--ev-idraulico-50)}
.ev-card[data-type="idrogeologico"]{--ev:var(--ev-idrogeologico); --ev-50:var(--ev-idrogeologico-50)}
.ev-card[data-type="maremoto"]{--ev:var(--ev-maremoto); --ev-50:var(--ev-maremoto-50)}
.ev-card[data-type="deficit-idrico"]{--ev:var(--ev-deficit-idrico); --ev-50:var(--ev-deficit-idrico-50)}
.ev-card[data-type="meteo-avverso"]{--ev:var(--ev-meteo-avverso); --ev-50:var(--ev-meteo-avverso-50)}
.ev-card[data-type="aib"]{--ev:var(--ev-aib); --ev-50:var(--ev-aib-50)}
.ev-card[data-type="uomo"]{--ev:var(--ev-uomo); --ev-50:var(--ev-uomo-50)}

/* Legenda (eventi + priorità con stesso stile) */
.ongoing-legend{ display:flex; flex-wrap:wrap; gap:.6rem .85rem; margin:.25rem 0 .75rem 0; align-items:center }
.ol-item{display:inline-flex; align-items:center; gap:.4rem; font-size:.8rem; color:#334155; border:1px solid var(--line); border-radius:.75rem; padding:.25rem .6rem; background:#fff}
.ol-dot{width:.85rem; height:.85rem; border-radius:999px; display:inline-block; background:var(--ev); box-shadow:0 0 0 2px color-mix(in oklab, var(--ev) 25%, white) inset}

/* Mappatura colori per legenda EVENTI (questo risolve i "colori non vanno") */
.ongoing-legend .ol-item[data-type="sismico"]{ --ev:var(--ev-sismico) }
.ongoing-legend .ol-item[data-type="vulcanico"]{ --ev:var(--ev-vulcanico) }
.ongoing-legend .ol-item[data-type="idraulico"]{ --ev:var(--ev-idraulico) }
/***** (continua) *****/
.ongoing-legend .ol-item[data-type="idrogeologico"]{ --ev:var(--ev-idrogeologico) }
.ongoing-legend .ol-item[data-type="maremoto"]{ --ev:var(--ev-maremoto) }
.ongoing-legend .ol-item[data-type="deficit-idrico"]{ --ev:var(--ev-deficit-idrico) }
.ongoing-legend .ol-item[data-type="meteo-avverso"]{ --ev:var(--ev-meteo-avverso) }
.ongoing-legend .ol-item[data-type="aib"]{ --ev:var(--ev-aib) }
.ongoing-legend .ol-item[data-type="uomo"]{ --ev:var(--ev-uomo) }
.ongoing-legend .ol-item[data-type="altro"]{ --ev:#64748b }

/* Legenda PRIORITÀ con lo stesso stile della legenda eventi */
.prio-legend .ol-item[data-prio="alta"]{ --ev:var(--prio-alta-line) }
.prio-legend .ol-item[data-prio="media"]{ --ev:var(--prio-media-line) }
.prio-legend .ol-item[data-prio="bassa"]{ --ev:var(--prio-bassa-line) }
.prio-legend .ol-item[data-prio="nessuna"]{ --ev:var(--prio-nessuna-line) }

/* Badge priorità + righe evidenziate come prima */
.prio-badge{ display:inline-block; padding:.15rem .5rem; border-radius:.5rem; font-weight:700; font-size:.75rem; border:1px solid transparent; line-height:1 }
.prio-badge.prio--alta{ background:var(--prio-alta); color:var(--prio-alta-text); border-color:var(--prio-alta-line) }
.prio-badge.prio--media{ background:var(--prio-media); color:var(--prio-media-text); border-color:var(--prio-media-line) }
.prio-badge.prio--bassa{ background:var(--prio-bassa); color:var(--prio-bassa-text); border-color:var(--prio-bassa-line) }
.prio-badge.prio--nessuna{ background:var(--prio-nessuna); color:var(--prio-nessuna-text); border-color:var(--prio-nessuna-line) }

tbody tr.prio-row{ border-left:6px solid transparent }
tbody tr.prio-row.prio--alta{ border-left-color:var(--prio-alta-line); background:color-mix(in oklab, var(--prio-alta) 55%, white) }
tbody tr.prio-row.prio--media{ border-left-color:var(--prio-media-line); background:color-mix(in oklab, var(--prio-media) 55%, white) }
tbody tr.prio-row.prio--bassa{ border-left-color:var(--prio-bassa-line); background:color-mix(in oklab, var(--prio-bassa) 55%, white) }
tbody tr.prio-row.prio--nessuna{ border-left-color:var(--prio-nessuna-line); background:color-mix(in oklab, var(--prio-nessuna) 55%, white) }

/* Piccole utility */
#modal-gen-info td.w-44{width:11rem}
@media print{ body{background:#fff} .btn,.btn-xs{display:none} .c-modal__dialog{box-shadow:none} }

/* Modale evento sempre sopra a tutto */
.c-modal--super{ z-index:1300 }

/* Mini-card evento usata nella tabella "Tutte le comunicazioni" */
.ev-chip{
  display:block;
  text-align:left;
  width:100%;
  border:1px solid var(--line);
  border-left:8px solid var(--ev);
  border-radius:.75rem;
  background:#fff;
  padding:.5rem .6rem;
  cursor:pointer;
  transition:transform .06s ease, box-shadow .12s ease, background .12s ease;
}
.ev-chip:hover{ transform:translateY(-1px); box-shadow:0 6px 16px rgba(0,0,0,.06); background:var(--ev-50) }
.ev-chip__title{ display:block; font-weight:700; font-size:.8rem; line-height:1.25 }
.ev-chip__meta{ display:block; font-size:.7rem; opacity:.75; margin-top:.15rem }
.ev-chip__status{
  display:inline-block; margin-top:.25rem; font-size:.68rem; font-weight:700;
  padding:.1rem .45rem; border-radius:999px; border:1px solid transparent;
}
.ev-chip__status.is-open{ background:#dcfce7; color:#166534; border-color:#bbf7d0 }
.ev-chip__status.is-closed{ background:#e5e7eb; color:#374151; border-color:#d1d5db }

/* Mappatura colori per le mini-card per tipo */
.ev-chip[data-type="sismico"]{ --ev:var(--ev-sismico); --ev-50:var(--ev-sismico-50) }
.ev-chip[data-type="vulcanico"]{ --ev:var(--ev-vulcanico); --ev-50:var(--ev-vulcanico-50) }
.ev-chip[data-type="idraulico"]{ --ev:var(--ev-idraulico); --ev-50:var(--ev-idraulico-50) }
.ev-chip[data-type="idrogeologico"]{ --ev:var(--ev-idrogeologico); --ev-50:var(--ev-idrogeologico-50) }
.ev-chip[data-type="maremoto"]{ --ev:var(--ev-maremoto); --ev-50:var(--ev-maremoto-50) }
.ev-chip[data-type="deficit-idrico"]{ --ev:var(--ev-deficit-idrico); --ev-50:var(--ev-deficit-idrico-50) }
.ev-chip[data-type="meteo-avverso"]{ --ev:var(--ev-meteo-avverso); --ev-50:var(--ev-meteo-avverso-50) }
.ev-chip[data-type="aib"]{ --ev:var(--ev-aib); --ev-50:var(--ev-aib-50) }
.ev-chip[data-type="uomo"]{ --ev:var(--ev-uomo); --ev-50:var(--ev-uomo-50) }
.ev-chip[data-type="altro"]{ --ev:#64748b; --ev-50:#f1f5f9 }

/* ===== FIX modal evento: spazio per la X + hitbox corretta ===== */

/* lascia spazio interno a destra nel dialog così i bottoni non finiscono sotto la X */
#modal-event .c-modal__dialog{
  padding-right: 3.25rem; /* >= larghezza/hitbox della X */
}

/* restringi l’area cliccabile della X: niente overlay “invisibile” sui bottoni */
#modal-event .c-modal__close{
  top: .6rem;
  right: .6rem;
  width: 2rem;         /* 32px */
  height: 2rem;        /* 32px */
  padding: 0;
  display: grid;
  place-items: center;
  line-height: 1;
  border-radius: .5rem;
  background: #fff;
  border: 1px solid var(--line);
  box-shadow: 0 1px 2px rgba(0,0,0,.06);
  z-index: 5;          /* sopra il contenuto, ma senza coprire oltre i suoi 32px */
}
#modal-event .c-modal__close *{ pointer-events: none; } /* evita “bolle” di click strane */

/* (opzionale) sugli schermi piccoli riduci un filo il padding extra */
@media (max-width: 640px){
  #modal-event .c-modal__dialog{ padding-right: 3rem; }
}

/* assicurati che il gruppo bottoni non venga tagliato/compress o sovrapposto */
#modal-event header .flex{ flex-wrap: wrap; gap: .4rem; }

/* migliora il target del pulsante piccolo blu */
#modal-event .btn.btn-xs{
  min-height: 2rem;
  padding: .35rem .6rem;
}


/* ===== FIX colore costante bottone blu ===== */

#modal-event .btn.btn-xs.btn-primary,
.btn.btn-xs.btn-primary {
  background-color: var(--primary);
  border-color: var(--primary);
  color: #fff;
  box-shadow: 0 1px 0 rgba(0, 0, 0, 0.04), 0 6px 16px rgba(37, 99, 235, 0.18);
  transition: background-color .15s, border-color .15s, transform .06s, box-shadow .15s;
}

/* hover: più scuro ma sempre blu */
#modal-event .btn.btn-xs.btn-primary:hover,
.btn.btn-xs.btn-primary:hover {
  background-color: var(--primary-600);
  border-color: var(--primary-600);
  box-shadow: 0 2px 0 rgba(0, 0, 0, 0.05), 0 10px 24px rgba(29, 78, 216, 0.22);
  color: #fff;
}

/* attivo: tono leggermente più profondo */
#modal-event .btn.btn-xs.btn-primary:active,
.btn.btn-xs.btn-primary:active {
  background-color: var(--primary-700);
  border-color: var(--primary-700);
  transform: translateY(1px);
  color: #fff;
}

/* =========================
   OVERRIDE: PRIORITÀ MODALE EV-FORM
   ========================= */
/* La modale di modifica/nuova comunicazione evento sta sopra a tutto */
#modal-ev-form { z-index: 2000 !important; }
#modal-ev-form .c-modal__backdrop { z-index: 1999 !important; background: rgba(0,0,0,.55); }
#modal-ev-form .c-modal__dialog  { z-index: 2001 !important; }

/* (opzionale) assicura che eventuali altre modali non le passino davanti */
#modal-event              { z-index: 1300 !important; }
#modal-all-reports        { z-index: 1200 !important; }
.c-modal.c-modal--overlay { z-index: 1400 !important; }
/* SweetAlert resta sotto a ev-form ma sopra il resto */
.swal2-container          { z-index: 1600 !important; }

/* =========================
   OVERRIDE: BADGE AREE INTERESSATE
   ========================= */
/* Contenitore generale dei tag/badge */
.tags {
  display: flex;
  flex-wrap: wrap;
  gap: .4rem .5rem;
}

/* Trasforma i .tag in badge compatti */
#ev-areas .tag {
  display: inline-flex;
  align-items: center;
  gap: .35rem;
  padding: .2rem .55rem;
  border-radius: .5rem;
  font-weight: 700;
  font-size: .75rem;
  line-height: 1;
  background: #f8fafc;              /* bg chiaro */
  color: #0f172a;                    /* testo scuro */
  border: 1px solid var(--line);     /* bordo sottile */
  box-shadow: 0 1px 0 rgba(0,0,0,.02);
}

/* Puntino decorativo (facoltativo) all'inizio del badge */
#ev-areas .tag::before {
  content: "";
  width: .45rem;
  height: .45rem;
  border-radius: 999px;
  background: var(--primary);
  opacity: .9;
}

/* I badge qui sono solo display, niente “X” di rimozione */
#ev-areas .tag .tag__x { display: none !important; }

/* =========================
   (FACOLTATIVO) RIFINITURE TAG-INPUT
   – utile per i campi dove inserisci/editi le aree
   ========================= */
.tag-input--wrap {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: .4rem;
  padding: .4rem .5rem;
  border: 1px solid var(--line);
  border-radius: .75rem;
  background: #fff;
}
.tag-input__control { flex: 1 1 10rem; min-width: 10rem; }
.tag-input__field {
  display: block;
  width: 100%;
  height: 2rem;
  border: 0;
  outline: 0;
  font-size: .875rem;
  background: transparent;
  color: #0f172a;
}
.tag {
  display: inline-flex;
  align-items: center;
  gap: .35rem;
  padding: .25rem .55rem;
  border-radius: .5rem;
  font-size: .75rem;
  font-weight: 700;
  line-height: 1;
  background: var(--muted-50);
  color: #0f172a;
  border: 1px solid var(--line);
}
.tag__x {
  display: inline-grid;
  place-items: center;
  width: 1rem;
  height: 1rem;
  line-height: 1;
  border-radius: .25rem;
  background: #fff;
  border: 1px solid var(--line);
  cursor: pointer;
}
.tag__x:hover { background: #f8fafc; }

/* ===== Badge Verso (Entrata / Uscita) per tabella “Tutte le comunicazioni” ===== */
#modal-all-reports table td[data-verso="E"],
#modal-all-reports table td[data-verso="U"] {
  text-align: center;
  padding: .45rem .5rem;
}

#modal-all-reports .badge--in,
#modal-all-reports .badge--out {
  display: inline-block;
  font-weight: 700;
  font-size: .75rem;
  line-height: 1;
  padding: .25rem .55rem;
  border-radius: .5rem;
  border: 1px solid transparent;
}

/* Entrata = verde */
#modal-all-reports .badge--in {
  background: #ecfdf5;
  border-color: #bbf7d0;
  color: #166534;
}

/* Uscita = rosso */
#modal-all-reports .badge--out {
  background: #fff1f2;
  border-color: #fecdd3;
  color: #991b1b;
}

/* Box anteprima comunicazioni evento dentro le modali GEN */
.ev-preview{
  margin-top:.75rem;
  border:1px solid var(--line);
  border-radius:.75rem;
  background:#fff;
  padding:.75rem;
}
.ev-preview__head{display:flex; align-items:center; justify-content:space-between; margin-bottom:.5rem}
.ev-preview__title{margin:0; font-size:.9rem; font-weight:700}
.ev-preview__empty{font-size:.8rem; opacity:.75; padding:.25rem 0}


`;
    const style = document.createElement("style");
    style.textContent = css;
    document.head.appendChild(style);

    /* ===== START ===== */
    function renderAll() {
        renderGEN();
        renderONGOING();
    }
    renderAll();
    if (window.lucide) lucide.createIcons();

    /* ===== Pulsante filtro stato: Tutti / Solo aperti / Solo chiusi ===== */
    const toggleBtn = $("#ongoing-toggle-status");

    function updateToggleBtn() {
        if (!toggleBtn) return;
        toggleBtn.textContent =
            state.ui.ongoingStatus === "all" ? "Tutti" :
            state.ui.ongoingStatus === "open" ? "Solo aperti" : "Solo chiusi";
        toggleBtn.title = toggleBtn.textContent;
    }
    if (toggleBtn) {
        updateToggleBtn();
        toggleBtn.addEventListener("click", () => {
            state.ui.ongoingStatus =
                state.ui.ongoingStatus === "all" ? "open" :
                state.ui.ongoingStatus === "open" ? "closed" : "all";
            state.page.ongoing = 1;
            updateToggleBtn();
            renderONGOING();
        });
    }

    /* ===== Utility: collega una segnalazione generica ad un evento esistente ===== */
    function attachGenToEvent(evId, rec) {
        const ev = state.ongoing.find(e => String(e.id) === String(evId));
        if (!ev) return false;

        ev.reports = ev.reports || [];
        ev.reports.unshift(makeInitialReportFromGen(rec)); // crea la “comunicazione iniziale”
        ev.aggiornamento = new Date().toISOString();
        ev.open = true;
        return true;
    }


    /* ===== Utility: prima comunicazione da generica ===== */
    function makeInitialReportFromGen(rec) {
        const d = new Date(rec.created_at || Date.now());
        const {
            date,
            time
        } = toITParts(d);
        return {
            data: date,
            ora: time,
            tipo: "—",
            verso: (rec.direzione || "E").toUpperCase() === "U" ? "Uscita" : "Entrata",
            mitt: "",
            tel: "",
            mail: "",
            indirizzo: "",
            provincia: "",
            comune: "",
            aree: (rec.aree || []).slice(),
            oggetto: rec.sintesi || `Segnalazione ${TYPE_LABELS[rec.tipologia] || rec.tipologia || ""}`,
            contenuto: rec.sintesi || "",
            priorita: rec.priorita || "Nessuna",
        };
    }
    /* ===== Anteprima comunicazioni evento (usata dentro le modali GEN) ===== */
    function ensureEvPreviewBox(afterEl, boxId) {
        let box = document.getElementById(boxId);
        if (!box) {
            box = document.createElement("section");
            box.id = boxId;
            box.className = "ev-preview shadow-card";
            // lo inserisco subito dopo il <select> dell'associazione evento
            afterEl.parentElement.insertAdjacentElement("afterend", box);
        }
        return box;
    }

    function renderEvPreview(evId, mountEl) {
        const box = ensureEvPreviewBox(mountEl, mountEl.id + "-preview");
        box.replaceChildren();

        // header
        const head = document.createElement("div");
        head.className = "ev-preview__head";
        head.innerHTML = `<h5 class="ev-preview__title">Comunicazioni evento</h5>
  <div class="ev-preview__meta text-xs opacity-70"></div>`;
        box.appendChild(head);

        // stato vuoto / crea nuovo
        if (!evId || evId === "__new__") {
            box.appendChild(document.createElement("div")).outerHTML =
                `<div class="ev-preview__empty">Nessun evento selezionato.
       Se scegli “Crea nuovo evento”, questa segnalazione diventerà la prima comunicazione.</div>`;
            return;
        }

        const ev = state.ongoing.find(e => String(e.id) === String(evId));
        if (!ev) {
            box.appendChild(document.createElement("div")).outerHTML =
                `<div class="ev-preview__empty">Evento #${evId} non presente in memoria locale.</div>`;
            return;
        }

        // meta (titolo + aree + stato)
        head.querySelector(".ev-preview__meta").innerHTML =
            `<strong>${TYPE_LABELS[ev.tipo]||ev.tipo}</strong> — ${(ev.aree||[]).join(", ")||"—"}
     <span class="ev-inline-status ${ev.open!==false?"is-open":"is-closed"}"
           style="margin-left:.35rem">${ev.open!==false?"Aperto":"Chiuso"}</span>`;

        // tabella comunicazioni
        const rows = (ev.reports || []).map((r, i) => ({
                ...r,
                _i: i
            }))
            .sort((a, b) => parseIT(b.data, b.ora) - parseIT(a.data, a.ora));

        const wrap = document.createElement("div");
        wrap.className = "overflow-x-auto";
        const tbl = document.createElement("table");
        tbl.className = "w-full text-sm";
        tbl.innerHTML = `
    <thead>
      <tr>
        <th class="px-3 py-2">Data</th>
        <th class="px-3 py-2">Ora</th>
        <th class="px-3 py-2">Tipo</th>
        <th class="px-3 py-2">Verso</th>
        <th class="px-3 py-2">Mitt./Dest.</th>
        <th class="px-3 py-2">Telefono</th>
        <th class="px-3 py-2">E-mail</th>
        <th class="px-3 py-2">Aree</th>
        <th class="px-3 py-2">Oggetto</th>
        <th class="px-3 py-2">Priorità</th>
      </tr>
    </thead>
    <tbody></tbody>`;
        const tbody = tbl.querySelector("tbody");
        if (!rows.length) {
            const tr = document.createElement("tr");
            tr.innerHTML = `<td colspan="10" class="px-3 py-3 opacity-70">Nessuna comunicazione per questo evento.</td>`;
            tbody.appendChild(tr);
        } else {
            rows.forEach(r => {
                const tr = document.createElement("tr");
                tr.className = "border-t border-slate-200 prio-row " + prioClass(r.priorita || "Nessuna");
                const cell = t => {
                    const td = document.createElement("td");
                    td.className = "px-3 py-2";
                    td.textContent = t || "";
                    return td;
                };
                tr.appendChild(cell(r.data || ""));
                tr.appendChild(cell(r.ora || ""));
                tr.appendChild(cell(r.tipo || ""));

                // Verso con badge E/U
                const tdVerso = document.createElement("td");
                tdVerso.className = "px-3 py-2 text-center";
                const raw = (r.verso || "").trim().toUpperCase();
                const dir = raw.startsWith("U") ? "U" : "E";
                tdVerso.appendChild(makeDirBadge(dir));
                tr.appendChild(tdVerso);

                // Mitt, Tel, Mail, Aree, Oggetto
                tr.appendChild(cell(r.mitt || ""));
                tr.appendChild(cell(r.tel || ""));
                tr.appendChild(cell(r.mail || ""));
                tr.appendChild(cell((r.aree || []).join(", ")));
                tr.appendChild(cell(r.oggetto || ""));

                // Priorità (badge)
                const tdPr = document.createElement("td");
                tdPr.className = "px-3 py-2";
                tdPr.appendChild(makePrioBadge(r.priorita || "Nessuna"));
                tr.appendChild(tdPr);

                tbody.appendChild(tr);
            });
        }
        wrap.appendChild(tbl);
        box.appendChild(wrap);
    }

    /* ===== RESET FILTRI ===== */
    function resetGlobalFilters() {
        // svuota i campi
        $("#global-q").value = "";
        $("#global-date").value = "";
        $("#global-time").value = "";
        $("#global-comune").value = "";
        // azzera lo stato globale
        state.global = {
            q: "",
            date: "",
            time: "",
            comune: ""
        };
        // torna alla prima pagina di entrambe le viste
        state.page.gen = 1;
        state.page.ongoing = 1;
        // ri-render
        renderGEN();
        renderONGOING();
    }

    function resetGenFilters() {
        $("#gen-filter-comune").value = "";
        $("#gen-filter-dal").value = "";
        $("#gen-filter-al").value = "";
        state.page.gen = 1;
        renderGEN();
    }

    function resetOngoingFilters() {
        $("#ongoing-filter-comune").value = "";
        $("#ongoing-filter-dal").value = "";
        $("#ongoing-filter-al").value = "";
        state.page.ongoing = 1;
        renderONGOING();
    }

    /* ===== CLICK LISTENERS RESET ===== */
    document.getElementById("global-reset")?.addEventListener("click", resetGlobalFilters);
    document.getElementById("gen-filters-reset")?.addEventListener("click", resetGenFilters);
    document.getElementById("ongoing-filters-reset")?.addEventListener("click", resetOngoingFilters);

    // === PATCH: esponi lo state per altre sezioni (readonly + helper) ===
    window.SOR = window.SOR || {};
    // snapshot in sola lettura (evita mutazioni dirette)
    window.SOR.getState = () => JSON.parse(JSON.stringify(state));
    // utilità per future azioni centralizzate (qui solo no-op per il debug panel)
    window.SOR.update = (producer = (s) => s) => {
        // in futuro: producer(state); save(); renderGEN(); renderONGOING();
        return;
    };

    // Bridge per il coord-app: rispondi a SOR_DASH_REQUEST con lo snapshot corrente
    window.addEventListener('message', (ev) => {
        if (ev?.data?.type === 'SOR_DASH_REQUEST') {
            try {
                const payload = (window.SOR?.getState?.() ?? state);
                // rispondi alla finestra chiamante rispettando l'origine
                ev.source?.postMessage({
                    type: 'SOR_DASH_SNAPSHOT',
                    payload
                }, ev.origin || '*');
            } catch {}
        }
    });
</script>