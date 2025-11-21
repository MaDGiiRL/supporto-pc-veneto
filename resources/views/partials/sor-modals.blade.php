<!-- MODALE: Dettagli Segnalazione Generica -->
<div class="c-modal c-modal--overlay hidden" id="modal-gen-info" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true" style="max-width:48rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h3 class="mb-2 text-lg font-semibold">Dettagli segnalazione</h3>
        <div id="gen-info-body" class="grid gap-3"></div>
        <div class="flex justify-end mt-3 gap-2">
            <button type="button" class="btn" id="gen-info-print">Stampa</button>
            <button type="button" class="btn btn-primary" id="gen-info-export">⬇️ Scarica Excel</button>
            <button type="button" class="btn" data-close-modal>Chiudi</button>
        </div>
    </div>
</div>

<!-- MODALE: Dettagli Comunicazione Evento (piccola) -->
<div class="c-modal c-modal--overlay hidden" id="modal-ev-info" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true" style="max-width:48rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h3 class="mb-2 text-lg font-semibold">Dettagli comunicazione evento</h3>
        <div id="ev-info-body" class="grid gap-3"></div>
        <div class="flex justify-end mt-3 gap-2">
            <button type="button" class="btn" id="ev-info-print">Stampa</button>
            <button type="button" class="btn btn-primary" id="ev-info-export">⬇️ Scarica Excel</button>
            <button type="button" class="btn" data-close-modal>Chiudi</button>
        </div>
    </div>
</div>

<!-- MODALE EVENTO (grande, con tabella segnalazioni) -->
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
                <button class="btn btn-primary" id="ev-open-form">➕ Nuova segnalazione</button>
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
                                <th class="px-3 py-2">E/U</th>
                                <th class="px-3 py-2 w-sintesi">Oggetto</th>
                                <th class="px-3 py-2">Azioni</th>
                            </tr>
                        </thead>
                        <tbody id="ev-reports-tbody">
                            <tr>
                                <td colspan="6" class="px-3 py-3 opacity-70">Nessuna segnalazione.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
        @includeIf('partials.sor-event-form')
    </div>
</div>

<!-- TUTTE LE COMUNICAZIONI (top 5 eventi + tutte le segnalazioni) -->
<div class="c-modal c-modal--top hidden" id="modal-all-reports" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog c-modal__dialog--xl" role="dialog" aria-modal="true" style="max-width:90rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>

        <header class="mb-4">
            <h3 class="text-lg font-semibold">Tutte le comunicazioni — Eventi in atto</h3>
            <p class="text-xs opacity-70">
                Qui vedi:
                <br>- in alto i 5 eventi in atto più recenti (come card cliccabili)
                <br>- sotto tutte le comunicazioni e segnalazioni generiche di tutti gli eventi.
            </p>
        </header>

        <!-- TOP 5 EVENTI IN ATTO -->
        <section class="mb-4">
            <h4 class="text-sm font-semibold mb-2">Eventi in atto (ultimi 5)</h4>
            <div id="all-reports-top" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                <!-- riempito da JS -->
            </div>
        </section>

        <!-- TUTTE LE SEGNALAZIONI DI TUTTI GLI EVENTI -->
        <section class="rounded-2xl border border-slate-200 bg-white p-3">
            <div class="flex items-center justify-between gap-3 mb-2">
                <h4 class="text-sm font-semibold">Comunicazioni e segnalazioni</h4>
                <div class="text-xs opacity-70">
                    Ordinate dalla più recente alla meno recente.
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
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
                        <!-- riempito da JS -->
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<script type="module">
    (function() {
        const $ = (s) => document.querySelector(s);

        window.SOR_MODAL_STATE = window.SOR_MODAL_STATE || {
            genInfo: null,
            evInfo: null,
        };

        const fmtDT =
            window.fmtDT ||
            ((d) =>
                new Intl.DateTimeFormat("it-IT", {
                    dateStyle: "short",
                    timeStyle: "short",
                }).format(d));

        const TYPE_LABELS = window.TYPE_LABELS || {};

        const makePrioBadge =
            window.makePrioBadge ||
            function(pr = "Nessuna") {
                const s = document.createElement("span");
                s.className = "prio-badge";
                s.textContent = pr || "Nessuna";
                return s;
            };

        const makeDirBadge =
            window.makeDirBadge ||
            function(val) {
                const v = (val || "").toString().trim().toUpperCase();
                const isIn = v === "E" || v === "ENTRATA";
                const s = document.createElement("span");
                s.className = "badge";
                s.textContent = isIn ? "E" : "U";
                s.title = isIn ? "Entrata" : "Uscita";
                return s;
            };

        const toast =
            window.toast ||
            function() {};

        function baseOpenModal(sel) {
            const m = document.querySelector(sel);
            if (!m) return;
            m.classList.remove("hidden");
            m.classList.add("is-open");
            document.body.style.overflow = "hidden";
        }

        function baseCloseModal(el) {
            if (!el) return;
            el.classList.remove("is-open");
            el.classList.add("hidden");
            if (!document.querySelector(".c-modal.is-open")) {
                document.body.style.overflow = "";
            }
        }

        function topmostOpenModal() {
            const opens = Array.from(document.querySelectorAll(".c-modal.is-open"));
            return opens.length ? opens[opens.length - 1] : null;
        }

        function closeTopModal() {
            const m = topmostOpenModal();
            if (m) baseCloseModal(m);
        }

        // evento principale "in sovra-livello"
        document.getElementById("modal-event")?.classList.add("c-modal--super");

        // ========== MODALE "READ MORE" TESTO LUNGO ==========
        function ensureReadMoreModal() {
            if ($("#modal-readmore")) return;
            const wrap = document.createElement("div");
            wrap.className = "c-modal hidden";
            wrap.id = "modal-readmore";
            wrap.setAttribute("aria-hidden", "true");
            wrap.innerHTML = `
        <div class="c-modal__backdrop" data-close-modal></div>
        <div class="c-modal__dialog" role="dialog" aria-modal="true">
            <button type="button" class="c-modal__close" data-close-modal>✕</button>
            <h3 id="rm-title" class="mb-2 text-lg font-semibold">Dettagli</h3>
            <div id="rm-body" class="rm-body text-sm"></div>
            <div class="flex justify-end mt-4">
                <button type="button" class="btn" data-close-modal>Chiudi</button>
            </div>
        </div>`;
            document.body.appendChild(wrap);
        }

        function openReadMore(title, text) {
            ensureReadMoreModal();
            const t = $("#rm-title");
            const b = $("#rm-body");
            if (t) t.textContent = title || "Dettagli";
            if (b) b.textContent = text || "—";
            baseOpenModal("#modal-readmore");
        }

        // ========== DETTAGLI SEGNALAZIONE GENERICA ==========
        function genInfoRows(rec) {
            const typeLabel = TYPE_LABELS[rec.tipologia] || rec.tipologia || "—";
            const created = rec.created_at ? new Date(rec.created_at) : null;
            const when = created && !isNaN(created) ? fmtDT(created) : "—";
            const evText = rec.event_id ? `Evento #${rec.event_id}` : "—";

            return [
                ["ID", String(rec.id)],
                ["Data/Ora", when],
                [
                    "Direzione",
                    (rec.direzione || "E").toUpperCase() === "U" ?
                    "Uscita (U)" :
                    "Entrata (E)",
                ],
                ["Tipologia evento", typeLabel],
                ["Tipo comunicazione", rec.tipo || "—"],
                ["Comune", rec.comune || "—"],
                ["Aree interessate", (rec.aree || []).join(", ") || "—"],
                ["Mittente/Destinatario", rec.mitt_dest || "—"],
                ["Telefono", rec.telefono || "—"],
                ["E-mail", rec.email || "—"],
                ["Indirizzo", rec.indirizzo || "—"],
                ["Provincia", rec.provincia || "—"],
                ["Operatore", rec.operatore || "—"],
                ["Priorità", rec.priorita || "Nessuna"],
                ["Evento associato", evText],
                ["Oggetto", rec.oggetto || "—"],
                ["Contenuto", rec.contenuto || "—"],
            ];
        }

        function showGenInfo(rec) {
            const body = document.querySelector("#gen-info-body");
            if (!body) return;

            const rows = genInfoRows(rec);
            const tbl = document.createElement("table");
            tbl.className = "w-full text-sm";
            tbl.innerHTML = `
      <tbody>
        ${rows
            .map(
                ([k, v]) =>
                    `<tr class="border-t border-slate-200">
                        <td class="px-3 py-2 font-semibold w-44">${k}</td>
                        <td class="px-3 py-2">${v}</td>
                    </tr>`
            )
            .join("")}
      </tbody>
    `;
            body.replaceChildren(tbl);

            const pr = rec.priorita || "Nessuna";
            const dir = (rec.direzione || "E").toUpperCase() === "U" ? "U" : "E";
            const prBadge = makePrioBadge(pr);
            const dirBadge = makeDirBadge(dir);
            const tds = body.querySelectorAll("tbody tr td:nth-child(2)");

            // direzione
            if (tds[2]) {
                tds[2].textContent = "";
                tds[2].appendChild(dirBadge.cloneNode(true));
            }
            // priorità
            if (tds[12]) {
                tds[12].textContent = "";
                tds[12].appendChild(prBadge);
            }

            window.SOR_MODAL_STATE.genInfo = {
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
                oggetto: rec.oggetto || "",
                comune: rec.comune || "",
                telefono: rec.telefono || "",
                email: rec.email || "",
                indirizzo: rec.indirizzo || "",
                provincia: rec.provincia || "",
            };

            baseOpenModal("#modal-gen-info");
        }

        // ========== DETTAGLI COMUNICAZIONE EVENTO ==========
        function showEvInfo(r) {
            const body = document.querySelector("#ev-info-body");
            if (!body) return;

            const rows = [
                ["Data", r.data || "—"],
                ["Ora", r.ora || "—"],
                ["Tipo comunicazione", r.tipo || "—"],
                ["Verso", (r.verso || "").toString()],
                ["Mittente/Destinatario", r.mitt || "—"],
                ["Telefono", r.tel || "—"],
                ["E-mail", r.mail || "—"],
                ["Indirizzo", r.indirizzo || "—"],
                ["Provincia", r.provincia || "—"],
                ["Comune", r.comune || "—"],
                ["Aree interessate", (r.aree || []).join(", ") || "—"],
                ["Oggetto", r.oggetto || "—"],
                ["Priorità", r.priorita || "Nessuna"],
                ["Contenuto", r.contenuto || "—"],
            ];

            const tbl = document.createElement("table");
            tbl.className = "w-full text-sm";
            tbl.innerHTML = `
      <tbody>
        ${rows
            .map(
                ([k, v]) =>
                    `<tr class="border-t border-slate-200">
                        <td class="px-3 py-2 font-semibold w-44">${k}</td>
                        <td class="px-3 py-2">${v}</td>
                    </tr>`
            )
            .join("")}
      </tbody>
    `;
            body.replaceChildren(tbl);

            const tds = body.querySelectorAll("tbody tr td:nth-child(2)");

            const raw = (r.verso || "").toString().trim().toUpperCase();
            const dir = raw.startsWith("U") ? "U" : "E";
            if (tds[3]) {
                tds[3].textContent = "";
                tds[3].appendChild(makeDirBadge(dir));
            }

            if (tds[12]) {
                tds[12].textContent = "";
                tds[12].appendChild(makePrioBadge(r.priorita || "Nessuna"));
            }

            window.SOR_MODAL_STATE.evInfo = {
                ...r,
                event_id: r.event_id ?? null,
            };

            baseOpenModal("#modal-ev-info");
        }

        // ========== EXPORT / PRINT ==========
        function downloadCSVFromObject(obj, filename) {
            if (!obj) return;
            const headers = Object.keys(obj);
            const row = headers.map((k) => {
                const v = obj[k] == null ? "" : String(obj[k]);
                return '"' + v.replace(/"/g, '""') + '"';
            });
            const csv = headers.join(";") + "\n" + row.join(";");

            const blob = new Blob([csv], {
                type: "text/csv;charset=utf-8;",
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        function printElement(selector, title) {
            const el = document.querySelector(selector);
            if (!el) return;

            const css = document.querySelector("style")?.textContent || "";
            const win = window.open("", "_blank", "width=1024,height=768");
            win.document.write(
                `<html><head><title>${title}</title><style>${css}</style></head><body>${el.innerHTML}</body></html>`
            );
            win.document.close();
            win.focus();
            win.print();
            win.close();
        }

        function exportGenInfoToCSV() {
            const rec = window.SOR_MODAL_STATE.genInfo;
            if (!rec) {
                toast("Nessuna segnalazione", "Apri prima una segnalazione.", "info");
                return;
            }
            const filename = `segnalazione_${rec.id || "dettaglio"}.csv`;
            downloadCSVFromObject(rec, filename);
        }

        function printGenInfo() {
            printElement("#gen-info-body", "Dettagli segnalazione");
        }

        function exportEvInfoToCSV() {
            const rec = window.SOR_MODAL_STATE.evInfo;
            if (!rec) {
                toast(
                    "Nessuna comunicazione",
                    "Apri prima una comunicazione evento.",
                    "info"
                );
                return;
            }
            const evId = rec.event_id || "evento";
            const filename = `comunicazione_evento_${evId}.csv`;
            downloadCSVFromObject(rec, filename);
        }

        function printEvInfo() {
            printElement("#ev-info-body", "Dettagli comunicazione evento");
        }

        // ========== HANDLER CLICK / ESC ==========
        document.addEventListener("click", (e) => {
            const opener = e.target.closest("[data-open-modal]");
            if (opener && !e.defaultPrevented) {
                e.preventDefault();
                const sel = opener.getAttribute("data-open-modal");
                if (sel) baseOpenModal(sel);
                return;
            }

            if (
                e.target.closest("[data-close-modal]") ||
                e.target.classList.contains("c-modal__backdrop")
            ) {
                const modal = e.target.closest(".c-modal");
                if (modal) baseCloseModal(modal);
            }

            if (e.target.id === "gen-info-export" || e.target.closest("#gen-info-export")) {
                exportGenInfoToCSV();
                return;
            }
            if (e.target.id === "gen-info-print" || e.target.closest("#gen-info-print")) {
                printGenInfo();
                return;
            }
            if (e.target.id === "ev-info-export" || e.target.closest("#ev-info-export")) {
                exportEvInfoToCSV();
                return;
            }
            if (e.target.id === "ev-info-print" || e.target.closest("#ev-info-print")) {
                printEvInfo();
                return;
            }
        });

        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
                const m = topmostOpenModal();
                if (m) {
                    e.preventDefault();
                    baseCloseModal(m);
                }
            }
        });

        document.addEventListener("api:write:success", () => {
            closeTopModal();
        });

        // Espongo API modali
        const existing = window.SORModals || {};
        window.SORModals = {
            ...existing,
            showGenInfo,
            showEvInfo,
            openModal: baseOpenModal,
            closeModal: baseCloseModal,
            closeTopModal,
            openReadMore,
        };
    })();
</script>