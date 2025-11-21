
<div id="sor-all-reports" class="space-y-4 p-5">

    {{-- TOP 5 EVENTI IN ATTO --}}
    <section class="mb-3">
        <h4 class="text-sm font-semibold mb-2">Eventi in atto (ultimi 5)</h4>
        <div id="all-reports-top"
             class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
            <div class="text-xs opacity-60">
                Caricamento eventi in atto…
            </div>
        </div>
    </section>

    {{-- TUTTE LE SEGNALAZIONI / COMUNICAZIONI --}}
    <section class="rounded-2xl border border-slate-200 bg-white p-3">
        <div class="flex items-center justify-between gap-3 mb-2">
            <h4 class="text-sm font-semibold">Comunicazioni e segnalazioni</h4>
            <div class="text-xs opacity-70">
                Ordinate dalla più recente alla meno recente.
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm all-reports-table">
                <thead class="text-left">
                    <tr>
                        <th class="px-3 py-2">Data</th>
                        <th class="px-3 py-2">Ora</th>
                        <th class="px-3 py-2">E/U</th>
                        <th class="px-3 py-2">Tipo</th>
                        <th class="px-3 py-2">Comune</th>
                        <th class="px-3 py-2 w-sintesi">Oggetto / Sintesi</th>
                        <th class="px-3 py-2">Evento</th>
                        <th class="px-3 py-2">Azioni</th>
                    </tr>
                </thead>
                <tbody id="all-reports-tbody">
                    <tr>
                        <td colspan="8" class="px-3 py-3 text-xs opacity-60">
                            Caricamento comunicazioni…
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>

{{-- tutte le modali SOR (gen-info, ev-info, event, ecc.) --}}
@include('partials.sor-modals')

<script type="module">
    (function () {
        const $  = (s) => document.querySelector(s);

        const toast =
            window.toast ||
            function (title, text = "", icon = "info", timer = 2200) {
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

        /* ================= API ================= */

        const API = {
            base() {
                return window.SOR_API_BASE || "/api/sor";
            },
            csrf() {
                return document.querySelector('meta[name="csrf-token"]')?.content || "";
            },
            async _req(path, { method = "GET", params = null, body = null } = {}) {
                const url = new URL(this.base() + path, location.origin);
                if (params) {
                    Object.entries(params).forEach(([k, v]) => {
                        if (v !== undefined && v !== null && v !== "") {
                            url.searchParams.set(k, v);
                        }
                    });
                }
                const isJSON = body && !(body instanceof FormData);
                const res    = await fetch(url.toString(), {
                    method,
                    credentials: "include",
                    headers: {
                        Accept: "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        ...(isJSON ? { "Content-Type": "application/json" } : {}),
                        ...(method !== "GET" ? { "X-CSRF-TOKEN": this.csrf() } : {}),
                    },
                    body: isJSON ? JSON.stringify(body) : body,
                });
                if (!res.ok) {
                    const txt = await res.text().catch(() => "");
                    toast("Errore", `HTTP ${res.status} ${res.statusText}`, "error");
                    throw new Error(`HTTP ${res.status} ${res.statusText}\n${txt}`);
                }
                const ctype = res.headers.get("content-type") || "";
                return ctype.includes("application/json") ? res.json() : res;
            },
            listEventi(params) {
                return this._req("/eventi", { params });
            },
            listSegnalazioni(params) {
                return this._req("/segnalazioni", { params });
            },
        };

        /* ============== MAPPERS / HELPER ============== */

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

        function tipoLabel(key) {
            if (!key) return "Altro";
            return TYPE_LABELS[key] || key;
        }

        function fmtDateTimeISO(iso) {
            if (!iso) return { date: "—", time: "—" };
            const d = new Date(iso);
            if (Number.isNaN(d.getTime())) return { date: "—", time: "—" };
            const date = d.toLocaleDateString("it-IT");
            const time = d.toLocaleTimeString("it-IT", { hour: "2-digit", minute: "2-digit" });
            return { date, time };
        }

        function mapEvent(raw) {
            return {
                id:          raw.id,
                tipologia:   raw.tipologia || raw.tipo || "altro",
                descrizione: raw.descrizione || raw.titolo || raw.nome || `Evento #${raw.id}`,
                aree:        raw.aree || raw.zone || [],
                aperto:      raw.aperto ?? raw.open ?? true,
                updated_at:  raw.ultima_comunicazione || raw.last_report_at || raw.updated_at || raw.created_at || null,
            };
        }

        function mapSegnalazione(raw) {
            return {
                id:         raw.id,
                creata_il:  raw.creata_il || raw.created_at || null,
                created_at: raw.creata_il || raw.created_at || null,
                direzione:  raw.direzione || raw.verso || "E",
                tipologia:  raw.tipologia || raw.tipo_evento || "altro",
                tipo:       raw.tipo || raw.tipo_comunicazione || "",
                comune:     raw.comune || "",
                aree:       raw.aree || [],
                mitt_dest:  raw.mitt_dest || raw.mittente || raw.destinatario || "",
                telefono:   raw.telefono || raw.tel || "",
                email:      raw.email || raw.mail || "",
                indirizzo:  raw.indirizzo || "",
                provincia:  raw.provincia || "",
                operatore:  raw.operatore || raw.user_name || "",
                priorita:   raw.priorita || "Nessuna",
                event_id:   raw.event_id || raw.evento_id || null,
                sintesi:    raw.sintesi || raw.oggetto || "",
                oggetto:    raw.oggetto || raw.sintesi || "",
                contenuto:  raw.contenuto || raw.testo || "",
            };
        }

        /* ============== RENDER UI ============== */

        function renderEventCards(events, segnalazioniByEvent) {
            const wrap = $("#all-reports-top");
            if (!wrap) return;
            wrap.replaceChildren();

            if (!events.length) {
                const div       = document.createElement("div");
                div.className   = "text-xs opacity-70";
                div.textContent = "Nessun evento in atto.";
                wrap.appendChild(div);
                return;
            }

            events.forEach((ev) => {
                const countSeg = (segnalazioniByEvent[ev.id] || []).length;
                const typeKey  = ev.tipologia || "altro";
                const tlabel   = tipoLabel(typeKey);
                const { date, time } = fmtDateTimeISO(ev.updated_at);
                const when     = ev.updated_at ? `${date} ${time}` : "—";
                const areeText = (ev.aree || []).join(", ") || "—";

                const card = document.createElement("article");
                card.className       = "ev-card ev-card--compact";
                card.dataset.type    = typeKey;
                card.dataset.eventId = ev.id;
                card.dataset.openEvent = ev.id; // intercettato dal listener globale

                card.innerHTML = `
                    <div class="ev-card__head">
                        <h4 class="ev-card__title">${ev.descrizione || ("Evento #" + ev.id)}</h4>
                        <div class="ev-card__chips">
                            <span class="ev-card__status ${ev.aperto ? "is-open" : "is-closed"}">
                                ${ev.aperto ? "Aperto" : "Chiuso"}
                            </span>
                            <span class="ev-card__badge">${tlabel}</span>
                        </div>
                    </div>
                    <ul class="ev-card__meta">
                        <li><strong>Ultimo agg.:</strong> ${when}</li>
                        <li><strong>Aree:</strong> ${areeText}</li>
                        <li><strong>Segnalazioni:</strong> ${countSeg}</li>
                    </ul>
                `;

                // blocco click se era un drag reale (flag gestito su strip)
                card.addEventListener("click", (e) => {
                    const strip = document.getElementById("all-reports-top");
                    if (strip && strip.classList.contains("is-dragging")) {
                        e.preventDefault();
                        e.stopPropagation();
                        return;
                    }
                    // il resto lo fa il listener globale sul [data-open-event]
                });

                wrap.appendChild(card);
            });
        }

        function renderAllSegnalazioniTable(segnalazioni) {
            const tbody = $("#all-reports-tbody");
            if (!tbody) return;
            tbody.replaceChildren();

            if (!segnalazioni.length) {
                const tr     = document.createElement("tr");
                tr.innerHTML =
                    `<td colspan="8" class="px-3 py-3 text-xs opacity-70">Nessuna comunicazione/segnalazione trovata.</td>`;
                tbody.appendChild(tr);
                return;
            }

            segnalazioni.forEach((rec) => {
                const { date, time } = fmtDateTimeISO(rec.created_at);
                const tr             = document.createElement("tr");
                tr.className         = "border-t border-slate-100 hover:bg-slate-50 all-reports-row";

                const dir      = (rec.direzione || "E").toString().toUpperCase();
                const isIn     = dir === "E";
                const dirLabel = isIn ? "E" : "U";
                const dirTitle = isIn ? "Entrata" : "Uscita";

                const tdEvento = rec.event_id
                    ? `<button type="button"
                               class="link text-xs"
                               data-open-event="${rec.event_id}">
                           Evento #${rec.event_id}
                       </button>`
                    : "—";

                tr.innerHTML = `
                    <td class="px-3 py-2 whitespace-nowrap text-xs">${date}</td>
                    <td class="px-3 py-2 whitespace-nowrap text-xs">${time}</td>
                    <td class="px-3 py-2 whitespace-nowrap text-xs">
                        <span class="inline-flex items-center justify-center rounded-full border border-slate-300 px-1.5 text-[0.65rem] font-semibold text-slate-700 bg-slate-50 all-reports-dir-chip" title="${dirTitle}">
                            ${dirLabel}
                        </span>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap text-xs">
                        ${rec.tipo || "—"}
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap text-xs">
                        ${rec.comune || "—"}
                    </td>
                    <td class="px-3 py-2 text-xs max-w-xs">
                        <div class="font-semibold text-slate-900 truncate">
                            ${rec.oggetto || "—"}
                        </div>
                        <div class="text-[0.7rem] text-slate-500 line-clamp-2">
                            ${rec.contenuto || rec.sintesi || ""}
                        </div>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap text-xs">
                        ${tdEvento}
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap text-xs">
                        <button type="button"
                                class="btn btn-xs"
                                data-all-reports-detail="${rec.id}">
                            Dettagli
                        </button>
                    </td>
                `;

                tbody.appendChild(tr);
            });

            // bottone Dettagli → modale corretta del partial (modal-gen-info)
            tbody.querySelectorAll("[data-all-reports-detail]").forEach((btn) => {
                btn.addEventListener("click", () => {
                    const id  = btn.getAttribute("data-all-reports-detail");
                    const rec = segnalazioni.find((r) => String(r.id) === String(id));
                    if (!rec) return;

                    if (window.SORModals && typeof window.SORModals.showGenInfo === "function") {
                        window.SORModals.showGenInfo(rec);
                    } else {
                        console.warn("SORModals.showGenInfo non definito");
                    }
                });
            });
        }

        /* ============== DRAG SCROLL TOP 5 EVENTI ============== */

        function initDragScroll() {
            const strip = document.getElementById("all-reports-top");
            if (!strip) return;

            let isDown     = false;
            let startX     = 0;
            let scrollLeft = 0;
            let moved      = false;

            const start = (pageX) => {
                isDown        = true;
                moved         = false;
                strip.classList.add("is-dragging");
                startX        = pageX - strip.offsetLeft;
                scrollLeft    = strip.scrollLeft;
            };

            const end = () => {
                if (!isDown) return;
                isDown = false;
                setTimeout(() => {
                    strip.classList.remove("is-dragging");
                }, 0);
            };

            const move = (pageX) => {
                if (!isDown) return;
                const x     = pageX - strip.offsetLeft;
                const delta = x - startX;
                if (Math.abs(delta) > 3) moved = true;
                const walk  = delta * 1.2;
                strip.scrollLeft = scrollLeft - walk;
            };

            // blocco i click nati da un drag vero (capturing)
            strip.addEventListener("click", (e) => {
                if (strip.classList.contains("is-dragging") && moved) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }, true);

            // mouse
            strip.addEventListener("mousedown", (e) => {
                start(e.pageX);
            });
            strip.addEventListener("mouseleave", end);
            strip.addEventListener("mouseup", end);
            strip.addEventListener("mousemove", (e) => {
                if (!isDown) return;
                e.preventDefault();
                move(e.pageX);
            });

            // touch
            strip.addEventListener("touchstart", (e) => {
                const t = e.touches[0];
                start(t.pageX);
            }, { passive: true });

            strip.addEventListener("touchend", end);
            strip.addEventListener("touchcancel", end);
            strip.addEventListener("touchmove", (e) => {
                if (!isDown) return;
                const t = e.touches[0];
                move(t.pageX);
            }, { passive: false });
        }

        /* ============== LOAD DATI ============== */

        let HAS_LOADED = false;

        async function loadAllReports() {
            if (HAS_LOADED) return;
            try {
                const segRes = await API.listSegnalazioni({ per_page: 1000, order: "desc" });
                const segRaw = Array.isArray(segRes) ? segRes : (segRes.data || []);
                const segs   = segRaw.map(mapSegnalazione);

                const evRes  = await API.listEventi({ per_page: 50 });
                const evRaw  = Array.isArray(evRes) ? evRes : (evRes.data || []);
                const events = evRaw.map(mapEvent);

                const segByEvent = {};
                segs.forEach((s) => {
                    const evId = s.event_id;
                    if (!evId) return;
                    if (!segByEvent[evId]) segByEvent[evId] = [];
                    segByEvent[evId].push(s);
                });

                const topEvents = events
                    .slice()
                    .sort((a, b) => {
                        const ta = a.updated_at ? new Date(a.updated_at).getTime() : 0;
                        const tb = b.updated_at ? new Date(b.updated_at).getTime() : 0;
                        return tb - ta;
                    })
                    .slice(0, 5);

                segs.sort((a, b) => {
                    const ta = a.created_at ? new Date(a.created_at).getTime() : 0;
                    const tb = b.created_at ? new Date(b.created_at).getTime() : 0;
                    return tb - ta;
                });

                renderEventCards(topEvents, segByEvent);
                renderAllSegnalazioniTable(segs);

                HAS_LOADED = true;
            } catch (err) {
                console.error("Errore caricamento tutte le comunicazioni:", err);
                toast("Errore", "Impossibile caricare le comunicazioni.", "error", 2600);
            }
        }

        function initAllReports() {
            initDragScroll();
            loadAllReports();
        }

        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", initAllReports, { once: true });
        } else {
            initAllReports();
        }

        // se la modale "tutte le comunicazioni" è caricata via AJAX e poi aperta
        document.addEventListener("modal:all-reports:opened", () => {
            loadAllReports();
        });

        // ============== APERTURA MODALE EVENTO DA [data-open-event] ==============
        document.addEventListener("click", (e) => {
            const evOpener = e.target.closest("[data-open-event]");
            if (!evOpener) return;

            e.preventDefault();

            const evId = evOpener.getAttribute("data-open-event");
            if (!evId) return;

            // se esiste un gestore globale per gli eventi, lo uso
            if (window.SOREvents && typeof window.SOREvents.open === "function") {
                window.SOREvents.open(evId);
                return;
            }

            // fallback: apro direttamente la modale evento
            const modal = document.getElementById("modal-event");
            if (!modal) {
                console.warn("modal-event non trovata nel DOM");
                return;
            }

            const titleEl = document.getElementById("ev-title");
            if (titleEl) {
                titleEl.textContent = `Evento #${evId}`;
            }

            if (window.SORModals && typeof window.SORModals.openModal === "function") {
                window.SORModals.openModal("#modal-event");
            } else {
                modal.classList.remove("hidden");
                modal.classList.add("is-open");
                document.body.style.overflow = "hidden";
            }

            // evento custom per chi deve caricare i dettagli dell'evento
            document.dispatchEvent(new CustomEvent("sor:event:open", {
                detail: { id: evId }
            }));
        });
    })();
</script>
