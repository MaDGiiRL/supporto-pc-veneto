<div class="p-6" id="app">
    <header class="mb-4 flex items-center justify-between">
        <h2 class="text-xl font-semibold">Dashboard SOR</h2>
        <button class="btn btn-primary" data-open-modal="#modal-gen">📝 Nuova segnalazione generica</button>
    </header>

    <!-- Ricerca globale -->
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

    <!-- SEGNALAZIONI GENERICHE -->
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
            <button class="btn btn-xs mb-2" id="gen-filters-reset" type="button">Reset</button>
            <div class="text-sm opacity-70 ml-auto mt-5">10 per pagina</div>
        </div>

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
                        <th class="px-3 py-2">Data</th>
                        <th class="px-3 py-2">Ora</th>
                        <th class="px-3 py-2">E/U</th>
                        <th class="px-3 py-2">Comune</th>
                        <th class="px-3 py-2 w-sintesi">Oggetto</th>
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

    <!-- EVENTI IN ATTO -->
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
            <button class="btn btn-xs mb-2" id="ongoing-filters-reset" type="button">Reset</button>
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
    <div class="c-modal__dialog" role="dialog" aria-modal="true" style="max-width:56rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h3 class="mb-2 text-lg font-semibold">Nuova segnalazione generica</h3>
        <p class="text-xs opacity-70 mb-4">
            Il modulo utilizza gli stessi campi di una comunicazione evento, con in più la tipologia e i campi specifici.
        </p>

        <form id="form-gen" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" id="gen-id" />

            <!-- Tipologia + Priorità -->
            <label class="grid gap-1.5">
                <span class="label">Tipologia evento (opzionale)</span>
                <select name="tipologia" id="gen-tipologia" class="input">
                    <option value="" selected>— Non specificata —</option>
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

            <label class="grid gap-1.5">
                <span class="label">Priorità</span>
                <div class="flex flex-wrap items-center gap-4 mt-1">
                    <label class="inline-flex items-center gap-2">
                        <input type="radio" name="priorita" value="Nessuna" checked /> Nessuna
                    </label>
                    <label class="inline-flex items-center gap-2">
                        <input type="radio" name="priorita" value="Alta" /> Alta
                    </label>
                    <label class="inline-flex items-center gap-2">
                        <input type="radio" name="priorita" value="Media" /> Media
                    </label>
                    <label class="inline-flex items-center gap-2">
                        <input type="radio" name="priorita" value="Bassa" /> Bassa
                    </label>
                </div>
            </label>

            <!-- Associazione evento -->
            <label class="grid gap-1.5 md:col-span-2">
                <span class="label">Associa a evento in atto</span>
                <select name="event_id" id="gen-event-select" class="input">
                    <option value="">— Nessuna associazione —</option>
                    <option value="__new__">[+ Crea nuovo evento]</option>
                </select>
                <span class="text-xs opacity-70 mt-1">
                    Se scegli “Crea nuovo evento”, verrà creato un evento in “Eventi in atto” con questa segnalazione.
                </span>
            </label>

            <!-- 🔹 Clone form comunicazione 🔹 -->

            <label class="grid gap-1.5">
                <span class="label">Data comunicazione</span>
                <input id="g-data" class="input" type="text" placeholder="gg/mm/aaaa" />
            </label>
            <label class="grid gap-1.5">
                <span class="label">Ora comunicazione</span>
                <input id="g-ora" class="input" type="text" placeholder="hh:mm" />
            </label>

            <label class="grid gap-1.5">
                <span class="label">Tipo comunicazione</span>
                <select id="g-tipo" class="input">
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
                    <label class="inline-flex items-center gap-2">
                        <input type="radio" name="g-verso" value="E" checked /> Entrata (E)
                    </label>
                    <label class="inline-flex items-center gap-2">
                        <input type="radio" name="g-verso" value="U" /> Uscita (U)
                    </label>
                </div>
            </div>

            <label class="grid gap-1.5 md:col-span-2">
                <span class="label">Mittente/Destinatario</span>
                <input id="g-mitt" class="input" />
            </label>

            <label class="grid gap-1.5">
                <span class="label">Telefono</span>
                <input id="g-tel" class="input" />
            </label>

            <label class="grid gap-1.5">
                <span class="label">E-mail</span>
                <input id="g-mail" class="input" type="email" />
            </label>

            <label class="grid gap-1.5 md:col-span-2">
                <span class="label">Indirizzo zona colpita</span>
                <input id="g-indirizzo" class="input" />
            </label>

            <label class="grid gap-1.5">
                <span class="label">Provincia</span>
                <select id="g-provincia" class="input">
                    <option value="">Tutte le province...</option>
                </select>
            </label>

            <label class="grid gap-1.5">
                <span class="label">Zona (Comune)</span>
                <select id="g-comune" class="input" disabled>
                    <option value="">Prima seleziona una provincia...</option>
                </select>
            </label>

            <label class="grid gap-1.5 md:col-span-2">
                <span class="label">Aree interessate (Comuni e Frazioni)</span>
                <div class="tag-input" id="gen-aree" data-datalist="comuni-datalist"></div>
                <input type="hidden" name="aree" id="gen-aree-hidden" />
            </label>

            <label class="grid gap-1.5 md:col-span-2">
                <span class="label">Oggetto</span>
                <input id="g-oggetto" class="input" />
            </label>

            <label class="grid gap-1.5 md:col-span-2">
                <span class="label">Contenuto</span>
                <textarea id="g-contenuto" class="input"></textarea>
            </label>

            <!-- Campi specifici dinamici -->
            <div class="md:col-span-2">
                <legend class="text-sm font-semibold mb-1">Campi specifici</legend>
                <div id="gen-specific"></div>
            </div>

            <div class="md:col-span-2 flex justify-end gap-2 pt-2">
                <button type="button" class="btn" data-close-modal>Chiudi</button>
                <button type="reset" class="btn">Reset</button>
                <button type="submit" class="btn btn-primary">💾 Salva segnalazione</button>
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



<!-- Datalist Comuni -->
<datalist id="comuni-datalist"></datalist>

<script>
    window.PROVINCE = @json(config('province.veneto'));
    window.VENETO_COMUNI = @json(config('comuni_veneto'));
</script>

@include('partials.sor-modals')

<script type="module">
    /* ===== Utils ===== */
    const $ = (s) => document.querySelector(s);
    const fmtDT = (d) =>
        new Intl.DateTimeFormat("it-IT", {
            dateStyle: "short",
            timeStyle: "short"
        }).format(d);
    const PREVIEW_MAX = 500;
    const truncate = (str = "", n = PREVIEW_MAX) =>
        (str.length > n ? str.slice(0, n).trimEnd() + "…" : str);
    const nowIT = () => {
        const d = new Date();
        const pad = (n) => String(n).padStart(2, "0");
        return {
            date: `${pad(d.getDate())}/${pad(d.getMonth() + 1)}/${d.getFullYear()}`,
            time: `${pad(d.getHours())}:${pad(d.getMinutes())}`,
        };
    };
    const parseIT = (dateStr, timeStr = "00:00") => {
        const [dd, mm, yyyy] = (dateStr || "").split("/");
        const [HH, MM] = (timeStr || "00:00").split(":");
        return new Date(Number(yyyy), Number(mm) - 1, Number(dd), Number(HH), Number(MM));
    };

    // espongo fmtDT per le modali
    window.fmtDT = fmtDT;

    /* ===== Toast & confirm ===== */
    const toast = (title, text = "", icon = "success", timer = 1700) => {
        if (!window.Swal) {
            console.warn("Swal non disponibile:", title, text);
            return;
        }
        Swal.fire({
            title,
            text,
            icon,
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer,
            timerProgressBar: true,
        });
    };
    const confirmDelete = (
        title = "Eliminare la segnalazione?",
        text = "Questa azione non può essere annullata."
    ) => Swal.fire({
        title,
        text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sì, elimina",
        cancelButtonText: "Annulla",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
    });

    // espongo toast per uso nelle modali
    window.toast = toast;

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

    /* ===== Tag Input (vincolato ai valori del datalist) ===== */
    class TagInput {
        constructor(root, {
            placeholder = "Aggiungi e premi Invio",
            datalistId = null
        } = {}) {
            if (!root) {
                console.warn("TagInput: root mancante, istanza ignorata");
                return;
            }
            this.root = root;
            this.values = [];
            this.placeholder = placeholder;
            this.datalistId = datalistId;
            this.allowedValues = null;
            this.render();
        }

        refreshAllowedFromDatalist() {
            if (!this.datalistId) return;
            const dl = document.getElementById(this.datalistId);
            if (!dl) return;
            this.allowedValues = new Set(
                Array.from(dl.options)
                    .map(o => o.value)
                    .filter(Boolean)
            );
        }

        render() {
            this.root.classList.add("tag-input--wrap");
            this.root.innerHTML = `<div class="tags" role="list"></div>
        <div class="tag-input__control"><input class="tag-input__field" ${
                this.datalistId ? `list="${this.datalistId}"` : ""
            } placeholder="${this.placeholder}"/></div>`;
            this.tagsEl = this.root.querySelector(".tags");
            this.inputEl = this.root.querySelector(".tag-input__field");

            if (this.datalistId) {
                this.refreshAllowedFromDatalist();
            }

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

            // vincolo: se c'è un datalist, accetto solo valori presenti
            if (this.allowedValues && !this.allowedValues.has(v)) {
                if (typeof toast === "function") {
                    toast("Valore non valido", "Seleziona un'area dalla lista predefinita.", "error", 2200);
                }
                return;
            }

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

    /* ===== Seed da config (Veneto) – NUOVO con istat/zona/frazioni ===== */
    const PROVINCE = window.PROVINCE || {};
    const COMUNI_RAW = window.VENETO_COMUNI || {};
    const COMUNI_FLAT_CONFIG = window.VENETO_COMUNI_FLAT || [];

    /**
     * COMUNE_META: lookup robusto
     * key = `${provincia}|${nomeComune}`
     * value = { istat, nome, provincia, zona, frazioni[] }
     */
    const COMUNE_META = {};

    (function buildComuneMeta() {
        Object.entries(COMUNI_RAW).forEach(([prov, list]) => {
            if (Array.isArray(list)) {
                // Nuovo schema: array di oggetti {istat, nome, provincia, zona_bollettino, frazioni[]}
                list.forEach((raw) => {
                    if (!raw) return;
                    if (typeof raw === "string") {
                        const nome = raw;
                        const key = `${prov}|${nome}`;
                        if (!COMUNE_META[key]) {
                            COMUNE_META[key] = {
                                istat: null,
                                nome,
                                provincia: prov,
                                zona: null,
                                frazioni: [],
                            };
                        }
                    } else if (typeof raw === "object") {
                        const nome = raw.nome || raw.comune || raw.name;
                        if (!nome) return;
                        const key = `${prov}|${nome}`;
                        COMUNE_META[key] = {
                            istat: raw.istat || null,
                            nome,
                            provincia: raw.provincia || prov,
                            zona: raw.zona_bollettino || raw.zona || null,
                            frazioni: Array.isArray(raw.frazioni) ? raw.frazioni : [],
                        };
                    }
                });
            } else if (list && typeof list === "object") {
                // Vecchio schema: oggetto { "Verona": { ... }, ... }
                Object.entries(list).forEach(([nome, raw]) => {
                    const key = `${prov}|${nome}`;
                    if (typeof raw === "object" && raw !== null) {
                        COMUNE_META[key] = {
                            istat: raw.istat || null,
                            nome,
                            provincia: raw.provincia || prov,
                            zona: raw.zona_bollettino || raw.zona || null,
                            frazioni: Array.isArray(raw.frazioni) ? raw.frazioni : [],
                        };
                    } else {
                        COMUNE_META[key] = {
                            istat: null,
                            nome,
                            provincia: prov,
                            zona: null,
                            frazioni: [],
                        };
                    }
                });
            }
        });
    })();

    /**
     * Elenco comuni per provincia, dai metadati.
     */
    function getComuniByProvincia(code) {
        const names = new Set();
        Object.values(COMUNE_META).forEach((c) => {
            if (c.provincia === code) names.add(c.nome);
        });
        return Array.from(names).sort((a, b) => a.localeCompare(b, "it"));
    }

    /**
     * Metadati di un comune (nome+provincia).
     */
    function getComuneMeta(nomeComune, prov) {
        if (!nomeComune || !prov) return null;
        const key = `${prov}|${nomeComune}`;
        return COMUNE_META[key] || null;
    }

    /**
     * Datalist per comuni + frazioni + zone
     */
    (function buildDatalist() {
        const datalist = $("#comuni-datalist");
        if (!datalist) return;

        const pushOption = (val) => {
            if (!val) return;
            const opt = document.createElement("option");
            opt.value = val;
            datalist.appendChild(opt);
        };

        if (Array.isArray(COMUNI_FLAT_CONFIG) && COMUNI_FLAT_CONFIG.length) {
            COMUNI_FLAT_CONFIG.forEach(pushOption);
            return;
        }

        const seen = new Set();
        Object.values(COMUNE_META).forEach((c) => {
            if (!seen.has(c.nome)) {
                seen.add(c.nome);
                pushOption(c.nome);
            }
            (c.frazioni || []).forEach((fr) => {
                const label = `${fr} (${c.nome})`;
                if (!seen.has(label)) {
                    seen.add(label);
                    pushOption(label);
                }
            });
            if (c.zona && !seen.has(c.zona)) {
                seen.add(c.zona);
                pushOption(c.zona);
            }
        });
    })();

    /* ===== Tipologie evento ===== */
    const TYPES = [
        "sismico", "vulcanico", "idraulico", "idrogeologico", "maremoto",
        "deficit-idrico", "meteo-avverso", "aib", "uomo", "altro",
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

    // espongo TYPE_LABELS per le modali
    window.TYPE_LABELS = TYPE_LABELS;

    /* ===== Helpers di mapping robusto ===== */
    const pick = (obj, ...candidates) => {
        for (const c of candidates) {
            if (typeof c === "string") {
                if (obj && obj[c] != null) return obj[c];
            } else if (Array.isArray(c)) {
                let cur = obj,
                    ok = true;
                for (const k of c) {
                    if (cur && Object.prototype.hasOwnProperty.call(cur, k)) {
                        cur = cur[k];
                    } else {
                        ok = false;
                        break;
                    }
                }
                if (ok && cur != null) return cur;
            }
        }
        return undefined;
    };
    const normalizeISO = (v) => {
        if (!v) return undefined;
        if (typeof v === "number") {
            return (v > 1e12 ? new Date(v) : new Date(v * 1000)).toISOString();
        }
        if (typeof v === "string" && /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/.test(v)) {
            return new Date(v.replace(" ", "T")).toISOString();
        }
        const d = new Date(v);
        if (isNaN(d.getTime())) return undefined;
        return d.toISOString();
    };

    /* ===== Stato app ===== */
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
            ongoingStatus: "all",
            currentEventReports: [],
            evInfoRecord: null,
        },
        _last: {
            genKey: "",
            ongoingKey: ""
        },
    };

    /* ===== Helpers UI ===== */
    function prioClass(p = "Nessuna") {
        const k = (p || "").toLowerCase();
        return k === "alta" ? "prio--alta" : k === "media" ? "prio--media" : k === "bassa" ? "prio--bassa" : "prio--nessuna";
    }

    function makePrioBadge(p = "Nessuna") {
        const s = document.createElement("span");
        s.className = "prio-badge " + prioClass(p);
        s.textContent = p || "Nessuna";
        return s;
    }

    // espongo makePrioBadge
    window.makePrioBadge = makePrioBadge;

    function makeDirBadge(val) {
        const v = (val || "").toString().trim().toUpperCase();
        const isIn = v === "E" || v === "ENTRATA";
        const s = document.createElement("span");
        s.className = "badge " + (isIn ? "badge--in" : "badge--out");
        s.textContent = isIn ? "E" : "U";
        s.title = isIn ? "Entrata" : "Uscita";
        return s;
    }

    // espongo makeDirBadge
    window.makeDirBadge = makeDirBadge;

    function addReadMoreCell(td, fullText, title) {
        const preview = document.createElement("span");
        preview.textContent = truncate(fullText || "");
        const space = document.createTextNode(" ");
        const btn = document.createElement("button");
        btn.type = "button";
        btn.className = "link rm-link";
        btn.textContent = "Mostra di più";
        btn.addEventListener("click", () =>
            window.SORModals?.openReadMore?.(title || "Dettagli", fullText || "")
        );
        td.append(preview, space, btn);
    }

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

    /* ===== API ===== */
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
                try {
                    toast("Errore", `HTTP ${res.status} ${res.statusText}`, "error", 2200);
                } catch {}
                throw new Error(`HTTP ${res.status} ${res.statusText}\n${txt}`);
            }
            if (method !== "GET") {
                document.dispatchEvent(new CustomEvent("api:write:success", {
                    detail: {
                        path,
                        method
                    }
                }));
            }
            const ctype = res.headers.get("content-type") || "";
            return ctype.includes("application/json") ? res.json() : res;
        },
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

    /* ===== Mappers ===== */

    const mapSegToUI = (s = {}) => {
        const created = pick(
            s,
            "creata_il",
            "created_at",
            "createdAt",
            "data_creazione",
            "data"
        );
        const dtISO = normalizeISO(created);

        const evId = pick(
            s,
            "evento_id",
            "event_id",
            "eventId",
            ["evento", "id"],
            ["event", "id"]
        );

        const tipologia = pick(s, "tipologia") || "";
        const tipoCom = pick(s, "tipo") || "";

        const aree = pick(s, "aree", "areas") || [];
        const oggetto = pick(s, "oggetto", "sintesi", "contenuto") || "";
        const sintesi = pick(s, "sintesi", "note", "descrizione") || oggetto;

        return {
            id: pick(s, "id", "uuid"),
            created_at: dtISO,
            direzione: (pick(s, "direzione", "verso") || "E")
                .toString()
                .toUpperCase(),
            tipologia,
            tipo: tipoCom,
            aree,
            sintesi,
            operatore: pick(s, "operatore", "user", "utente", "created_by") || "",
            event_id: evId ? String(evId) : "",
            priorita: pick(s, "priorita", "priority") || "Nessuna",
            ente: pick(s, "ente", "ente_nome", "enteName") || "",
            comune: pick(s, "comune") || "",
            telefono: pick(s, "telefono") || "",
            email: pick(s, "email") || "",
            indirizzo: pick(s, "indirizzo") || "",
            provincia: pick(s, "provincia") || "",
            mitt_dest: pick(s, "mitt_dest", "mittente", "destinatario") || "",
            oggetto,
            contenuto: pick(s, "contenuto", "content", "testo") || "",
        };
    };

    const mapEvToUI = (e = {}) => {
        const updatedRaw = pick(e, "aggiornato_il", "updated_at", "updatedAt", "ultima_comunicazione", "last_report_at", "created_at", "data");
        const updatedISO = normalizeISO(updatedRaw);
        return {
            id: e.id,
            tipo: e.tipologia || e.tipo || "altro",
            descrizione: e.descrizione || "",
            aggiornamento: updatedISO || null,
            operatore: e.operatore || "",
            aree: e.aree || [],
            open: e.aperto ?? e.is_open ?? true,
        };
    };

    const mapComToUI = (c = {}) => {
        const when = pick(c, "comunicata_il", "created_at", "createdAt", "data");
        const iso = normalizeISO(when);
        const dt = iso ? new Date(iso) : null;
        return {
            data: dt ? dt.toLocaleDateString("it-IT") : (c.data || ""),
            ora: dt ? dt.toTimeString().slice(0, 5) : (c.ora || ""),
            tipo: c.tipo || "—",
            verso: c.verso || "Entrata",
            mitt: pick(c, "mitt_dest", "mittente", "destinatario") || "",
            tel: pick(c, "telefono", "phone") || "",
            mail: pick(c, "email", "mail") || "",
            indirizzo: pick(c, "indirizzo", "address") || "",
            provincia: c.provincia || "",
            comune: c.comune || "",
            aree: c.aree || [],
            oggetto: pick(c, "oggetto", "subject") || "",
            priorita: pick(c, "priorita", "priority") || "Nessuna",
            contenuto: pick(c, "contenuto", "content", "testo") || "",
        };
    };

    const mapGenToUI = (s = {}) => {
        let itDate = "",
            itTime = "";
        const created = pick(s, "creata_il", "created_at", "createdAt", "data_creazione", "data");
        if (created) {
            const d = new Date(normalizeISO(created));
            if (!isNaN(d)) {
                itDate = d.toLocaleDateString("it-IT");
                itTime = d.toTimeString().slice(0, 5);
            }
        } else {
            itDate = (s.data || "").toString();
            itTime = (s.ora || "").toString();
        }

        const rawDir = (pick(s, "direzione", "verso") || "E").toString().trim().toUpperCase();
        const direzione = rawDir.startsWith("U") ? "U" : "E";

        const rawTipo = pick(s, "tipologia", "tipo") || "";
        const tipologia = TYPE_LABELS[rawTipo] || rawTipo || "";

        const areeArr = Array.isArray(s.aree) ? s.aree :
            typeof s.aree_text === "string" ? s.aree_text.split(",").map(x => x.trim()).filter(Boolean) : [];
        const areeText = areeArr.join(", ");

        const sintesi = pick(s, "sintesi", "note", "descrizione", "oggetto") || "";

        return {
            id: pick(s, "id", "uuid", "segnalazione_id", "pk"),
            data: itDate,
            ora: itTime,
            direzione,
            tipologia,
            areeText,
            sintesi,
            operatore: pick(s, "operatore", "user", "utente", "created_by") || "",
            priorita: pick(s, "priorita", "priority") || "Nessuna",
        };
    };

    function extractGenericReportsFromEvent(full = {}) {
        const list = pick(full, "segnalazioni", "segnalazioni_generiche", "generic_reports", ["relations", "segnalazioni"]) || [];
        return (Array.isArray(list) ? list : []).map(mapGenToUI);
    }

    /* ===== Loaders ===== */
    async function refreshGEN() {
        try {
            const params = {
                page: state.page.gen,
                per_page: 10,
                q: state.global.q || null,
                date: state.global.date || null,
                time: state.global.time || null,
                comune: $("#gen-filter-comune")?.value || state.global.comune || null,
                dal: $("#gen-filter-dal")?.value || null,
                al: $("#gen-filter-al")?.value || null,
            };
            const res = await API.listSegnalazioni(params);
            const rows = Array.isArray(res) ? res : (res.data || []);
            state.gen = rows.map(mapSegToUI);

            state._last.genKey = JSON.stringify({
                ids: state.gen.map((x) => x.id),
                meta: res.meta
            });
            const cur = res.meta?.current_page ?? 1;
            const last = res.meta?.last_page ?? 1;
            $("#gen-page").textContent = `Pagina ${cur} di ${last}`;
            $("#gen-prev").disabled = cur <= 1;
            $("#gen-next").disabled = cur >= last;

            renderGEN();
        } catch (err) {
            console.error("Errore /segnalazioni:", err);
            state.gen = [];
            renderGEN();
            $("#gen-page").textContent = `Pagina 1 di 1`;
            $("#gen-prev").disabled = true;
            $("#gen-next").disabled = true;
            toast("Errore caricamento segnalazioni", "Il server ha risposto con errore.", "error", 2600);
        }
    }

    async function refreshONGOING() {
        const baseParams = {
            page: state.page.ongoing,
            per_page: 10,
            q: state.global.q || null,
            comune: $("#ongoing-filter-comune")?.value || state.global.comune || null,
            dal: $("#ongoing-filter-dal")?.value || null,
            al: $("#ongoing-filter-al")?.value || null,
        };
        try {
            const res = await API.listEventi(baseParams);
            const rows = Array.isArray(res) ? res : (res.data || []);
            let items = rows.map(mapEvToUI);

            if (state.ui.ongoingStatus === "open") items = items.filter((e) => e.open);
            else if (state.ui.ongoingStatus === "closed") items = items.filter((e) => !e.open);

            state.ongoing = items;
            state._last.ongoingKey = JSON.stringify({
                ids: items.map((x) => x.id),
                meta: res.meta
            });

            const cur = res.meta?.current_page ?? 1;
            const last = res.meta?.last_page ?? 1;
            $("#ongoing-page").textContent = `Pagina ${cur} di ${last}`;
            $("#ongoing-prev").disabled = cur <= 1;
            $("#ongoing-next").disabled = cur >= last;

            renderONGOING();
        } catch (err) {
            console.error("Errore /eventi:", err);
            state.ongoing = [];
            $("#ongoing-page").textContent = `Pagina 1 di 1`;
            $("#ongoing-prev").disabled = true;
            $("#ongoing-next").disabled = true;
            renderONGOING();
            toast("Errore caricamento eventi", "Il server ha risposto con errore.", "error", 2600);
        }
    }

    /* ===== Polling ===== */
    (function setupPolling() {
        let timer = null;
        const INTERVAL = 8000;
        const tick = async () => {
            if (document.hidden) return;
            try {
                await Promise.all([refreshGEN(), refreshONGOING()]);
            } catch {}
        };
        const start = () => {
            if (!timer) timer = setInterval(tick, INTERVAL);
        };
        const stop = () => {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        };
        document.addEventListener("visibilitychange", () => {
            if (document.hidden) stop();
            else {
                tick();
                start();
            }
        });
        window.addEventListener("focus", () => {
            tick();
            start();
        });
        window.addEventListener("blur", stop);
        start();
    })();

    (async function init() {
        await Promise.all([refreshGEN(), refreshONGOING()]);
        if (window.lucide) lucide.createIcons();
    })();

    /* ===== Render SEGNALAZIONI (data/ora separati) ===== */
    function renderGEN() {
        const root = $("#gen-body");
        if (!root) return;
        root.replaceChildren();

        state.gen.forEach((r) => {
            const tr = document.createElement("tr");
            tr.className = "border-t border-slate-200";
            tr.dataset.id = r.id;
            tr.classList.add("prio-row", prioClass(r.priorita));

            let dText = "—",
                tText = "—";
            if (r.created_at) {
                const d = new Date(r.created_at);
                if (!isNaN(d)) {
                    dText = d.toLocaleDateString("it-IT");
                    tText = d.toTimeString().slice(0, 5);
                }
            }

            const tdData = document.createElement("td");
            tdData.className = "px-3 py-2";
            tdData.textContent = dText;

            const tdOra = document.createElement("td");
            tdOra.className = "px-3 py-2";
            tdOra.textContent = tText;

            const tdDir = document.createElement("td");
            tdDir.className = "px-3 py-2";
            tdDir.appendChild(makeDirBadge(r.direzione));

            const tdComune = document.createElement("td");
            tdComune.className = "px-3 py-2";
            tdComune.textContent = r.comune || (r.aree || [])[0] || "—";

            const tdOggetto = document.createElement("td");
            tdOggetto.className = "px-3 py-2 w-sintesi";
            const testoOggetto = r.oggetto || r.sintesi || "";
            tdOggetto.textContent = truncate(testoOggetto);

            const tdEv = document.createElement("td");
            tdEv.className = "px-3 py-2";
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
                    <button class="btn-xs btn-ghost" title="Dettagli"
                        data-action="info" data-type="gen" data-id="${r.id}">ℹ️</button>
                    <button class="btn-xs btn-ghost" title="Modifica"
                        data-action="edit" data-type="gen" data-id="${r.id}">✏️</button>
                    <button class="btn-xs btn-danger" title="Elimina"
                        data-action="del" data-type="gen" data-id="${r.id}">🗑️</button>
                </div>`;

            tr.append(tdData, tdOra, tdDir, tdComune, tdOggetto, tdEv, tdAc);
            root.appendChild(tr);
        });

        if (window.lucide) lucide.createIcons();
    }

    /* ===== Legend + EVENTI ===== */
    function ensureLegend() {
        if ($("#ongoing-legend")) return;
        const legend = document.createElement("div");
        legend.id = "ongoing-legend";
        legend.className = "ongoing-legend";
        legend.innerHTML = TYPES.map(
            (t) => `<span class="ol-item" data-type="${t}"><i class="ol-dot" aria-hidden="true"></i>${TYPE_LABELS[t]}</span>`
        ).join("");
        const cards = $("#ongoing-cards");
        if (!cards || !cards.parentNode) return;
        cards.parentNode.insertBefore(legend, cards);
    }

    function renderONGOING() {
        ensureLegend();
        const root = $("#ongoing-cards");
        if (!root) return;
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
            card.innerHTML = `<div class="ev-card__head">
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

    /* ===== Modale Evento ===== */
    async function openEventModal(eventId) {
        state.ui.currentEventId = eventId;
        const full = await API.getEvento(eventId);
        const ev = mapEvToUI(full);

        const commsRaw = pick(full, "comunicazioni", "reports") || [];
        ev.reports = (Array.isArray(commsRaw) ? commsRaw : []).map(mapComToUI);
        state.ui.currentEventReports = ev.reports.slice();

        ev.genericReports = extractGenericReportsFromEvent(full);

        $("#ev-title").textContent = ev.descrizione || "—";
        const subtitle = $("#ev-subtitle");
        if (subtitle) {
            subtitle.textContent = "";
            const whenTxt = ev.aggiornamento ? fmtDT(new Date(ev.aggiornamento)) : "—";
            subtitle.textContent = `${TYPE_LABELS[ev.tipo] || ev.tipo} • Ultimo agg.: ${whenTxt} `;
            const st = document.createElement("span");
            st.className = `ev-inline-status ${ev.open !== false ? "is-open" : "is-closed"}`;
            st.textContent = ev.open !== false ? "Aperto" : "Chiuso";
            subtitle.appendChild(st);
        }

        renderEventAreas(ev);
        renderEventReports(ev);
        renderGenericReports(ev);
        resetEvForm(ev.tipo, ev.aree);
        updateEventStatusUI(ev);
        const evIdInput = $("#ev-id");
        if (evIdInput) evIdInput.value = ev.id;

        window.SORModals?.openModal?.("#modal-event");

        console.debug("Evento", ev.id, {
            genericReportsCount: ev.genericReports.length,
            sampleGeneric: ev.genericReports[0],
        });
    }

    function renderEventAreas(ev) {
        const wrap = $("#ev-areas");
        if (!wrap) return;
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
        if (!tbody) return;
        tbody.replaceChildren();

        const rows = (ev.reports || []).map((r, idx) => ({
            ...r,
            _idx: idx
        }));

        if (!rows.length) {
            const tr = document.createElement("tr");
            const td = document.createElement("td");
            td.colSpan = 5;
            td.className = "px-3 py-3 opacity-70";
            td.textContent = "Nessuna segnalazione.";
            tr.appendChild(td);
            tbody.appendChild(tr);
            return;
        }

        rows.forEach((r) => {
            const tr = document.createElement("tr");
            tr.className = "border-t border-slate-200";
            tr.classList.add("prio-row", prioClass(r.priorita));
            tr.dataset.idx = r._idx;

            const tdData = Object.assign(document.createElement("td"), {
                className: "px-3 py-2",
                textContent: r.data || ""
            });

            const tdOra = Object.assign(document.createElement("td"), {
                className: "px-3 py-2",
                textContent: r.ora || ""
            });

            const tdVerso = document.createElement("td");
            tdVerso.className = "px-3 py-2";
            const raw = (r.verso || "").trim().toUpperCase();
            const dir = raw.startsWith("U") ? "U" : "E";
            tdVerso.appendChild(makeDirBadge(dir));

            const tdOggetto = document.createElement("td");
            tdOggetto.className = "px-3 py-2 w-sintesi";
            tdOggetto.textContent = truncate(r.oggetto || "");

            const tdAc = document.createElement("td");
            tdAc.className = "px-3 py-2";
            tdAc.innerHTML = `
            <div class="actions">
                <button class="btn-xs btn-ghost" title="Dettagli"
                    data-action="ev-info" data-idx="${r._idx}">ℹ️</button>
                <button class="btn-xs btn-ghost" title="Modifica"
                    data-action="ev-edit" data-idx="${r._idx}">✏️</button>
            </div>`;

            tr.append(tdData, tdOra, tdVerso, tdOggetto, tdAc);
            tbody.appendChild(tr);
        });
    }

    function ensureGenericSection() {
        let sec = document.getElementById("ev-gen-sec");
        if (sec) return sec;
        const parent = $("#ev-body");
        if (!parent) return null;
        sec = document.createElement("section");
        sec.id = "ev-gen-sec";
        sec.className = "rounded-2xl border border-slate-200 bg-white p-4";
        sec.innerHTML = `
      <h4 class="text-sm font-semibold mb-3">Segnalazioni generiche collegate</h4>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="text-left">
            <tr>
              <th class="px-3 py-2">Data</th>
              <th class="px-3 py-2">Ora</th>
              <th class="px-3 py-2">E/U</th>
              <th class="px-3 py-2 w-sintesi">Oggetto</th>
              <th class="px-3 py-2">Azioni</th>
            </tr>
          </thead>
          <tbody id="ev-gen-tbody">
            <tr>
              <td colspan="5" class="px-3 py-3 opacity-70">
                Nessuna segnalazione generica collegata.
              </td>
            </tr>
          </tbody>
        </table>
      </div>`;
        parent.appendChild(sec);
        return sec;
    }

    function renderGenericReports(ev) {
        const sec = ensureGenericSection();
        if (!sec) return;
        const tbody = $("#ev-gen-tbody");
        if (!tbody) return;
        tbody.replaceChildren();

        const rows = ev.genericReports || [];
        if (!rows.length) {
            const tr = document.createElement("tr");
            tr.innerHTML = `
          <td colspan="5" class="px-3 py-3 opacity-70">
            Nessuna segnalazione generica collegata.
          </td>`;
            tbody.appendChild(tr);
            return;
        }

        rows.forEach((r) => {
            const tr = document.createElement("tr");
            tr.className = "border-t border-slate-200";
            tr.classList.add("prio-row", prioClass(r.priorita));
            tr.dataset.id = r.id;

            const tdData = Object.assign(document.createElement("td"), {
                className: "px-3 py-2",
                textContent: r.data || ""
            });

            const tdOra = Object.assign(document.createElement("td"), {
                className: "px-3 py-2",
                textContent: r.ora || ""
            });

            const tdDir = document.createElement("td");
            tdDir.className = "px-3 py-2";
            tdDir.appendChild(makeDirBadge(r.direzione));

            const tdOggetto = document.createElement("td");
            tdOggetto.className = "px-3 py-2 w-sintesi";
            const fullText = r.oggetto || r.sintesi || "";
            tdOggetto.textContent = truncate(fullText);

            const tdAz = document.createElement("td");
            tdAz.className = "px-3 py-2";
            tdAz.innerHTML = `
          <div class="actions">
            <button class="btn-xs btn-ghost"
                    title="Dettagli segnalazione generica"
                    data-action="info" data-type="gen" data-id="${r.id}">
              ℹ️
            </button>
          </div>`;

            tr.append(tdData, tdOra, tdDir, tdOggetto, tdAz);
            tbody.appendChild(tr);
        });
    }

    function resetEvForm(type, areas) {
        const idxInput = $("#ev-edit-index");
        if (idxInput) idxInput.value = "";
        const form = $("#ev-form");
        form?.reset?.();
        const { date, time } = nowIT();
        const fData = $("#f-data");
        const fOra = $("#f-ora");
        if (fData) fData.value = date;
        if (fOra) fOra.value = time;
        if (evAreeInput && evAreeInput.setValues) {
            evAreeInput.setValues(areas || []);
        }
        const versoRadio = document.querySelector('input[name="f-verso"][value="Entrata"]');
        if (versoRadio) versoRadio.checked = true;

        const container = $("#ev-specific");
        if (container) {
            container.innerHTML = "";
            const hint = document.createElement("div");
            hint.className = "text-xs opacity-70";
            hint.textContent = `Tipologia evento: ${TYPE_LABELS[type] || type || "—"}. Aggiungi eventuali dettagli nella comunicazione`;
            container.appendChild(hint);
        }

        populateProvinceSelect("", "f-");
        const comuneSel = $("#f-comune");
        if (comuneSel) {
            comuneSel.innerHTML = `<option value="">Prima seleziona una provincia...</option>`;
            comuneSel.disabled = true;
        }
    }

    function loadReportIntoForm(idx) {
        const list = state.ui.currentEventReports || [];
        const r = list[Number(idx)];
        if (!r) return;

        const idxInput = $("#ev-edit-index");
        if (idxInput) idxInput.value = idx;
        $("#f-data").value = r.data || "";
        $("#f-ora").value = r.ora || "";
        $("#f-tipo").value = r.tipo || "";

        const rawVerso = (r.verso || "").toString().toUpperCase();
        const verso = rawVerso.startsWith("U") ? "Uscita" : "Entrata";
        const radio = document.querySelector(`input[name="f-verso"][value="${verso}"]`);
        if (radio) radio.checked = true;

        $("#f-mitt").value = r.mitt || "";
        $("#f-tel").value = r.tel || "";
        $("#f-mail").value = r.mail || "";
        $("#f-indirizzo").value = r.indirizzo || "";
        $("#f-oggetto").value = r.oggetto || "";
        $("#f-contenuto").value = r.contenuto || "";

        populateProvinceSelect(r.provincia || "", "f-");
        populateComuniSelect(r.provincia || "", r.comune || "", "f-");

        if (evAreeInput && evAreeInput.setValues) {
            evAreeInput.setValues(r.aree || []);
        }
        const prioRadio = document.querySelector(`input[name="f-priorita"][value="${r.priorita || "Nessuna"}"]`);
        prioRadio?.click?.();
    }

    /* ===== Province & Comuni ===== */

    function populateProvinceSelect(selected = "", prefix = "f-") {
        const sel = document.getElementById(prefix + "provincia");
        if (!sel) return;

        sel.innerHTML = "";
        sel.add(new Option("Tutte le province...", ""));

        if (Array.isArray(PROVINCE)) {
            // es: [{sigla: 'BL', nome: 'Belluno'}, ...]
            PROVINCE.forEach((p) => {
                if (!p) return;
                const code = p.sigla || p.codice || p.code || p;
                const label = p.nome || p.name || code;
                if (!code) return;
                sel.add(new Option(label, code));
            });
        } else {
            // es: { BL: 'Belluno', PD: 'Padova', ... }
            Object.entries(PROVINCE).forEach(([code, label]) => {
                sel.add(new Option(label || code, code));
            });
        }

        sel.value = selected || "";
        const comuneSel = document.getElementById(prefix + "comune");
        if (comuneSel) {
            comuneSel.disabled = !sel.value;
        }
    }

    function populateComuniSelect(prov, selected = "", prefix = "f-") {
        const comuneSel = document.getElementById(prefix + "comune");
        if (!comuneSel) return;
        comuneSel.innerHTML = "";
        if (!prov) {
            comuneSel.add(new Option("Prima seleziona una provincia...", ""));
            comuneSel.disabled = true;
            return;
        }
        const comuni = getComuniByProvincia(prov);
        comuni.forEach((c) => comuneSel.add(new Option(c, c)));
        comuneSel.disabled = false;
        comuneSel.value = selected || "";
    }

    $("#f-provincia")?.addEventListener("change", (e) =>
        populateComuniSelect(e.target.value, "", "f-")
    );
    $("#g-provincia")?.addEventListener("change", (e) =>
        populateComuniSelect(e.target.value, "", "g-")
    );

    /* ===== Reset forms ===== */
    document.getElementById("form-gen")?.addEventListener("reset", () => {
        if (genAree && genAree.setValues) genAree.setValues([]);
        const tipSel = $("#gen-tipologia");
        if (tipSel) tipSel.value = "";
        const spec = $("#gen-specific");
        if (spec) spec.innerHTML = "";
        const sel = $("#gen-event-select");
        if (sel) {
            sel.value = "";
            renderEvPreview("", sel);
        }
        const hid = $("#gen-aree-hidden");
        if (hid) hid.value = "[]";
    });
    document.getElementById("form-edit-gen")?.addEventListener("reset", (e) => {
        const form = e.currentTarget;
        try {
            const initial = JSON.parse(form.dataset.initialAree || "[]");
            if (editAree && editAree.setValues) {
                editAree.setValues(initial);
                const hid = $("#edit-aree-hidden");
                if (hid) hid.value = JSON.stringify(initial);
            }
        } catch {
            if (editAree) editAree.setValues([]);
        }
        renderEvPreview($("#edit-gen-event")?.value, $("#edit-gen-event"));
    });
    document.getElementById("ev-form")?.addEventListener("reset", () => {
        if (evAreeInput && evAreeInput.setValues) evAreeInput.setValues([]);
    });

    /* ===== Inizializzazione specifica modale GEN ===== */
    function initGenModal() {
        populateEventSelect($("#gen-event-select"), "", true);
        renderEvPreview($("#gen-event-select")?.value, $("#gen-event-select"));

        const { date, time } = nowIT();
        const gData = $("#g-data");
        const gOra = $("#g-ora");
        if (gData) gData.value = date;
        if (gOra) gOra.value = time;

        const tipSel = $("#gen-tipologia");
        if (tipSel) tipSel.value = "";
        renderSpecific($("#gen-specific"), "", "gensp");

        populateProvinceSelect("", "g-");
    }

    // intercetto click sul bottone "Nuova segnalazione generica"
    document.querySelectorAll('[data-open-modal="#modal-gen"]').forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            initGenModal();
            window.SORModals?.openModal?.("#modal-gen");
        });
    });

    /* ===== Click handler globale (solo azioni app, NON modali base) ===== */
    document.addEventListener("click", (e) => {
        const evBtn = e.target.closest("[data-open-event]");
        if (evBtn) {
            const id = +evBtn.dataset.openEvent;
            if (!Number.isNaN(id)) {
                const allModal = $("#modal-all-reports");
                if (allModal && allModal.classList.contains("is-open")) {
                    window.SORModals?.closeModal?.(allModal);
                }
                openEventModal(id);
            }
            return;
        }

        const btn = e.target.closest("[data-action]");
        if (btn) {
            const {
                action,
                type,
                id,
                idx
            } = btn.dataset;

            // Azioni segnalazioni generiche
            if (type === "gen") {
                if (action === "info") {
                    const item = state.gen.find((x) => String(x.id) === String(id));
                    if (!item) return;
                    if (window.SORModals?.showGenInfo) {
                        window.SORModals.showGenInfo(item);
                    }
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
                    renderEvPreview($("#edit-gen-event")?.value, $("#edit-gen-event"));
                    if (editAree && editAree.setValues) {
                        editAree.setValues(item.aree || []);
                        $("#form-edit-gen").dataset.initialAree = JSON.stringify(item.aree || []);
                    }
                    window.SORModals?.openModal?.("#modal-edit-gen");
                    return;
                }
                if (action === "del") {
                    confirmDelete().then(async (res) => {
                        if (!res.isConfirmed) return;
                        await API.deleteSegnalazione(id);
                        await Promise.all([refreshGEN(), refreshONGOING()]);
                        toast("Eliminata!", "Rimossa dal backend.", "success");
                    });
                    return;
                }
            }

            // Azioni comunicazioni evento
            if (action === "ev-info") {
                const list = state.ui.currentEventReports || [];
                const r = list[Number(idx)];
                if (!r) return;
                if (window.SORModals?.showEvInfo) {
                    window.SORModals.showEvInfo({
                        ...r,
                        event_id: state.ui.currentEventId || null,
                    });
                }
                return;
            }
            if (action === "ev-edit") {
                loadReportIntoForm(idx);
                window.SORModals?.openModal?.("#modal-ev-form");
                const btnSave = $("#ev-save");
                if (btnSave) btnSave.textContent = "Salva modifiche";
                return;
            }
        }
    });

    $("#ev-open-form")?.addEventListener("click", () => {
        const btnSave = $("#ev-save");
        if (btnSave) btnSave.textContent = "💾 Salva Comunicazione";
        resetEvForm("altro", []);
        window.SORModals?.openModal?.("#modal-ev-form");
    });

    /* ===== Paginazione ===== */
    $("#gen-prev")?.addEventListener("click", async () => {
        state.page.gen = Math.max(1, state.page.gen - 1);
        await refreshGEN();
    });
    $("#gen-next")?.addEventListener("click", async () => {
        state.page.gen += 1;
        await refreshGEN();
    });
    $("#ongoing-prev")?.addEventListener("click", async () => {
        state.page.ongoing = Math.max(1, state.page.ongoing - 1);
        await refreshONGOING();
    });
    $("#ongoing-next")?.addEventListener("click", async () => {
        state.page.ongoing = Math.max(1, state.page.ongoing + 1);
        await refreshONGOING();
    });

    $("#ev-toggle-open")?.addEventListener("click", async () => {
        const id = state.ui.currentEventId;
        if (!id) return;
        await API.toggleEvento(id);
        await refreshONGOING();
        const full = await API.getEvento(id);
        updateEventStatusUI(mapEvToUI(full));
        toast("Stato evento aggiornato", "", "info", 1400);
    });

    $("#gen-event-select")?.addEventListener("change", (e) => {
        renderEvPreview(e.target.value, e.target);
    });
    $("#edit-gen-event")?.addEventListener("change", (e) => {
        renderEvPreview(e.target.value, e.target);
    });

    function fillForm(form, obj) {
        if (!form) return;
        for (const el of form.elements) {
            if (!el.name) continue;
            const v = obj[el.name];
            if (el.type === "datetime-local") el.value = v ? v.slice(0, 16) : "";
            else if (el.type === "checkbox") el.checked = !!v;
            else el.value = v ?? "";
        }
    }

    /* ===== CREATE Segnalazione GENERICA ===== */
    $("#form-gen")?.addEventListener("submit", async (e) => {
        e.preventDefault();

        const tipologia = $("#gen-tipologia")?.value || "altro";
        const priorita =
            document.querySelector('input[name="priorita"]:checked')?.value || "Nessuna";
        const aree = genAree && genAree.values ? genAree.values.slice() : [];
        const chosenEvent = $("#gen-event-select")?.value;

        const d = $("#g-data")?.value.trim() || nowIT().date;
        const t = $("#g-ora")?.value.trim() || nowIT().time;
        const dt = parseIT(d, t);
        const creata_il = dt.toISOString();

        const dirVal = document.querySelector('input[name="g-verso"]:checked')?.value || "E";
        const direzione = dirVal === "U" ? "U" : "E";

        const tipoCom = $("#g-tipo")?.value || "";
        const mitt = $("#g-mitt")?.value.trim() || "";
        const tel = $("#g-tel")?.value.trim() || "";
        const mail = $("#g-mail")?.value.trim() || "";
        const indirizzo = $("#g-indirizzo")?.value.trim() || "";
        const provincia = $("#g-provincia")?.value || "";
        const comune = $("#g-comune")?.value || "";
        const oggetto = $("#g-oggetto")?.value.trim() || "";
        const contenuto = $("#g-contenuto")?.value.trim() || "";

        const sintesi = oggetto || contenuto || "";

        const campi_specifici = {};
        $("#gen-specific")
            ?.querySelectorAll("input, textarea, select")
            .forEach((el) => {
                const id = el.id || "";
                if (!id.startsWith("gensp-")) return;
                const key = id.replace(/^gensp-/, "");
                const val = el.value.trim();
                if (val) campi_specifici[key] = val;
            });

        let evento_id = null;
        if (chosenEvent === "__new__") {
            const evRes = await API.createEvento({
                tipologia,
                descrizione: oggetto || `Evento ${TYPE_LABELS[tipologia] || tipologia}`,
                aree,
                aperto: true,
            });

            const newEvId = evRes?.id ?? evRes?.data?.id;
            if (!newEvId) {
                console.error("createEvento: risposta senza id", evRes);
                toast("Errore creazione evento", "Il server non ha restituito l'ID dell'evento.", "error", 2600);
            } else {
                evento_id = newEvId;
            }
        } else if (chosenEvent) {
            evento_id = Number(chosenEvent);
        }

        const payload = {
            creata_il,
            direzione,
            tipologia,
            tipo: tipoCom,
            aree,
            sintesi,
            priorita,

            mitt_dest: mitt,
            telefono: tel,
            email: mail,
            indirizzo,
            provincia,
            comune,
            oggetto,
            contenuto,
            campi_specifici,

            event_id: evento_id,
            evento_id: evento_id,
        };

        await API.createSegnalazione(payload);
        await Promise.all([refreshGEN(), refreshONGOING()]);

        e.currentTarget.reset();
        if (genAree && genAree.setValues) genAree.setValues([]);
        const spec = $("#gen-specific");
        if (spec) spec.innerHTML = "";
        toast("Segnalazione aggiunta!", "Salvata su backend.");
    });

    $("#gen-tipologia")?.addEventListener("change", () => {
        const t = $("#gen-tipologia")?.value || "";
        renderSpecific($("#gen-specific"), t, "gensp");
    });

    /* ===== EDIT Segnalazione ===== */
    $("#form-edit-gen")?.addEventListener("submit", async (e) => {
        e.preventDefault();
        const fd = Object.fromEntries(new FormData(e.currentTarget).entries());
        const id = fd.id;
        let evento_id = (fd.event_id || "").trim() || null;

        if (evento_id === "__new__") {
            const base = state.gen.find((x) => String(x.id) === String(id));
            const evRes = await API.createEvento({
                tipologia: base?.tipologia || "altro",
                descrizione: fd.sintesi || base?.sintesi || "Evento",
                aree: editAree && editAree.values ? editAree.values.slice() : [],
                aperto: true,
            });

            const newEvId = evRes?.id ?? evRes?.data?.id;
            if (!newEvId) {
                console.error("createEvento (edit): risposta senza id", evRes);
                toast("Errore creazione evento", "Impossibile recuperare l'ID del nuovo evento.", "error", 2600);
            } else {
                evento_id = newEvId;

                await API.addComunicazione(newEvId, {
                    comunicata_il: new Date().toISOString(),
                    tipo: "—",
                    verso: (fd.direzione || "E").toUpperCase() === "U" ? "Uscita" : "Entrata",
                    aree: editAree && editAree.values ? editAree.values.slice() : [],
                    oggetto: fd.sintesi || base?.sintesi || "",
                    contenuto: fd.sintesi || base?.sintesi || "",
                    priorita: fd.priorita || "Nessuna",
                });
            }
        }

        const payload = {
            direzione: fd.direzione,
            aree: editAree && editAree.values ? editAree.values.slice() : [],
            sintesi: fd.sintesi,
            operatore: fd.operatore,
            priorita: fd.priorita,
            event_id: evento_id ? Number(evento_id) : null,
            evento_id: evento_id ? Number(evento_id) : null,
        };
        if (fd.created_at) payload.creata_il = new Date(fd.created_at).toISOString();

        await API.updateSegnalazione(id, payload);
        await Promise.all([refreshGEN(), refreshONGOING()]);
        toast("Modifica salvata!", "Aggiornata su backend.");
    });

    /* ===== SAVE Comunicazione evento ===== */
    $("#ev-form")?.addEventListener("submit", async (e) => {
        e.preventDefault();
        const id = state.ui.currentEventId;
        if (!id) return;
        const d = $("#f-data")?.value.trim();
        const t = $("#f-ora")?.value.trim();
        const iso = d && t ? parseIT(d, t).toISOString() : null;
        const payload = {
            comunicata_il: iso,
            tipo: $("#f-tipo")?.value || "—",
            verso: document.querySelector('input[name="f-verso"]:checked')?.value || "Entrata",
            mitt_dest: $("#f-mitt")?.value.trim() || "",
            telefono: $("#f-tel")?.value.trim() || "",
            email: $("#f-mail")?.value.trim() || "",
            indirizzo: $("#f-indirizzo")?.value.trim() || "",
            provincia: $("#f-provincia")?.value || "",
            comune: $("#f-comune")?.value || "",
            aree: evAreeInput && evAreeInput.values ? evAreeInput.values.slice() : [],
            oggetto: $("#f-oggetto")?.value.trim() || "",
            contenuto: $("#f-contenuto")?.value.trim() || "",
            priorita: document.querySelector('input[name="f-priorita"]:checked')?.value || "Nessuna",
        };
        await API.addComunicazione(id, payload);

        await refreshONGOING();
        await openEventModal(id);
        toast("Comunicazione salvata!", "Registrata su backend.");
    });

    /* ===== Aree evento (solo UI) ===== */
    $("#ev-areas-edit")?.addEventListener("click", () => {
        if (!window.Swal) return;
        Swal.fire({
            title: "Modifica Aree interessate",
            html: `<div class="tag-input" id="swal-areas" data-datalist="comuni-datalist"></div>`,
            didOpen: () => {
                const root = Swal.getHtmlContainer().querySelector("#swal-areas");
                const ti = new TagInput(root, {
                    datalistId: "comuni-datalist"
                });
                ti?.setValues?.([]);
                root.addEventListener("change", (e) => {
                    root.dataset.values = JSON.stringify(e.detail || []);
                });
            },
            showCancelButton: true,
            confirmButtonText: "Chiudi",
            cancelButtonText: "Annulla",
        });
    });

    /* ===== MODALE: tutte le comunicazioni con top 5 eventi ===== */
    $("#ongoing-all-reports")?.addEventListener("click", () => {
        openAllReportsModal();
    });

    async function openAllReportsModal() {
        const modalId = "#modal-all-reports";
        const topWrap = $("#all-reports-top");
        const tbody = $("#all-reports-tbody");

        window.SORModals?.openModal?.(modalId);

        if (!topWrap || !tbody) {
            return;
        }

        topWrap.replaceChildren();
        tbody.replaceChildren();

        const events = state.ongoing
            .slice()
            .sort((a, b) => {
                const da = a.aggiornamento ? new Date(a.aggiornamento).getTime() : 0;
                const db = b.aggiornamento ? new Date(b.aggiornamento).getTime() : 0;
                return db - da;
            });

        const topFive = events.slice(0, 5);

        if (!topFive.length) {
            const empty = document.createElement("div");
            empty.className = "text-sm opacity-70";
            empty.textContent = "Nessun evento in atto.";
            topWrap.appendChild(empty);
        } else {
            topFive.forEach((ev) => {
                const typeKey = TYPES.includes(ev.tipo) ? ev.tipo : "altro";
                const typeLabel = TYPE_LABELS[typeKey] || ev.tipo;
                const when = ev.aggiornamento ? fmtDT(new Date(ev.aggiornamento)) : "—";
                const aree = (ev.aree || []).join(", ") || "—";

                const card = document.createElement("article");
                card.className = "ev-card ev-card--compact cursor-pointer";
                card.dataset.openEvent = ev.id;
                card.innerHTML = `
                <div class="ev-card__head">
                    <h4 class="ev-card__title">${ev.descrizione || "Evento"}</h4>
                    <div class="ev-card__chips">
                        <span class="ev-card__status ${ev.open !== false ? "is-open" : "is-closed"}">
                            ${ev.open !== false ? "Aperto" : "Chiuso"}
                        </span>
                        <span class="ev-card__badge">${typeLabel}</span>
                    </div>
                </div>
                <ul class="ev-card__meta">
                    <li><strong>Ultimo agg.:</strong> ${when}</li>
                    <li><strong>Aree:</strong> ${aree}</li>
                </ul>
            `;
                topWrap.appendChild(card);
            });
        }

        const loadingRow = document.createElement("tr");
        loadingRow.innerHTML =
            `<td colspan="7" class="px-3 py-3 opacity-70">Caricamento comunicazioni...</td>`;
        tbody.appendChild(loadingRow);

        const allRows = [];

        for (const ev of events) {
            try {
                const full = await API.getEvento(ev.id);
                const mapped = mapEvToUI(full);
                const evLabel = mapped.descrizione || `Evento #${ev.id}`;
                const evTypeLabel = TYPE_LABELS[mapped.tipo] || mapped.tipo;

                const commsRaw = pick(full, "comunicazioni", "reports") || [];
                const comms = (Array.isArray(commsRaw) ? commsRaw : []).map(mapComToUI);

                comms.forEach((c) => {
                    allRows.push({
                        kind: "com",
                        evId: ev.id,
                        evLabel,
                        evTypeLabel,
                        data: c.data || "",
                        ora: c.ora || "",
                        verso: c.verso || "Entrata",
                        comune: c.comune || "",
                        oggetto: c.oggetto || "",
                    });
                });

                const gens = extractGenericReportsFromEvent(full);
                gens.forEach((g) => {
                    allRows.push({
                        kind: "gen",
                        evId: ev.id,
                        evLabel,
                        evTypeLabel,
                        data: g.data || "",
                        ora: g.ora || "",
                        verso: (g.direzione || "E").toUpperCase() === "U" ? "Uscita" : "Entrata",
                        comune: g.comune || "",
                        oggetto: g.oggetto || g.sintesi || "",
                    });
                });
            } catch (err) {
                console.error("Errore getEvento per all-reports", ev.id, err);
            }
        }

        tbody.replaceChildren();

        if (!allRows.length) {
            const tr = document.createElement("tr");
            tr.innerHTML = `<td colspan="7" class="px-3 py-3 opacity-70">
            Nessuna comunicazione disponibile per gli eventi in atto.
        </td>`;
            tbody.appendChild(tr);
            return;
        }

        allRows.sort((a, b) => {
            const dA = parseIT(a.data, a.ora);
            const dB = parseIT(b.data, b.ora);
            const tA = isNaN(dA.getTime()) ? 0 : dA.getTime();
            const tB = isNaN(dB.getTime()) ? 0 : dB.getTime();
            return tB - tA;
        });

        allRows.forEach((row) => {
            const tr = document.createElement("tr");
            tr.className = "border-t border-slate-200";

            const dirBadge = makeDirBadge(
                (row.verso || "").toString().toUpperCase().startsWith("U") ? "U" : "E"
            );

            const tdData = document.createElement("td");
            tdData.className = "px-3 py-2";
            tdData.textContent = row.data || "";

            const tdOra = document.createElement("td");
            tdOra.className = "px-3 py-2";
            tdOra.textContent = row.ora || "";

            const tdDir = document.createElement("td");
            tdDir.className = "px-3 py-2";
            tdDir.appendChild(dirBadge);

            const tdComune = document.createElement("td");
            tdComune.className = "px-3 py-2";
            tdComune.textContent = row.comune || "—";

            const tdOggetto = document.createElement("td");
            tdOggetto.className = "px-3 py-2 w-sintesi";
            tdOggetto.textContent = truncate(row.oggetto || "");

            const tdEvento = document.createElement("td");
            tdEvento.className = "px-3 py-2";
            tdEvento.innerHTML = `
            <button type="button" class="link" data-open-event="${row.evId}">
                ${row.evLabel}
            </button>
        `;

            const tdAzioni = document.createElement("td");
            tdAzioni.className = "px-3 py-2";
            tdAzioni.innerHTML = `
            <div class="actions">
                <button type="button" class="btn-xs btn-ghost" data-open-event="${row.evId}">
                    ℹ️
                </button>
            </div>
        `;

            tr.append(tdData, tdOra, tdDir, tdComune, tdOggetto, tdEvento, tdAzioni);
            tbody.appendChild(tr);
        });
    }

    function appendQuery(url, obj) {
        Object.entries(obj).forEach(([k, v]) => {
            if (v !== null && v !== undefined && v !== "") url.searchParams.set(k, v);
        });
    }
    $("#gen-export")?.addEventListener("click", () => {
        const url = new URL(API.base + "/segnalazioni/export.csv", location.origin);
        appendQuery(url, {
            page: state.page.gen,
            per_page: 10,
            q: state.global.q || null,
            date: state.global.date || null,
            time: state.global.time || null,
            comune: $("#gen-filter-comune")?.value || state.global.comune || null,
            dal: $("#gen-filter-dal")?.value || null,
            al: $("#gen-filter-al")?.value || null,
        });
        location.href = url.toString();
    });
    $("#ongoing-export")?.addEventListener("click", () => {
        const url = new URL(API.base + "/eventi/export.csv", location.origin);
        appendQuery(url, {
            page: state.page.ongoing,
            per_page: 10,
            q: state.global.q || null,
            comune: $("#ongoing-filter-comune")?.value || state.global.comune || null,
            dal: $("#ongoing-filter-dal")?.value || null,
            al: $("#ongoing-filter-al")?.value || null,
        });
        location.href = url.toString();
    });
    $("#ev-export")?.addEventListener("click", () => {
        const id = state.ui.currentEventId;
        if (!id) return;
        const url = new URL(API.base + `/eventi/${id}/export.csv`, location.origin);
        location.href = url.toString();
    });
    $("#ev-print")?.addEventListener("click", () => {
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

    /* ===== TagInput istanze ===== */
    let genAree, editAree, evAreeInput;

    const genAreeRoot = $("#gen-aree");
    if (genAreeRoot) {
        genAree = new TagInput(genAreeRoot, { datalistId: "comuni-datalist" });
    }

    const editAreeRoot = $("#edit-aree");
    if (editAreeRoot) {
        editAree = new TagInput(editAreeRoot, { datalistId: "comuni-datalist" });
    }

    const evAreeRoot = $("#ev-aree-input");
    if (evAreeRoot) {
        evAreeInput = new TagInput(evAreeRoot, { datalistId: "comuni-datalist" });
    }

    $("#gen-aree")?.addEventListener("change", (e) => {
        const hid = $("#gen-aree-hidden");
        if (hid) hid.value = JSON.stringify(e.detail || []);
    });
    $("#edit-aree")?.addEventListener("change", (e) => {
        const hid = $("#edit-aree-hidden");
        if (hid) hid.value = JSON.stringify(e.detail || []);
    });

    /* ===== Auto-set area da comune (zona bollettino) ===== */
    function maybeAddZonaToAree(tagInputInstance, provSelId, comuneSelId) {
        const prov = $(provSelId)?.value;
        const comune = $(comuneSelId)?.value;
        if (!prov || !comune || !tagInputInstance || !tagInputInstance.add) return;

        const meta = getComuneMeta(comune, prov);
        const zona = meta?.zona;
        if (!zona) return;

        if (!tagInputInstance.values.includes(zona)) {
            tagInputInstance.add(zona);
        }
    }

    $("#g-comune")?.addEventListener("change", () => {
        maybeAddZonaToAree(genAree, "#g-provincia", "#g-comune");
    });

    $("#f-comune")?.addEventListener("change", () => {
        maybeAddZonaToAree(evAreeInput, "#f-provincia", "#f-comune");
    });

    /* ===== Filtri ===== */
    ["#gen-filter-comune", "#gen-filter-dal", "#gen-filter-al"].forEach((s) =>
        $(s)?.addEventListener("input", async () => {
            state.page.gen = 1;
            await refreshGEN();
        })
    );
    ["#ongoing-filter-comune", "#ongoing-filter-dal", "#ongoing-filter-al"].forEach((s) =>
        $(s)?.addEventListener("input", async () => {
            state.page.ongoing = 1;
            await refreshONGOING();
        })
    );
    ["#global-q", "#global-date", "#global-time", "#global-comune"].forEach((sel) => {
        $(sel)?.addEventListener("input", async () => {
            state.global.q = $("#global-q")?.value.trim() || "";
            state.global.date = $("#global-date")?.value || "";
            state.global.time = $("#global-time")?.value || "";
            state.global.comune = $("#global-comune")?.value.trim() || "";
            state.page = {
                ...state.page,
                gen: 1,
                ongoing: 1
            };
            await Promise.all([refreshGEN(), refreshONGOING()]);
        });
    });

    const toggleBtn = $("#ongoing-toggle-status");

    function updateToggleBtn() {
        if (!toggleBtn) return;
        toggleBtn.textContent =
            state.ui.ongoingStatus === "all" ?
                "Tutti" :
                state.ui.ongoingStatus === "open" ?
                    "Solo aperti" :
                    "Solo chiusi";
        toggleBtn.title = toggleBtn.textContent;
    }
    if (toggleBtn) {
        updateToggleBtn();
        toggleBtn.addEventListener("click", async () => {
            state.ui.ongoingStatus =
                state.ui.ongoingStatus === "all" ?
                    "open" :
                    state.ui.ongoingStatus === "open" ?
                        "closed" :
                        "all";
            state.page.ongoing = 1;
            updateToggleBtn();
            await refreshONGOING();
        });
    }

    function ensureEvPreviewBox(afterEl, boxId) {
        if (!afterEl || !afterEl.parentElement) return null;
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
        if (!mountEl) return;
        const box = ensureEvPreviewBox(mountEl, mountEl.id + "-preview");
        if (!box) return;
        box.replaceChildren();
        const head = document.createElement("div");
        head.className = "ev-preview__head";
        head.innerHTML = `<h5 class="ev-preview__title">Comunicazioni evento</h5><div class="ev-preview__meta text-xs opacity-70"></div>`;
        box.appendChild(head);
        if (!evId || evId === "__new__") {
            const div = document.createElement("div");
            div.className = "ev-preview__empty";
            div.textContent = "Nessun evento selezionato. Se scegli “Crea nuovo evento”, questa segnalazione diventerà la prima comunicazione.";
            box.appendChild(div);
            return;
        }
        const ev = state.ongoing.find((e) => String(e.id) === String(evId));
        if (!ev) {
            const div = document.createElement("div");
            div.className = "ev-preview__empty";
            div.textContent = `Evento #${evId} non presente nella pagina corrente.`;
            box.appendChild(div);
            return;
        }
        head.querySelector(".ev-preview__meta").innerHTML =
            `<strong>${TYPE_LABELS[ev.tipo] || ev.tipo}</strong> — ${(ev.aree || []).join(", ") || "—"}
       <span class="ev-inline-status ${ev.open !== false ? "is-open" : "is-closed"}" style="margin-left:.35rem">
         ${ev.open !== false ? "Aperto" : "Chiuso"}
       </span>`;
        const wrap = document.createElement("div");
        wrap.className = "ev-preview__empty text-xs opacity-70";
        wrap.textContent = "Le comunicazioni complete sono visibili nel dettaglio evento.";
        box.appendChild(wrap);
    }

    async function resetGlobalFilters() {
        if ($("#global-q")) $("#global-q").value = "";
        if ($("#global-date")) $("#global-date").value = "";
        if ($("#global-time")) $("#global-time").value = "";
        if ($("#global-comune")) $("#global-comune").value = "";
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
        if ($("#gen-filter-comune")) $("#gen-filter-comune").value = "";
        if ($("#gen-filter-dal")) $("#gen-filter-dal").value = "";
        if ($("#gen-filter-al")) $("#gen-filter-al").value = "";
        state.page.gen = 1;
        await refreshGEN();
    }
    async function resetOngoingFilters() {
        if ($("#ongoing-filter-comune")) $("#ongoing-filter-comune").value = "";
        if ($("#ongoing-filter-dal")) $("#ongoing-filter-dal").value = "";
        if ($("#ongoing-filter-al")) $("#ongoing-filter-al").value = "";
        state.page.ongoing = 1;
        await refreshONGOING();
    }
    document.getElementById("global-reset")?.addEventListener("click", resetGlobalFilters);
    document.getElementById("gen-filters-reset")?.addEventListener("click", resetGenFilters);
    document.getElementById("ongoing-filters-reset")?.addEventListener("click", resetOngoingFilters);

    /* ===== Specific form renderer ===== */
    const SPEC_SCHEMAS = {
        sismico: [
            { id: "magnitudo", label: "Magnitudo (se disponibile)" },
            { id: "intensita", label: "Intensità MCS/EMS" },
            { id: "coordinate", label: "Coordinate epicentro" },
            { id: "danni", label: "Danni segnalati (testo)", type: "textarea" },
        ],
        vulcanico: [
            { id: "tremore", label: "Tremore vulcanico (trend)" },
            { id: "cenere", label: "Ricaduta ceneri (aree)" },
            { id: "dpi", label: "DPI distribuiti (qtà)" },
        ],
        idraulico: [
            { id: "livello", label: "Livello idrometrico (m)" },
            { id: "argine", label: "Criticità arginale (sì/no)" },
            { id: "sottopassi", label: "Sottopassi allagati (#)" },
        ],
        idrogeologico: [
            { id: "tipologia_frana", label: "Tipologia frana" },
            { id: "volume", label: "Volume stimato (mc)" },
            { id: "viabilita", label: "Interferenza viabilità (testo)", type: "textarea" },
        ],
        maremoto: [
            { id: "allerta", label: "Livello allerta" },
            { id: "aree_costiere", label: "Aree costiere interessate" },
        ],
        "deficit-idrico": [
            { id: "pressione", label: "Riduzione pressione (%)" },
            { id: "autobotti", label: "Autobotti in servizio (#)" },
        ],
        "meteo-avverso": [
            { id: "fenomeno", label: "Fenomeno prevalente (vento, grandine…)" },
            { id: "intensita", label: "Intensità" },
            { id: "danni_diffusi", label: "Danni diffusi? (sì/no)" },
        ],
        aib: [
            { id: "superficie", label: "Superficie percorsa dal fuoco (ha)" },
            { id: "combustibile", label: "Tipo combustibile (bosco, sterpaglie…)" },
            { id: "coordinate", label: "Coordinate/Località puntuale" },
            { id: "mezzi", label: "Mezzi impiegati (AIB/VVF/CAI…)" },
            { id: "meteo", label: "Condizioni meteo (vento, umidità…)" },
        ],
        uomo: [
            { id: "tipologia", label: "Tipologia incidente (sversamento, industriale…)" },
            { id: "ente_coinvolto", label: "Ente/Azienda coinvolta" },
            { id: "impatti", label: "Impatti su servizi/ambiente", type: "textarea" },
        ],
        altro: [
            { id: "descrizione", label: "Descrizione dettagli (testo)", type: "textarea" },
        ],
    };

    function renderSpecific(container, type, prefix) {
        if (!container) return;
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
            wrap.innerHTML = `<span class="label">${f.label}</span>` +
                (f.type === "textarea"
                    ? `<textarea class="input" id="${prefix}-${f.id}"></textarea>`
                    : `<input class="input" id="${prefix}-${f.id}"/>`);
            grid.appendChild(wrap);
        });
        container.appendChild(grid);
    }
</script>
