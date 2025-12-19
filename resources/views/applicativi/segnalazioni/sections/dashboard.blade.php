<div class="p-2" id="app">
    <header class="mb-4 flex items-center justify-between">
        <h2 class="text-xl font-semibold">Dashboard SOR</h2>
        <button class="btn btn-primary" data-open-modal="#modal-gen">📝 Nuova segnalazione generica</button>
    </header>

    {{-- RICERCA GLOBALE --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-card p-4 mb-6">
        <div class="grid md:grid-cols-4 gap-3">
            <label class="grid gap-1">
                <span class="label">Parola chiave</span>
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
        <div class="flex justify-between items-center mt-3">
            <button class="btn btn-xs" id="global-reset" type="button">Reset filtri globali</button>
            <span class="text-xs opacity-70">La ricerca globale si somma ai filtri per-tabella.</span>
        </div>
    </div>

    {{-- SEGNALAZIONI GENERICHE --}}
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

        <div class="pager mt-2 flex items-center justify-center gap-2">
            <button class="btn-xs" id="gen-prev">«</button>
            <span id="gen-page" class="pager__label text-xs">Pagina 1 di 1</span>
            <button class="btn-xs" id="gen-next">»</button>
        </div>
    </section>

    {{-- EVENTI IN ATTO --}}
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

        <div id="ongoing-legend" class="ongoing-legend mb-2"></div>
        <div id="ongoing-cards" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3"></div>

        <div class="pager mt-2 flex items-center justify-center gap-2">
            <button class="btn-xs" id="ongoing-prev">«</button>
            <span id="ongoing-page" class="pager__label text-xs">Pagina 1 di 1</span>
            <button class="btn-xs" id="ongoing-next">»</button>
        </div>

        <div class="text-xs opacity-70 mt-2">Suggerimento: clicca una card per aprire il dettaglio evento.</div>
    </section>
</div>

<datalist id="comuni-datalist"></datalist>


@push('scripts')
<script type="module">
    (() => {
        const $ = (s) => document.querySelector(s);
        const PREVIEW_MAX = 500;

        const truncate = (str = "", n = PREVIEW_MAX) =>
            str.length > n ? str.slice(0, n).trimEnd() + "…" : str;

        const fmtDT = (d) =>
            new Intl.DateTimeFormat("it-IT", {
                dateStyle: "short",
                timeStyle: "short"
            }).format(d);

        const toast = (title, text = "", icon = "success", timer = 1800) => {
            if (!window.Swal) return console.warn("Swal non disponibile:", title, text);
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

        const confirmEventToggle = (isOpen) => {
            const willClose = !!isOpen;
            return Swal.fire({
                title: willClose ? "Chiudere l'evento?" : "Riaprire l'evento?",
                text: willClose ?
                    "Confermi la chiusura dell'evento? Potrai riaprirlo in seguito." :
                    "Confermi la riapertura dell'evento?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: willClose ? "Sì, chiudi" : "Sì, riapri",
                cancelButtonText: "Annulla",
                confirmButtonColor: willClose ? "#d33" : "#3085d6",
            });
        };

        const pick = (obj, ...candidates) => {
            for (const c of candidates) {
                if (typeof c === "string") {
                    if (obj && obj[c] != null) return obj[c];
                } else if (Array.isArray(c)) {
                    let cur = obj,
                        ok = true;
                    for (const k of c) {
                        if (cur && Object.prototype.hasOwnProperty.call(cur, k)) cur = cur[k];
                        else {
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
            if (typeof v === "number") return (v > 1e12 ? new Date(v) : new Date(v * 1000)).toISOString();
            if (typeof v === "string" && /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/.test(v))
                return new Date(v.replace(" ", "T")).toISOString();
            const d = new Date(v);
            if (isNaN(d.getTime())) return undefined;
            return d.toISOString();
        };

        const TYPES = [
            "sismico", "vulcanico", "idraulico", "idrogeologico", "maremoto",
            "deficit-idrico", "meteo-avverso", "aib", "uomo", "altro"
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

        // ===== STATE condiviso (no state undefined) =====
        const state = globalThis.SORState || globalThis.state || {
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
                currentEventFull: null,
                ongoingStatus: "all"
            },
            allrep: {
                raw: [],
                filtered: [],
                page: 1,
                perPage: 12,
                q: "",
                dal: "",
                al: "",
                verso: "",
                sort: "desc"
            },
        };
        globalThis.state = state;
        globalThis.SORState = state;

        function prioClass(p = "Nessuna") {
            const k = (p || "").toLowerCase();
            if (k === "alta") return "prio--alta";
            if (k === "media") return "prio--media";
            if (k === "bassa") return "prio--bassa";
            return "prio--nessuna";
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

        // ===== API =====
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
                    toast("Errore", `HTTP ${res.status} ${res.statusText}`, "error", 2200);
                    throw new Error(`HTTP ${res.status} ${res.statusText}\n${txt}`);
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

            listEventi(params) {
                return this._req("/eventi", {
                    params
                });
            },
            getEvento(id) {
                return this._req(`/eventi/${id}`);
            },
            toggleEvento(id) {
                return this._req(`/eventi/${id}/toggle`, {
                    method: "PATCH",
                    body: {}
                });
            },

            createEventoComunicazione(eventId, payload) {
                return this._req(`/eventi/${eventId}/comunicazioni`, {
                    method: "POST",
                    body: payload
                });
            },
        };

        // ===== MAPPERS =====
        const mapSegToUI = (s = {}) => {
            const created = pick(s, "creata_il", "created_at", "createdAt", "data_creazione", "data");
            const dtISO = normalizeISO(created);
            const evId = pick(s, "evento_id", "event_id", "eventId", ["evento", "id"], ["event", "id"]);

            const latRaw = pick(s, "lat", "latitude", "latitudine");
            const lngRaw = pick(s, "lng", "longitude", "longitudine");
            const lat = latRaw != null && latRaw !== "" ? Number(latRaw) : null;
            const lng = lngRaw != null && lngRaw !== "" ? Number(lngRaw) : null;

            return {
                id: pick(s, "id", "uuid"),
                created_at: dtISO,
                direzione: (pick(s, "direzione", "verso") || "E").toString().toUpperCase(),
                tipologia: pick(s, "tipologia") || "",
                tipo: pick(s, "tipo") || "",
                aree: pick(s, "aree", "areas") || [],
                sintesi: pick(s, "sintesi", "note", "descrizione", "oggetto") || "",
                operatore: pick(s, "operatore", "user", "utente", "created_by") || "",
                event_id: evId ? String(evId) : "",
                priorita: pick(s, "priorita", "priority") || "Nessuna",
                comune: pick(s, "comune") || "",
                telefono: pick(s, "telefono") || "",
                email: pick(s, "email") || "",
                indirizzo: pick(s, "indirizzo") || "",
                provincia: pick(s, "provincia") || "",
                mitt_dest: pick(s, "mitt_dest", "mittente", "destinatario") || "",
                oggetto: pick(s, "oggetto", "sintesi", "contenuto") || "",
                contenuto: pick(s, "contenuto", "content", "testo") || "",
                lat,
                lng,
            };
        };

        const mapEvToUI = (e = {}) => {
            const updatedRaw = pick(
                e,
                "aggiornato_il", "updated_at", "updatedAt",
                "ultima_comunicazione", "last_report_at",
                "created_at", "data"
            );
            const updatedISO = normalizeISO(updatedRaw);
            return {
                id: e.id,
                tipo: e.tipologia || e.tipo || "altro",
                descrizione: e.descrizione || "",
                aggiornamento: updatedISO || null,
                operatore: e.operatore || "",
                aree: e.aree || [],
                open: (e.aperto ?? e.is_open ?? e.open ?? true) !== false,
            };
        };

        // ===== EXPORT condiviso per sor-modals =====
        globalThis.SOR = globalThis.SOR || {};
        globalThis.SOR.state = state;
        globalThis.SOR.API = API;
        globalThis.SOR.toast = toast;
        globalThis.SOR.utils = {
            TYPES,
            TYPE_LABELS,
            prioClass,
            truncate,
            makeDirBadge,
            normalizeISO,
            pick,
            mapSegToUI,
            mapEvToUI
        };

        // READY: evento coerente (minuscolo) + compat
        document.dispatchEvent(new CustomEvent("sor:ready"));
        document.dispatchEvent(new CustomEvent("SOR:ready"));

        /* ================= RENDER GEN ================= */
        function renderGEN() {
            const root = $("#gen-body");
            if (!root) return;
            root.replaceChildren();

            if (!state.gen.length) {
                const tr = document.createElement("tr");
                tr.innerHTML = `<td colspan="7" class="px-3 py-3 opacity-70">Nessuna segnalazione.</td>`;
                root.appendChild(tr);
                return;
            }

            state.gen.forEach((r) => {
                const tr = document.createElement("tr");
                tr.className = "border-t border-slate-200 prio-row " + prioClass(r.priorita);
                tr.dataset.id = r.id;

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
                tdOggetto.textContent = truncate(r.oggetto || r.sintesi || "");

                const tdEv = document.createElement("td");
                tdEv.className = "px-3 py-2";
                if (r.event_id) {
                    const btn = document.createElement("button");
                    btn.type = "button";
                    btn.className = "link";
                    btn.dataset.openEvent = String(r.event_id);
                    btn.textContent = `Evento #${r.event_id}`;
                    tdEv.appendChild(btn);
                } else tdEv.textContent = "—";

                const tdAc = document.createElement("td");
                tdAc.className = "px-3 py-2";
                tdAc.innerHTML = `
        <div class="actions">
          <button class="btn-xs btn-ghost" type="button" title="Dettagli" data-action="info" data-type="gen" data-id="${r.id}">ℹ️</button>
          <button class="btn-xs btn-ghost" type="button" title="Modifica" data-action="edit" data-type="gen" data-id="${r.id}">✏️</button>
          <button class="btn-xs btn-danger" type="button" title="Elimina" data-action="del" data-type="gen" data-id="${r.id}">🗑️</button>
        </div>`;

                tr.append(tdData, tdOra, tdDir, tdComune, tdOggetto, tdEv, tdAc);
                root.appendChild(tr);
            });
        }

        /* ================= RENDER ONGOING ================= */
        function ensureLegend() {
            const legend = $("#ongoing-legend");
            if (!legend || legend.children.length) return;
            legend.innerHTML = TYPES.map((t) =>
                `<span class="ol-item" data-type="${t}"><i class="ol-dot" aria-hidden="true"></i>${TYPE_LABELS[t]}</span>`
            ).join("");
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
                const typeLabel = TYPE_LABELS[typeKey] || ev.tipo;
                const isOpen = ev.open !== false;
                const quando = ev.aggiornamento ? fmtDT(new Date(ev.aggiornamento)) : "—";
                const aree = (ev.aree || []).join(", ");

                const card = document.createElement("article");
                card.className = "ev-card";
                card.tabIndex = 0;
                card.setAttribute("role", "button");
                card.dataset.openEvent = String(ev.id);
                card.dataset.type = typeKey;

                card.innerHTML = `
        <div class="ev-card__head">
          <h4 class="ev-card__title">${ev.descrizione || "Evento"}</h4>
          <div class="ev-card__chips">
            <span class="ev-card__status ${isOpen ? "is-open":"is-closed"}">${isOpen ? "Aperto":"Chiuso"}</span>
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

        /* ================= LOADERS ================= */
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

                const cur = res.meta?.current_page ?? 1;
                const last = res.meta?.last_page ?? 1;
                $("#gen-page") && ($("#gen-page").textContent = `Pagina ${cur} di ${last}`);
                $("#gen-prev") && ($("#gen-prev").disabled = cur <= 1);
                $("#gen-next") && ($("#gen-next").disabled = cur >= last);

                renderGEN();
            } catch (err) {
                console.error(err);
                state.gen = [];
                renderGEN();
                toast("Errore caricamento segnalazioni", "Il server ha risposto con errore.", "error", 2600);
            }
        }

        async function refreshONGOING() {
            try {
                const params = {
                    page: state.page.ongoing,
                    per_page: 10,
                    q: state.global.q || null,
                    comune: $("#ongoing-filter-comune")?.value || state.global.comune || null,
                    dal: $("#ongoing-filter-dal")?.value || null,
                    al: $("#ongoing-filter-al")?.value || null,
                };
                const res = await API.listEventi(params);
                const rows = Array.isArray(res) ? res : (res.data || []);
                let items = rows.map(mapEvToUI);

                if (state.ui.ongoingStatus === "open") items = items.filter((e) => e.open);
                else if (state.ui.ongoingStatus === "closed") items = items.filter((e) => !e.open);

                state.ongoing = items;

                const cur = res.meta?.current_page ?? 1;
                const last = res.meta?.last_page ?? 1;
                $("#ongoing-page") && ($("#ongoing-page").textContent = `Pagina ${cur} di ${last}`);
                $("#ongoing-prev") && ($("#ongoing-prev").disabled = cur <= 1);
                $("#ongoing-next") && ($("#ongoing-next").disabled = cur >= last);

                renderONGOING();
            } catch (err) {
                console.error(err);
                state.ongoing = [];
                renderONGOING();
                toast("Errore caricamento eventi", "Il server ha risposto con errore.", "error", 2600);
            }
        }

        /* ================= EVENT MODAL ================= */
        function extractEventRelated(full) {
            const gensRaw = full.segnalazioni_generiche || full.segnalazioni || full.generic_reports || full.reports || [];
            return (Array.isArray(gensRaw) ? gensRaw : []).map(mapSegToUI);
        }

        function ensureEventToggleButton(evId, isOpen) {
            const btn = $("#ev-toggle-open");
            if (!btn) return;
            btn.dataset.eventToggleId = String(evId);
            btn.dataset.eventIsOpen = isOpen ? "1" : "0";
            btn.textContent = isOpen ? "🔒 Chiudi evento" : "🔓 Riapri evento";
            btn.className = isOpen ? "btn-xs" : "btn-xs btn-danger";
        }

        function bindEventToggleOnce() {
            const btn = $("#ev-toggle-open");
            if (!btn || btn.dataset.bound === "1") return;
            btn.dataset.bound = "1";

            btn.addEventListener("click", async () => {
                const id = Number(btn.dataset.eventToggleId || state.ui.currentEventId || 0);
                if (!id) return;

                const curOpen = btn.dataset.eventIsOpen === "1";
                const conf = await confirmEventToggle(curOpen);
                if (!conf.isConfirmed) return;

                try {
                    await API.toggleEvento(id);
                    const full = await API.getEvento(id);
                    renderEventModal(full);
                    await refreshONGOING();
                    toast("Evento aggiornato", "Stato aperto/chiuso aggiornato.");
                } catch (err) {
                    console.error(err);
                    toast("Errore", "Impossibile aggiornare lo stato evento.", "error", 2400);
                }
            });
        }

        function renderEventModal(full) {
            state.ui.currentEventFull = full;
            const ev = mapEvToUI(full);

            $("#ev-title") && ($("#ev-title").textContent = ev.descrizione || `Evento #${ev.id}`);
            $("#ev-subtitle") && ($("#ev-subtitle").textContent =
                `${TYPE_LABELS[ev.tipo] || ev.tipo} • Ultimo agg.: ${ev.aggiornamento ? fmtDT(new Date(ev.aggiornamento)) : "—"}`
            );

            ensureEventToggleButton(ev.id, ev.open);

            const areasWrap = $("#ev-areas");
            if (areasWrap) {
                areasWrap.replaceChildren();
                (ev.aree || []).forEach((a) => {
                    const s = document.createElement("span");
                    s.className = "tag";
                    s.textContent = a;
                    areasWrap.appendChild(s);
                });
                if (!ev.aree?.length) areasWrap.textContent = "—";
            }

            const gens = extractEventRelated(full);
            const tbody = $("#ev-reports-tbody");
            if (tbody) {
                tbody.replaceChildren();
                if (!gens.length) {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `<td colspan="5" class="px-3 py-3 opacity-70">Nessuna segnalazione.</td>`;
                    tbody.appendChild(tr);
                } else {
                    gens.forEach((r) => {
                        const d = r.created_at ? new Date(r.created_at) : null;
                        const dText = d && !isNaN(d) ? d.toLocaleDateString("it-IT") : "—";
                        const tText = d && !isNaN(d) ? d.toTimeString().slice(0, 5) : "—";

                        const tr = document.createElement("tr");
                        tr.className = "border-t border-slate-200 prio-row " + prioClass(r.priorita);
                        tr.innerHTML = `
            <td class="px-3 py-2">${dText}</td>
            <td class="px-3 py-2">${tText}</td>
            <td class="px-3 py-2"></td>
            <td class="px-3 py-2 w-sintesi">${truncate(r.oggetto || r.sintesi || "—")}</td>
            <td class="px-3 py-2">
              <button type="button" class="btn-xs btn-ghost" data-action="info" data-type="gen" data-id="${r.id}">ℹ️</button>
              <button type="button" class="btn-xs btn-ghost" data-action="edit" data-type="gen" data-id="${r.id}">✏️</button>
            </td>`;
                        tr.children[2].appendChild(makeDirBadge(r.direzione));
                        tbody.appendChild(tr);
                    });
                }
            }
        }

        async function openEventModal(eventId) {
            state.ui.currentEventId = eventId;
            const full = await API.getEvento(eventId);
            renderEventModal(full);
            bindEventToggleOnce();
            globalThis.SORModals?.openModal?.("#modal-event", null, {
                full: true
            });
        }

        /* ================= INFO/EDIT MODALS: SEMPRE SOPRA (aperti dal manager) ================= */
        function openGenInfo(id, openerEl) {
            // TODO: qui puoi popolare #gen-info-body
            // per ora apre e basta (ma sopra a tutto grazie al manager)
            globalThis.SORModals?.openModal?.("#modal-gen-info", openerEl || null, {
                full: true
            });
        }

        function openGenEdit(id, openerEl) {
            // TODO: qui puoi popolare #form-edit-gen
            globalThis.SORModals?.openModal?.("#modal-edit-gen", openerEl || null, {
                full: true
            });
        }

        /* ================= CLICK HANDLERS ================= */
        document.addEventListener("click", (e) => {
            const evBtn = e.target.closest("[data-open-event]");
            if (evBtn) {
                const id = Number(evBtn.dataset.openEvent);
                if (!Number.isNaN(id)) openEventModal(id);
                return;
            }

            const btn = e.target.closest("[data-action]");
            if (!btn) return;

            const {
                action,
                type,
                id
            } = btn.dataset;
            if (type !== "gen") return;

            if (action === "info") {
                openGenInfo(id, btn);
                return;
            }
            if (action === "edit") {
                openGenEdit(id, btn);
                return;
            }

            if (action === "del") {
                confirmDelete().then(async (res) => {
                    if (!res.isConfirmed) return;
                    await API.deleteSegnalazione(id);
                    await Promise.all([refreshGEN(), refreshONGOING()]);
                    toast("Eliminata!", "Rimossa dal backend.", "success");
                });
            }
        });

        /* ================= FILTRI + PAGINAZIONE ================= */
        ["#global-q", "#global-date", "#global-time", "#global-comune"].forEach((sel) =>
            $(sel)?.addEventListener("input", async () => {
                state.global.q = $("#global-q")?.value.trim() || "";
                state.global.date = $("#global-date")?.value || "";
                state.global.time = $("#global-time")?.value || "";
                state.global.comune = $("#global-comune")?.value.trim() || "";
                state.page.gen = 1;
                state.page.ongoing = 1;
                await Promise.all([refreshGEN(), refreshONGOING()]);
            })
        );

        $("#global-reset")?.addEventListener("click", async () => {
            ["#global-q", "#global-date", "#global-time", "#global-comune"].forEach((s) => $(s) && ($(s).value = ""));
            state.global = {
                q: "",
                date: "",
                time: "",
                comune: ""
            };
            state.page.gen = 1;
            state.page.ongoing = 1;
            await Promise.all([refreshGEN(), refreshONGOING()]);
        });

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
            state.page.ongoing += 1;
            await refreshONGOING();
        });

        const toggleBtn = $("#ongoing-toggle-status");

        function updateToggleBtn() {
            if (!toggleBtn) return;
            toggleBtn.textContent =
                state.ui.ongoingStatus === "all" ? "Tutti" :
                state.ui.ongoingStatus === "open" ? "Solo aperti" : "Solo chiusi";
            toggleBtn.title = toggleBtn.textContent;
        }
        toggleBtn?.addEventListener("click", async () => {
            state.ui.ongoingStatus =
                state.ui.ongoingStatus === "all" ? "open" :
                state.ui.ongoingStatus === "open" ? "closed" : "all";
            state.page.ongoing = 1;
            updateToggleBtn();
            await refreshONGOING();
        });
        updateToggleBtn();

        /* ================= INIT ================= */
        (async function init() {
            await Promise.all([refreshGEN(), refreshONGOING()]);
            if (window.lucide) lucide.createIcons();
        })();

    })();
</script>

@endpush