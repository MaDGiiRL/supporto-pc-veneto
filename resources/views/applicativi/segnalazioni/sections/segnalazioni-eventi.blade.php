<div class="p-6 space-y-4" id="app-segnalazioni-generiche">
    <header class="mb-4 flex items-center justify-between">
        <div>
            <p class="text-xs font-medium uppercase tracking-[0.2em] text-slate-400">
                Sala Operativa Regionale
            </p>
            <h2 class="text-2xl font-semibold text-slate-900">
                Nuova segnalazione generica
            </h2>
            <p class="mt-1 text-sm text-slate-500 max-w-3xl">
                Questo modulo replica la <strong>modale “Nuova segnalazione generica”</strong> della dashboard,
                ma in una pagina dedicata. I dati vengono salvati tramite le API <code>/api/sor/segnalazioni</code>
                con la stessa logica già in uso.
            </p>
        </div>
    </header>

    <div class="rounded-2xl border border-slate-200 bg-white shadow-card p-5">
        <form id="form-gen" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" id="gen-id" />

            {{-- Tipologia + Priorità --}}
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

            {{-- Associazione evento --}}
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

            {{-- Data / ora / tipo / verso --}}
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

            {{-- Mitt/dest + contatti --}}
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

            {{-- Localizzazione --}}
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

            {{-- Oggetto / contenuto --}}
            <label class="grid gap-1.5 md:col-span-2">
                <span class="label">Oggetto</span>
                <input id="g-oggetto" class="input" />
            </label>

            <label class="grid gap-1.5 md:col-span-2">
                <span class="label">Contenuto</span>
                <textarea id="g-contenuto" class="input" rows="4"></textarea>
            </label>

            {{-- Campi specifici dinamici --}}
            <div class="md:col-span-2">
                <legend class="text-sm font-semibold mb-1">Campi specifici</legend>
                <div id="gen-specific"></div>
            </div>

            <div class="md:col-span-2 flex justify-end gap-2 pt-4 border-t border-slate-100 mt-2">
                <button type="reset" class="btn">Reset</button>
                <button type="submit" class="btn btn-primary">💾 Salva segnalazione</button>
            </div>
        </form>
    </div>
</div>

{{-- Datalist Comuni (come in dashboard) --}}
<datalist id="comuni-datalist"></datalist>

<script>
    window.PROVINCE = @json(config('province.veneto'));
    window.VENETO_COMUNI = @json(config('comuni_veneto'));
</script>

{{-- JS: copia logica della modale, ma per pagina --}}

<script type="module">
    const $ = (s) => document.querySelector(s);

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

    const PROVINCE = window.PROVINCE || {};
    const COMUNI_RAW = window.VENETO_COMUNI || {};

    /* === Toast basic (usa Swal se presente) === */
    const toast = (title, text = "", icon = "success", timer = 1800) => {
        if (!window.Swal) {
            console.log(`[${icon}]`, title, text);
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

    /* === TagInput (come in dashboard) === */
    class TagInput {
        constructor(root, {
            placeholder = "Aggiungi e premi Invio",
            datalistId = null
        } = {}) {
            if (!root) return;
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
            this.root.innerHTML = `
                <div class="tags" role="list"></div>
                <div class="tag-input__control">
                    <input class="tag-input__field" ${this.datalistId ? `list="${this.datalistId}"` : ""} placeholder="${this.placeholder}" />
                </div>`;
            this.tagsEl = this.root.querySelector(".tags");
            this.inputEl = this.root.querySelector(".tag-input__field");

            if (this.datalistId) this.refreshAllowedFromDatalist();

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

            if (this.allowedValues && !this.allowedValues.has(v)) {
                toast("Valore non valido", "Seleziona un'area dalla lista predefinita.", "error", 2200);
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
                tag.innerHTML = `<span class="tag__text">${val}</span>
                                 <button class="tag__x" type="button" title="Rimuovi">×</button>`;
                tag.querySelector(".tag__x").addEventListener("click", () => this.remove(i));
                this.tagsEl.appendChild(tag);
            });
            this.root.dispatchEvent(new CustomEvent("change", {
                detail: this.values.slice()
            }));
        }
    }

    /* === COMUNE_META + datalist === */
    const COMUNE_META = {};

    (function buildComuneMeta() {
        Object.entries(COMUNI_RAW).forEach(([prov, list]) => {
            if (Array.isArray(list)) {
                list.forEach((raw) => {
                    if (!raw) return;
                    if (typeof raw === "string") {
                        const key = `${prov}|${raw}`;
                        if (!COMUNE_META[key]) {
                            COMUNE_META[key] = {
                                istat: null,
                                nome: raw,
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
            }
        });
    })();

    function getComuniByProvincia(code) {
        const names = new Set();
        Object.values(COMUNE_META).forEach((c) => {
            if (c.provincia === code) names.add(c.nome);
        });
        return Array.from(names).sort((a, b) => a.localeCompare(b, "it"));
    }

    function getComuneMeta(nome, prov) {
        if (!nome || !prov) return null;
        return COMUNE_META[`${prov}|${nome}`] || null;
    }

    (function buildDatalist() {
        const datalist = $("#comuni-datalist");
        if (!datalist) return;
        const seen = new Set();
        const push = (v) => {
            if (!v || seen.has(v)) return;
            seen.add(v);
            const opt = document.createElement("option");
            opt.value = v;
            datalist.appendChild(opt);
        };

        Object.values(COMUNE_META).forEach((c) => {
            push(c.nome);
            (c.frazioni || []).forEach((f) => push(`${f} (${c.nome})`));
            if (c.zona) push(c.zona);
        });
    })();

    /* === API === */
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
            const url = new URL(this.base + path, location.origin);
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
                        "X-CSRF-TOKEN": this.csrf()
                    } : {}),
                },
                body: isJSON ? JSON.stringify(body) : body,
            });
            if (!res.ok) {
                const txt = await res.text().catch(() => "");
                toast("Errore", `HTTP ${res.status} ${res.statusText}`, "error", 2200);
                throw new Error(`HTTP ${res.status} ${res.statusText}\n${txt}`);
            }
            const ctype = res.headers.get("content-type") || "";
            return ctype.includes("application/json") ? res.json() : res;
        },
        listEventi(params) {
            return this._req("/eventi", {
                params
            });
        },
        createEvento(payload) {
            return this._req("/eventi", {
                method: "POST",
                body: payload
            });
        },
        createSegnalazione(payload) {
            return this._req("/segnalazioni", {
                method: "POST",
                body: payload
            });
        },
    };

    /* === Tipologie & campi specifici === */
    const TYPE_LABELS = {
        sismico: "Sismico",
        vulcanico: "Vulcanico",
        idraulico: "Idraulico",
        idrogeologico: "Idrogeologico",
        maremoto: "Maremoto",
        "deficit-idrico": "Deficit Idrico",
        "meteo-avverso": "Meteo avverso",
        aib: "AIB",
        uomo: "Prodotti dall’uomo",
        altro: "Altro",
    };

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
        }, ],
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
            wrap.innerHTML =
                `<span class="label">${f.label}</span>` +
                (f.type === "textarea" ?
                    `<textarea class="input" id="${prefix}-${f.id}"></textarea>` :
                    `<input class="input" id="${prefix}-${f.id}" />`);
            grid.appendChild(wrap);
        });
        container.appendChild(grid);
    }

    function populateProvinceSelect(selected = "") {
        const sel = $("#g-provincia");
        if (!sel) return;
        sel.innerHTML = "";
        sel.add(new Option("Tutte le province...", ""));
        if (Array.isArray(PROVINCE)) {
            PROVINCE.forEach(p => {
                if (!p) return;
                const code = p.sigla || p.codice || p.code || p;
                const label = p.nome || p.name || code;
                if (!code) return;
                sel.add(new Option(label, code));
            });
        } else {
            Object.entries(PROVINCE).forEach(([code, label]) => {
                sel.add(new Option(label || code, code));
            });
        }
        sel.value = selected || "";
        const comuneSel = $("#g-comune");
        if (comuneSel) {
            comuneSel.disabled = !sel.value;
            if (!sel.value) {
                comuneSel.innerHTML = `<option value="">Prima seleziona una provincia...</option>`;
            }
        }
    }

    function populateComuniSelect(prov, selected = "") {
        const comuneSel = $("#g-comune");
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

    function maybeAddZonaToAree(tagInputInstance) {
        const prov = $("#g-provincia")?.value;
        const comune = $("#g-comune")?.value;
        if (!prov || !comune || !tagInputInstance) return;
        const meta = getComuneMeta(comune, prov);
        const zona = meta?.zona;
        if (!zona) return;
        if (!tagInputInstance.values.includes(zona)) {
            tagInputInstance.add(zona);
        }
    }

    async function populateEventSelect(selectEl) {
        if (!selectEl) return;
        // pulisco, lascio le 2 di base
        selectEl.innerHTML = `
            <option value="">— Nessuna associazione —</option>
            <option value="__new__">[+ Crea nuovo evento]</option>`;
        try {
            const res = await API.listEventi({
                per_page: 50
            });
            const rows = Array.isArray(res) ? res : (res.data || []);
            rows.forEach((ev) => {
                const opt = document.createElement("option");
                opt.value = ev.id;
                const tipo = ev.tipologia || ev.tipo || "altro";
                const labelTipo = TYPE_LABELS[tipo] || tipo;
                const aree = (ev.aree || []).join(", ");
                opt.textContent = `[${labelTipo}] ${aree || "Evento #"+ev.id}`;
                selectEl.appendChild(opt);
            });
        } catch (err) {
            console.error("Errore caricamento eventi:", err);
        }
    }

    document.addEventListener("DOMContentLoaded", async () => {
        const form = $("#form-gen");
        if (!form) return;

        // province/comuni
        populateProvinceSelect("");
        $("#g-provincia")?.addEventListener("change", (e) => {
            populateComuniSelect(e.target.value, "");
        });
        $("#g-comune")?.addEventListener("change", () => {
            maybeAddZonaToAree(genAree);
        });

        // date/ora
        const {
            date,
            time
        } = nowIT();
        $("#g-data").value = date;
        $("#g-ora").value = time;

        // tipologia specifica
        const specContainer = $("#gen-specific");
        renderSpecific(specContainer, "", "gensp");
        $("#gen-tipologia")?.addEventListener("change", (e) => {
            renderSpecific(specContainer, e.target.value || "", "gensp");
        });

        // tag input aree
        const genAreeRoot = $("#gen-aree");
        let genAree = null;
        if (genAreeRoot) {
            genAree = new TagInput(genAreeRoot, {
                datalistId: "comuni-datalist"
            });
            genAreeRoot.addEventListener("change", (ev) => {
                const hid = $("#gen-aree-hidden");
                if (hid) hid.value = JSON.stringify(ev.detail || []);
            });
        }

        // select eventi
        await populateEventSelect($("#gen-event-select"));

        // reset form -> pulisco aree e specifici
        form.addEventListener("reset", () => {
            setTimeout(() => {
                const {
                    date,
                    time
                } = nowIT();
                $("#g-data").value = date;
                $("#g-ora").value = time;
                $("#gen-tipologia").value = "";
                renderSpecific(specContainer, "", "gensp");
                if (genAree && genAree.setValues) genAree.setValues([]);
                const hid = $("#gen-aree-hidden");
                if (hid) hid.value = "[]";
                $("#gen-event-select").value = "";
            }, 0);
        });

        // submit => stessa logica della modale
        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const tipologia = $("#gen-tipologia")?.value || "altro";
            const priorita = document.querySelector('input[name="priorita"]:checked')?.value || "Nessuna";
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
            specContainer?.querySelectorAll("input, textarea, select").forEach((el) => {
                const id = el.id || "";
                if (!id.startsWith("gensp-")) return;
                const key = id.replace(/^gensp-/, "");
                const val = el.value.trim();
                if (val) campi_specifici[key] = val;
            });

            let evento_id = null;

            try {
                if (chosenEvent === "__new__") {
                    // crea evento
                    const evRes = await API.createEvento({
                        tipologia,
                        descrizione: oggetto || `Evento ${TYPE_LABELS[tipologia] || tipologia}`,
                        aree,
                        aperto: true,
                    });
                    const newEvId = evRes?.id ?? evRes?.data?.id;
                    if (!newEvId) {
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

                toast("Segnalazione aggiunta!", "Salvata su backend.");
                form.reset();
            } catch (err) {
                console.error("Errore salvataggio segnalazione:", err);
                toast("Errore salvataggio", "Impossibile salvare la segnalazione.", "error", 2600);
            }
        });
    });
</script>