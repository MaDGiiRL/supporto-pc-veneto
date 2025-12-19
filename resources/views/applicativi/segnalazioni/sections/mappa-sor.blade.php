<div class="p-6" id="sor-map-page">
    <header class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-semibold">Mappa segnalazioni SOR</h2>
            <p class="text-xs text-slate-500 mt-1">
                I dati sono gli stessi della dashboard SOR (/api/sor/segnalazioni). I punti si aggiornano automaticamente.
            </p>
        </div>

        <div class="flex flex-col items-end gap-1 text-xs">
            <div class="inline-flex items-center gap-2 px-2 py-1 rounded-full border border-slate-300 bg-white/90 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span id="sor-map-last-refresh">Aggiornamento…</span>
            </div>

            <div class="flex flex-wrap gap-2 px-2 py-1 rounded-full border border-slate-200 bg-white/90 shadow-sm">
                <span class="inline-flex items-center gap-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-600"></span> Alta
                </span>
                <span class="inline-flex items-center gap-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span> Media
                </span>
                <span class="inline-flex items-center gap-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Bassa
                </span>
                <span class="inline-flex items-center gap-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-slate-500"></span> Nessuna
                </span>
            </div>
        </div>
    </header>

    <div class="rounded-2xl border border-slate-200 bg-white shadow-card overflow-hidden">
        <div id="sor-map" style="width: 100%; height: 70vh; min-height: 420px;"></div>
    </div>
</div>

<style>
    .sor-map-popup dt {
        font-weight: 600;
        display: inline;
        margin-right: .25rem;
    }

    .sor-map-popup dd {
        display: inline;
        margin: 0;
    }

    .sor-map-popup div+div {
        margin-top: .15rem;
    }

    .sor-map-badge {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        padding: 0 0.5rem;
        font-size: .7rem;
        font-weight: 600;
        background: #e5e7eb;
        color: #374151;
    }

    .sor-map-badge--alta {
        background: #fee2e2;
        color: #b91c1c;
    }

    .sor-map-badge--media {
        background: #ffedd5;
        color: #c2410c;
    }

    .sor-map-badge--bassa {
        background: #dcfce7;
        color: #15803d;
    }
</style>

@push('scripts')
<script>
    (function() {
        // Evita doppia inizializzazione del codice JS (es. con Turbo/Livewire)
        if (window.__SOR_MAP_INIT__) return;
        window.__SOR_MAP_INIT__ = true;

        const MAP_ID = "sor-map";
        const API_BASE = "/api/sor";
        const REFRESH_MS = 10000;

        let map = null;
        let layerGroup = null;

        // 🔹 Dizionario Comune -> [lat, lng]
        const COMUNE_COORDS = {
            "Venezia": [45.440847, 12.315515],
            "Verona": [45.438384, 10.991622],
            "Padova": [45.406435, 11.876761],
            "Treviso": [45.666901, 12.243040],
            "Vicenza": [45.545479, 11.535421],
            "Belluno": [46.138972, 12.217009],
            "Rovigo": [45.070565, 11.790972],
        };

        // ✅ initMap "safe": niente più Map container is already initialized
        function initMap() {
            const el = document.getElementById(MAP_ID);
            if (!el) return null;

            if (typeof L === "undefined") {
                console.error("Leaflet non caricato (L undefined)");
                return null;
            }

            // Se la variabile JS c'è già, riutilizzala
            if (map) {
                return map;
            }

            // Se il container ha già una mappa associata (_leaflet_id),
            // la "resetto" per evitare l'errore Map.js:1094
            if (el._leaflet_id != null) {
                try {
                    el.innerHTML = "";
                    delete el._leaflet_id;
                } catch (e) {
                    el._leaflet_id = null;
                }
            }

            map = L.map(el, {
                scrollWheelZoom: true,
                zoomControl: true,
            });

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors',
            }).addTo(map);

            layerGroup = L.layerGroup().addTo(map);

            // centro indicativo sul Veneto
            map.setView([45.5, 11.8], 8);

            return map;
        }

        function pick(obj, ...keys) {
            for (const k of keys) {
                if (Array.isArray(k)) {
                    let cur = obj,
                        ok = true;
                    for (const p of k) {
                        if (cur && Object.prototype.hasOwnProperty.call(cur, p)) {
                            cur = cur[p];
                        } else {
                            ok = false;
                            break;
                        }
                    }
                    if (ok && cur != null) return cur;
                } else {
                    if (obj && obj[k] != null) return obj[k];
                }
            }
            return undefined;
        }

        function normalizeISO(v) {
            if (!v) return undefined;
            if (typeof v === "number") {
                return (v > 1e12 ? new Date(v) : new Date(v * 1000)).toISOString();
            }
            if (typeof v === "string" &&
                /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/.test(v)) {
                return new Date(v.replace(" ", "T")).toISOString();
            }
            const d = new Date(v);
            if (isNaN(d.getTime())) return undefined;
            return d.toISOString();
        }

        function mapSegToUI(s) {
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

            const lat = pick(s, "lat", "latitude", "latitudine");
            const lng = pick(s, "lng", "longitude", "longitudine");

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
                lat: lat != null && lat !== "" ? Number(lat) : null,
                lng: lng != null && lng !== "" ? Number(lng) : null,
            };
        }

        function prioColor(prio = "Nessuna") {
            const p = (prio || "").toLowerCase();
            if (p === "alta") return "#e11d48";
            if (p === "media") return "#f97316";
            if (p === "bassa") return "#22c55e";
            return "#64748b";
        }

        function prioBadgeClass(prio = "Nessuna") {
            const p = (prio || "").toLowerCase();
            if (p === "alta") return "sor-map-badge sor-map-badge--alta";
            if (p === "media") return "sor-map-badge sor-map-badge--media";
            if (p === "bassa") return "sor-map-badge sor-map-badge--bassa";
            return "sor-map-badge";
        }

        function truncate(str = "", n = 240) {
            if (!str) return "";
            return str.length > n ? str.slice(0, n).trimEnd() + "…" : str;
        }

        function formatDateTime(iso) {
            if (!iso) return "";
            const d = new Date(iso);
            if (Number.isNaN(d.getTime())) return "";
            return d.toLocaleString("it-IT");
        }

        // 🔹 geocoding da comune → [lat, lng]
        function geocodeComune(comune, provincia) {
            if (!comune) return null;

            let name = comune.trim();

            // gestisce "Frazione (Comune)" → prende il Comune
            const parenIdx = name.indexOf("(");
            if (parenIdx > 0) {
                name = name.slice(0, parenIdx).trim();
            }

            // match esatto
            if (COMUNE_COORDS[name]) {
                return COMUNE_COORDS[name];
            }

            // prova uppercase/lowercase
            const norm = name.toLowerCase();
            for (const key of Object.keys(COMUNE_COORDS)) {
                if (key.toLowerCase() === norm) {
                    return COMUNE_COORDS[key];
                }
            }

            return null;
        }

        function getLatLng(s) {
            // 1) se il backend ti dà già lat/lng → usa quelli
            if (s.lat != null && s.lng != null) {
                const la = Number(s.lat);
                const ln = Number(s.lng);
                if (!Number.isNaN(la) && !Number.isNaN(ln)) {
                    return [la, ln];
                }
            }

            // 2) altrimenti prova a geocodificare il comune
            const fromComune = geocodeComune(s.comune, s.provincia);
            if (fromComune) return fromComune;

            return null;
        }

        async function loadSegnalazioni() {
            const url = new URL(API_BASE + "/segnalazioni", window.location.origin);
            url.searchParams.set("per_page", 500);

            const res = await fetch(url.toString(), {
                credentials: "include",
                headers: {
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            if (!res.ok) {
                console.error("Errore HTTP", res.status, res.statusText);
                return [];
            }

            const json = await res.json().catch(() => null);
            if (!json) return [];

            const raw = Array.isArray(json) ? json : (json.data || []);
            console.log("[SOR MAP] segnalazioni ricevute:", raw.length);
            return raw.map(mapSegToUI);
        }

        function updateLastRefreshLabel() {
            const el = document.getElementById("sor-map-last-refresh");
            if (!el) return;
            const d = new Date();
            el.textContent = "Aggiornamento: " + d.toLocaleTimeString("it-IT");
        }

        function updateMarkers(list) {
            const m = initMap();
            if (!m || !layerGroup) return;

            layerGroup.clearLayers();

            const bounds = [];
            let countWithCoords = 0;

            list.forEach((s) => {
                const coord = getLatLng(s);
                if (!coord) return;

                countWithCoords++;
                bounds.push(coord);

                const prio = s.priorita || "Nessuna";
                const color = prioColor(prio);

                const dirRaw = (s.direzione || "").toString().toUpperCase();
                const dir = dirRaw.startsWith("U") ? "U" : "E";

                const titolo = `#${s.id ?? ""} – ${s.comune || (s.ente || "Comune N/D")}`;
                const sintesi = s.oggetto || s.sintesi || s.contenuto || "";
                const dataOra = s.created_at ? formatDateTime(s.created_at) : "";

                const popupHtml = `
                    <div class="sor-map-popup">
                        <h4 class="font-semibold text-sm mb-0.5">${titolo}</h4>
                        <div style="margin-bottom: .25rem;">
                            <span class="${prioBadgeClass(prio)}">${prio}</span>
                            <span style="margin-left:.35rem;font-size:.75rem;opacity:.8;">
                                ${dir === "E" ? "Entrata" : "Uscita"}
                            </span>
                        </div>
                        <dl style="margin:0;font-size:.8rem;">
                            <div>
                                <dt>Data/Ora</dt>
                                <dd>${dataOra || "N/D"}</dd>
                            </div>
                            <div>
                                <dt>Zona</dt>
                                <dd>${s.comune || "N/D"}${s.provincia ? " (" + s.provincia + ")" : ""}</dd>
                            </div>
                            ${s.aree && s.aree.length ? `
                            <div>
                                <dt>Aree</dt>
                                <dd>${(s.aree || []).join(", ")}</dd>
                            </div>` : ""}
                            ${sintesi ? `
                            <div style="margin-top:.25rem;">
                                <dt>Sintesi</dt>
                                <dd>${truncate(sintesi)}</dd>
                            </div>` : ""}
                        </dl>
                    </div>
                `;

                const marker = L.circleMarker(coord, {
                    radius: 8,
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.9,
                    color: "#ffffff",
                    fillColor: color,
                });

                marker.bindTooltip(titolo, {
                    direction: "top",
                    offset: [0, -4],
                    sticky: true,
                    opacity: 0.95,
                });

                marker.bindPopup(popupHtml, {
                    maxWidth: 320,
                });

                layerGroup.addLayer(marker);
            });

            console.log("[SOR MAP] segnalazioni con coordinate:", countWithCoords);

            if (bounds.length) {
                m.fitBounds(bounds, {
                    padding: [30, 30]
                });
            }
        }

        async function refreshMap() {
            try {
                const data = await loadSegnalazioni();
                updateMarkers(data);
                updateLastRefreshLabel();
            } catch (err) {
                console.error("Errore caricamento segnalazioni per mappa:", err);
            }
        }

        // ✅ Init una volta sola, dopo che il DOM è pronto
        document.addEventListener("DOMContentLoaded", function() {
            const el = document.getElementById(MAP_ID);
            if (!el) return;

            initMap();
            refreshMap();
            setInterval(refreshMap, REFRESH_MS);
        });
    })();
</script>
@endpush