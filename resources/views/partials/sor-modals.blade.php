{{-- ================= MODALE: NUOVA SEGNALAZIONE GENERICA ================= --}}
<div class="c-modal c-modal--overlay hidden" id="modal-gen" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true" tabindex="-1" style="max-width:72rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>

        <header class="mb-3">
            <h3 class="text-lg font-semibold">Nuova segnalazione generica</h3>
            <p class="text-xs opacity-70 mt-1">I campi “dinamici” dipendono dalla tipologia e vengono salvati nel contenuto.</p>
        </header>

        <form id="form-gen" class="grid gap-4">
            @csrf

            <div class="grid md:grid-cols-2 gap-3">
                <label class="grid gap-1">
                    <span class="label">Data (gg/mm/aaaa)</span>
                    <input class="input" id="g-data" name="data" placeholder="gg/mm/aaaa" />
                </label>
                <label class="grid gap-1">
                    <span class="label">Ora (hh:mm)</span>
                    <input class="input" id="g-ora" name="ora" placeholder="hh:mm" />
                </label>

                <label class="grid gap-1">
                    <span class="label">Verso</span>
                    <div class="flex gap-3">
                        <label class="flex items-center gap-2"><input type="radio" name="g-verso" value="E" checked> Entrata</label>
                        <label class="flex items-center gap-2"><input type="radio" name="g-verso" value="U"> Uscita</label>
                    </div>
                </label>

                <label class="grid gap-1">
                    <span class="label">Tipologia</span>
                    <select class="input" id="gen-tipologia" name="tipologia">
                        <option value="altro">Altro</option>
                        <option value="sismico">Sismico</option>
                        <option value="vulcanico">Vulcanico</option>
                        <option value="idraulico">Idraulico</option>
                        <option value="idrogeologico">Idrogeologico</option>
                        <option value="maremoto">Maremoto</option>
                        <option value="deficit-idrico">Deficit Idrico</option>
                        <option value="meteo-avverso">Meteo Avverso</option>
                        <option value="aib">AIB</option>
                        <option value="uomo">Prodotti dall'uomo</option>
                    </select>
                </label>
            </div>

            <div class="grid md:grid-cols-2 gap-3">
                <label class="grid gap-1">
                    <span class="label">Provincia</span>
                    <select class="input" id="g-provincia" name="provincia"></select>
                </label>
                <label class="grid gap-1">
                    <span class="label">Comune</span>
                    <select class="input" id="g-comune" name="comune" disabled></select>
                </label>
            </div>

            <div class="grid gap-1">
                <span class="label">Aree interessate</span>
                <div id="gen-aree"></div>
                <input type="hidden" id="gen-aree-hidden" name="aree" value="[]">
            </div>

            {{-- campi base --}}
            <div class="grid md:grid-cols-2 gap-3">
                <label class="grid gap-1"><span class="label">Mittente/Destinatario</span><input class="input" id="g-mitt" /></label>
                <label class="grid gap-1"><span class="label">Tipo comunicazione</span><input class="input" id="g-tipo" placeholder="Email/Telefono/PEC/..." /></label>
                <label class="grid gap-1"><span class="label">Telefono</span><input class="input" id="g-tel" /></label>
                <label class="grid gap-1"><span class="label">Email</span><input class="input" id="g-mail" type="email" /></label>
            </div>

            <label class="grid gap-1"><span class="label">Indirizzo</span><input class="input" id="g-indirizzo" /></label>

            <div class="grid md:grid-cols-2 gap-3">
                <label class="grid gap-1"><span class="label">Oggetto</span><input class="input" id="g-oggetto" /></label>
                <label class="grid gap-1">
                    <span class="label">Evento (associazione)</span>
                    <select class="input" id="gen-event-select"></select>
                </label>
            </div>

            <label class="grid gap-1"><span class="label">Contenuto</span><textarea class="input" id="g-contenuto" rows="4"></textarea></label>

            {{-- dinamici --}}
            <div id="gen-specific" class="rounded-2xl border border-slate-200 bg-white p-4">
                {{-- riempito da JS --}}
                <div class="text-xs opacity-70">Campi aggiuntivi tipologia: —</div>
            </div>

            {{-- mappa + coords --}}
            <section class="rounded-2xl border border-slate-200 bg-white p-4">
                <div class="flex items-center justify-between gap-2 mb-2 flex-wrap">
                    <div>
                        <div class="text-sm font-semibold">Posizione</div>
                        <div class="text-xs opacity-70">Clic sulla mappa per piazzare il puntino. Trascina se hai permessi.</div>
                    </div>
                    <button type="button" class="btn-xs" id="gen-clear-coords">✕ Rimuovi posizione</button>
                </div>

                <div id="gen-map" class="w-full rounded-2xl border border-slate-200" style="height:280px"></div>

                <div class="grid md:grid-cols-2 gap-3 mt-3">
                    <label class="grid gap-1"><span class="label">Lat</span><input class="input" id="g-lat" /></label>
                    <label class="grid gap-1"><span class="label">Lng</span><input class="input" id="g-lng" /></label>
                </div>
            </section>

            <div class="grid md:grid-cols-1 gap-3">
                <label class="grid gap-1">
                    <span class="label">Priorità</span>
                    <div class="flex flex-wrap gap-3">
                        <label class="flex items-center gap-2"><input type="radio" name="priorita" value="Nessuna" checked> Nessuna</label>
                        <label class="flex items-center gap-2"><input type="radio" name="priorita" value="Bassa"> Bassa</label>
                        <label class="flex items-center gap-2"><input type="radio" name="priorita" value="Media"> Media</label>
                        <label class="flex items-center gap-2"><input type="radio" name="priorita" value="Alta"> Alta</label>
                    </div>
                </label>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" class="btn" data-close-modal>Annulla</button>
                <button type="submit" class="btn btn-primary">Salva</button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODALE: MODIFICA SEGNALAZIONE ================= --}}
<div class="c-modal c-modal--overlay hidden" id="modal-edit-gen" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true" tabindex="-1" style="max-width:64rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>

        <header class="mb-3">
            <h3 class="text-lg font-semibold">Modifica segnalazione</h3>
            <p class="text-xs opacity-70 mt-1">Modifica rapida: direzione, priorità, sintesi, aree, evento.</p>
        </header>

        <form id="form-edit-gen" class="grid gap-4">
            @csrf
            <input type="hidden" name="id" />

            <div class="grid md:grid-cols-2 gap-3">
                <label class="grid gap-1">
                    <span class="label">Direzione</span>
                    <select class="input" name="direzione">
                        <option value="E">Entrata (E)</option>
                        <option value="U">Uscita (U)</option>
                    </select>
                </label>

                <label class="grid gap-1">
                    <span class="label">Priorità</span>
                    <select class="input" name="priorita">
                        <option value="Nessuna">Nessuna</option>
                        <option value="Bassa">Bassa</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                    </select>
                </label>
            </div>

            <div class="grid md:grid-cols-2 gap-3">
                <label class="grid gap-1"><span class="label">Operatore</span><input class="input" name="operatore" /></label>
                <label class="grid gap-1"><span class="label">Data/Ora creazione</span><input class="input" type="datetime-local" name="created_at" /></label>
            </div>

            <label class="grid gap-1"><span class="label">Sintesi</span><input class="input" name="sintesi" /></label>

            <div class="grid gap-1">
                <span class="label">Aree interessate</span>
                <div id="edit-aree"></div>
                <input type="hidden" id="edit-aree-hidden" name="aree" value="[]">
            </div>

            <label class="grid gap-1">
                <span class="label">Evento (associazione)</span>
                <select class="input" id="edit-gen-event" name="event_id"></select>
            </label>

            <div class="flex justify-end gap-2">
                <button type="button" class="btn" data-close-modal>Annulla</button>
                <button type="submit" class="btn btn-primary">Salva modifiche</button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODALE: DETTAGLI SEGNALAZIONE ================= --}}
<div class="c-modal c-modal--overlay hidden" id="modal-gen-info" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true" tabindex="-1" style="max-width:56rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>

        <header class="mb-3">
            <h3 class="text-lg font-semibold">Dettagli segnalazione</h3>
            <p class="text-xs opacity-70 mt-1">Dati completi e leggibili, con badge e link mappa.</p>
        </header>

        <div id="gen-info-body" class="info-grid"></div>

        <div class="flex justify-end mt-3">
            <button type="button" class="btn" data-close-modal>Chiudi</button>
        </div>
    </div>
</div>

{{-- ================= MODALE: EVENTO ================= --}}
<div class="c-modal hidden" id="modal-event" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true" tabindex="-1" style="max-width:78rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>

        <header class="flex items-start justify-between gap-3 mb-3">
            <div class="min-w-0">
                <h3 id="ev-title" class="text-lg font-semibold truncate">Evento</h3>
                <p id="ev-subtitle" class="text-xs opacity-70 mt-1 truncate">—</p>
            </div>

            <div class="flex items-center gap-2 shrink-0 flex-wrap">
                <button class="btn-xs" type="button" id="ev-toggle-open">…</button>
                <button class="btn btn-primary" type="button" data-open-modal="#modal-ev-form">➕ Nuova comunicazione</button>
                <a class="btn-xs" id="ev-export-single" href="#" style="text-decoration:none">⬇️ Excel evento</a>
            </div>
        </header>

        <div class="grid gap-4">
            <section class="rounded-2xl border border-slate-200 bg-white p-4">
                <h4 class="text-sm font-semibold mb-2">Aree interessate</h4>
                <div id="ev-areas" class="tags"></div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-4">
                <h4 class="text-sm font-semibold mb-3">Comunicazioni / Segnalazioni collegate</h4>
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
                                <td colspan="5" class="px-3 py-3 opacity-70">Nessuna segnalazione.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <div class="flex justify-end mt-3">
            <button type="button" class="btn" data-close-modal>Chiudi</button>
        </div>
    </div>
</div>

{{-- ================= MODALE: NUOVA COMUNICAZIONE EVENTO ================= --}}
<div class="c-modal c-modal--overlay hidden" id="modal-ev-form" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true" tabindex="-1" style="max-width:60rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>

        <header class="mb-3">
            <h4 class="text-lg font-semibold">Nuova comunicazione evento</h4>
            <p class="text-xs opacity-70 mt-1">Collegata all’evento corrente. Mappa con puntino + aree con tag.</p>
        </header>

        @includeIf('partials.sor-event-form')
    </div>
</div>

{{-- ================= MODALE: TUTTE LE COMUNICAZIONI ================= --}}
<div class="c-modal c-modal--overlay hidden" id="modal-all-reports" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true" tabindex="-1" style="max-width:90rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>

        <header class="flex items-start justify-between gap-3 mb-3">
            <div class="min-w-0">
                <h3 class="text-lg font-semibold truncate">Tutte le comunicazioni</h3>
                <p class="text-xs opacity-70 mt-1 truncate" id="allrep-subtitle">Vista aggregata delle comunicazioni evento.</p>
            </div>
            <div class="flex items-center gap-2 shrink-0 flex-wrap">
                <button class="btn-xs" id="allrep-refresh" type="button">↻ Aggiorna</button>
                <button class="btn-xs" id="allrep-export" type="button">⬇️ CSV</button>
            </div>
        </header>

        <section class="rounded-2xl border border-slate-200 bg-white p-4 mb-3">
            <div class="grid md:grid-cols-4 gap-3">
                <label class="grid gap-1">
                    <span class="label">Cerca</span>
                    <input class="input" id="allrep-q" placeholder="Oggetto / contenuto / mittente / comune…" />
                </label>
                <label class="grid gap-1">
                    <span class="label">Dal</span>
                    <input class="input" id="allrep-dal" type="date" />
                </label>
                <label class="grid gap-1">
                    <span class="label">Al</span>
                    <input class="input" id="allrep-al" type="date" />
                </label>
                <label class="grid gap-1">
                    <span class="label">Verso</span>
                    <select class="input" id="allrep-verso">
                        <option value="">Tutti</option>
                        <option value="E">Entrata (E)</option>
                        <option value="U">Uscita (U)</option>
                    </select>
                </label>
            </div>

            <div class="flex justify-between items-center mt-3 gap-2 flex-wrap">
                <div class="flex items-center gap-2">
                    <button class="btn btn-xs" id="allrep-reset" type="button">Reset filtri</button>
                    <span class="text-xs opacity-70" id="allrep-count">—</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs opacity-70">Ordina:</span>
                    <select class="input" id="allrep-sort" style="max-width:240px">
                        <option value="desc" selected>Più recenti</option>
                        <option value="asc">Meno recenti</option>
                    </select>
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-4">
            <div class="overflow-x-auto">
                <table class="w-full text-sm" id="tbl-allrep">
                    <thead class="text-left">
                        <tr>
                            <th class="px-3 py-2">Data</th>
                            <th class="px-3 py-2">Ora</th>
                            <th class="px-3 py-2">E/U</th>
                            <th class="px-3 py-2">Evento</th>
                            <th class="px-3 py-2">Comune</th>
                            <th class="px-3 py-2 w-sintesi">Oggetto</th>
                            <th class="px-3 py-2">Priorità</th>
                        </tr>
                    </thead>
                    <tbody id="allrep-body">
                        <tr>
                            <td colspan="7" class="px-3 py-3 opacity-70">Caricamento…</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="pager mt-2 flex items-center justify-center gap-2">
                <button class="btn-xs" id="allrep-prev" type="button">«</button>
                <span class="pager__label text-xs" id="allrep-page">Pagina 1 di 1</span>
                <button class="btn-xs" id="allrep-next" type="button">»</button>
            </div>
        </section>

        <div class="flex justify-end mt-3">
            <button type="button" class="btn" data-close-modal>Chiudi</button>
        </div>
    </div>
</div>


@push('scripts')
<script type="module">
    (() => {
        function boot() {
            if (!globalThis.SOR || !globalThis.SOR.state) return false;

            const modalStack = [];
            const focusRestore = new Map();

            const baseZNormal = 2000;
            const baseZTop = 20000;

            function isTopModal(modalEl) {
                // INFO + EDIT sempre sopra a tutte le altre
                return modalEl?.id === "modal-edit-gen" || modalEl?.id === "modal-gen-info";
            }

            const getFocusable = (root) =>
                Array.from(root.querySelectorAll([
                    'a[href]',
                    'button:not([disabled])',
                    'input:not([disabled])',
                    'select:not([disabled])',
                    'textarea:not([disabled])',
                    '[tabindex]:not([tabindex="-1"])'
                ].join(","))).filter(el => !!(el.offsetWidth || el.offsetHeight || el.getClientRects().length));

            const setInert = (on) => {
                const app = document.getElementById("app");
                if (!app) return;
                if (on) app.setAttribute("inert", "");
                else app.removeAttribute("inert");
            };

            function applyFullscreen(modalEl, full) {
                const dlg = modalEl?.querySelector(".c-modal__dialog");
                if (!dlg) return;

                if (full) {
                    modalEl.classList.add("is-full");
                    dlg.style.width = "min(98vw, 96rem)";
                    dlg.style.maxWidth = "98vw";
                    dlg.style.height = "94vh";
                    dlg.style.maxHeight = "94vh";
                    dlg.style.margin = "2vh auto";
                } else {
                    modalEl.classList.remove("is-full");
                    dlg.style.width = "";
                    dlg.style.maxWidth = "";
                    dlg.style.height = "";
                    dlg.style.maxHeight = "";
                    dlg.style.margin = "";
                }
            }

            function applyStackZ() {
                const normals = modalStack.filter(m => !isTopModal(m));
                const tops = modalStack.filter(m => isTopModal(m));

                normals.forEach((m, i) => {
                    m.style.zIndex = String(baseZNormal + i * 20);
                });
                tops.forEach((m, i) => {
                    m.style.zIndex = String(baseZTop + i * 20);
                });
            }

            function openModal(selOrEl, openerEl = null, {
                full = true
            } = {}) {
                const m = typeof selOrEl === "string" ? document.querySelector(selOrEl) : selOrEl;
                if (!m) return;

                focusRestore.set(m, openerEl || document.activeElement);

                m.classList.remove("hidden");
                m.classList.add("is-open");
                m.setAttribute("aria-hidden", "false");

                applyFullscreen(m, full);

                // sposta in cima
                const idx = modalStack.indexOf(m);
                if (idx >= 0) modalStack.splice(idx, 1);
                modalStack.push(m);

                applyStackZ();

                document.body.style.overflow = "hidden";
                setInert(true);

                const focusables = getFocusable(m);
                (focusables[0] || m.querySelector(".c-modal__dialog") || m).focus?.({
                    preventScroll: true
                });

                document.dispatchEvent(new CustomEvent("modal:open", {
                    detail: {
                        id: "#" + m.id
                    }
                }));
            }

            function closeModal(selOrEl) {
                const m = typeof selOrEl === "string" ? document.querySelector(selOrEl) : selOrEl;
                if (!m) return;

                if (document.activeElement && m.contains(document.activeElement)) document.activeElement.blur?.();

                m.classList.remove("is-open");
                m.classList.add("hidden");
                m.setAttribute("aria-hidden", "true");

                const idx = modalStack.indexOf(m);
                if (idx >= 0) modalStack.splice(idx, 1);
                applyStackZ();

                if (!modalStack.length) {
                    document.body.style.overflow = "";
                    setInert(false);
                }

                const prev = focusRestore.get(m);
                focusRestore.delete(m);
                prev?.focus?.({
                    preventScroll: true
                });

                document.dispatchEvent(new CustomEvent("modal:close", {
                    detail: {
                        id: "#" + m.id
                    }
                }));
            }

            function closeTopModal() {
                const top = modalStack[modalStack.length - 1];
                if (top) closeModal(top);
            }

            /* ================= LEAFLET MAPS (invalidateSize quando apro modali) ================= */
            const Maps = globalThis.SORMaps || (globalThis.SORMaps = {});
            const leafletAvailable = () => !!globalThis.L && typeof globalThis.L.map === "function";

            const invalidateOnNextFrame = (map) => {
                if (!map) return;
                requestAnimationFrame(() => {
                    try {
                        map.invalidateSize(true);
                    } catch {}
                });
            };

            function initLeafletMap({
                key,
                containerId,
                latInput,
                lngInput,
                clearBtnId
            }) {
                if (!leafletAvailable()) return;

                const el = document.getElementById(containerId);
                if (!el) return;

                if (Maps[key]?.map) {
                    invalidateOnNextFrame(Maps[key].map);
                    return;
                }

                const map = L.map(el, {
                    zoomControl: true
                }).setView([41.9, 12.5], 6);
                L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                    maxZoom: 19,
                    attribution: "&copy; OpenStreetMap",
                }).addTo(map);

                let marker = null;
                const setMarker = (lat, lng) => {
                    if (!marker) marker = L.marker([lat, lng], {
                        draggable: true
                    }).addTo(map);
                    else marker.setLatLng([lat, lng]);

                    if (latInput) latInput.value = String(lat);
                    if (lngInput) lngInput.value = String(lng);

                    marker.off("dragend");
                    marker.on("dragend", () => {
                        const p = marker.getLatLng();
                        if (latInput) latInput.value = String(p.lat);
                        if (lngInput) lngInput.value = String(p.lng);
                    });
                };

                map.on("click", (ev) => setMarker(ev.latlng.lat, ev.latlng.lng));

                const clearBtn = clearBtnId ? document.getElementById(clearBtnId) : null;
                clearBtn?.addEventListener("click", () => {
                    if (marker) {
                        map.removeLayer(marker);
                        marker = null;
                    }
                    if (latInput) latInput.value = "";
                    if (lngInput) lngInput.value = "";
                });

                Maps[key] = {
                    map,
                    setMarker
                };
                invalidateOnNextFrame(map);
            }

            function initGenModal() {
                initLeafletMap({
                    key: "gen",
                    containerId: "gen-map",
                    latInput: document.getElementById("g-lat"),
                    lngInput: document.getElementById("g-lng"),
                    clearBtnId: "gen-clear-coords",
                });
            }

            function initEvForm() {
                initLeafletMap({
                    key: "ev",
                    containerId: "ev-map",
                    latInput: document.getElementById("ev-lat"),
                    lngInput: document.getElementById("ev-lng"),
                    clearBtnId: "ev-clear-coords",
                });
            }

            // quando apro qualsiasi modale, invalido mappe già create
            document.addEventListener("modal:open", () => {
                Object.values(Maps).forEach(v => v?.map && invalidateOnNextFrame(v.map));
            });

            /* ================= CLICK / ESC ================= */
            const OPEN_HOOKS = {
                "#modal-gen": () => {
                    initGenModal();
                },
                "#modal-ev-form": () => {
                    initEvForm();
                },
            };

            document.addEventListener("click", (e) => {
                const opener = e.target.closest("[data-open-modal]");
                if (opener) {
                    e.preventDefault();
                    const sel = opener.getAttribute("data-open-modal");
                    if (!sel) return;
                    OPEN_HOOKS[sel]?.();
                    openModal(sel, opener, {
                        full: true
                    });
                    return;
                }

                if (e.target.closest("[data-close-modal]") || e.target.classList.contains("c-modal__backdrop")) {
                    const modal = e.target.closest(".c-modal");
                    if (modal) closeModal(modal);
                }
            });

            document.addEventListener("keydown", (e) => {
                if (e.key === "Escape") {
                    const top = modalStack[modalStack.length - 1];
                    if (top) {
                        e.preventDefault();
                        closeModal(top);
                    }
                }
            });

            // opzionale: chiudi modale dopo salvataggi backend (se già lo usi)
            document.addEventListener("api:write:success", () => closeTopModal());

            // export
            globalThis.SORModals = {
                ...(globalThis.SORModals || {}),
                openModal,
                closeModal,
                closeTopModal,
                initGenModal,
                initEvForm,
            };

            return true;
        }

        if (!boot()) {
            // ascolto ready coerente + compat
            window.addEventListener("sor:ready", () => boot(), {
                once: true
            });
            window.addEventListener("SOR:ready", () => boot(), {
                once: true
            });
        }
    })();
</script>
@endpush