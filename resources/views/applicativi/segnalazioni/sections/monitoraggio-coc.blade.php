@php
// --- Mock dati come nel componente React ---
$stats = ['BL'=>8,'PD'=>36,'RO'=>23,'TV'=>28,'VE'=>27,'VI'=>16,'VR'=>14];
$totale = array_sum($stats);

$comuni = [
['prov'=>'BL','comune'=>'Arsiè','categoria'=>'aperta h24','data'=>'16/08/2025 00:00','lat'=>45.953,'lon'=>11.740],
['prov'=>'BL','comune'=>'Arsiè','categoria'=>'aperta orario diurno','data'=>'16/08/2025 00:00','lat'=>45.953,'lon'=>11.740],
['prov'=>'RO','comune'=>'Adria','categoria'=>'aperta h24','data'=>'20/08/2025 08:00','lat'=>45.054,'lon'=>12.057],
];
$province = array_keys($stats);
@endphp

<div class="p-6">
    <header class="mb-4">
        <h2 class="text-xl font-semibold">Monitoraggio COC</h2>
    </header>

    {{-- Ricerca periodo --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white shadow-card p-4 sm:p-6">
        <p class="mb-3 flex items-start gap-2 rounded-md bg-blue-50 px-3 py-2 text-sm text-blue-700">
            <x-heroicon-o-information-circle class="mt-0.5 h-4 w-4 shrink-0" />
            <span>
                <strong>AVVISO:</strong> I dati mostrati sono solo quelli completamente contenuti
                nell’intervallo di date/ore selezionato.
            </span>
        </p>

        <div class="grid gap-4 md:grid-cols-4">
            <label class="grid gap-1.5 text-sm">
                <span class="inline-flex items-center gap-1.5 font-medium text-slate-700">
                    <x-heroicon-o-calendar-days class="h-4 w-4" /> Data inizio
                </span>
                <input id="dt-inizio" type="datetime-local" value="2025-08-01T00:00"
                    class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                              focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
            </label>

            <label class="grid gap-1.5 text-sm">
                <span class="inline-flex items-center gap-1.5 font-medium text-slate-700">
                    <x-heroicon-o-calendar-days class="h-4 w-4" /> Data fine
                </span>
                <input id="dt-fine" type="datetime-local" value="2025-08-31T23:59"
                    class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                              focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
            </label>

            <label class="grid gap-1.5 text-sm">
                <span class="inline-flex items-center gap-1.5 font-medium text-slate-700">
                    <x-heroicon-o-map-pin class="h-4 w-4" /> Provincia
                </span>
                <select id="sel-provincia"
                    class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                               focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500">
                    <option value="ALL">Tutte le Province</option>
                    @foreach ($province as $p) <option value="{{ $p }}">{{ $p }}</option> @endforeach
                </select>
            </label>

            <div class="flex items-end">
                <button id="btn-cerca-coc"
                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl h-10 px-4 text-sm font-medium
                               bg-brand-600 text-white hover:bg-brand-700
                               focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-brand-500">
                    <x-heroicon-o-magnifying-glass class="h-4 w-4" />
                    Cerca COC
                </button>
            </div>
        </div>
    </div>

    {{-- Statistiche --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white shadow-card p-4 sm:p-6">
        <div class="mb-3 flex items-center justify-between">
            <h3 class="inline-flex items-center gap-2 text-base font-semibold text-slate-800">
                <x-heroicon-o-chart-bar class="h-5 w-5" /> Statistiche per provincia
            </h3>
            <button id="btn-print"
                class="inline-flex items-center gap-2 rounded-xl h-10 px-4 text-sm font-medium
                           bg-brand-600 text-white hover:bg-brand-700
                           focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-brand-500">
                <x-heroicon-o-printer class="h-4 w-4" />
                Stampa Report
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-3 py-2 text-left">
                            <span class="inline-flex items-center gap-1.5">
                                <x-heroicon-o-hashtag class="h-4 w-4" /> Totale
                            </span>
                        </th>
                        @foreach ($stats as $k => $v)
                        <th class="px-3 py-2 text-left">
                            <span class="inline-flex items-center gap-1.5">
                                <x-heroicon-o-map-pin class="h-4 w-4" /> {{ $k }}
                            </span>
                        </th>
                        @endforeach
                        <th class="px-3 py-2 text-left">
                            <span class="inline-flex items-center gap-1.5">
                                <x-heroicon-o-hashtag class="h-4 w-4" /> Totale
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-3 py-2 font-medium">COC attivati</td>
                        @foreach ($stats as $v)
                        <td class="px-3 py-2">{{ $v }}</td>
                        @endforeach
                        <td class="px-3 py-2 font-semibold">{{ $totale }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Comuni + mappa --}}
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card p-4 sm:p-6">
            <h3 class="mb-3 inline-flex items-center gap-2 text-base font-semibold text-slate-800">
                <x-heroicon-o-building-office class="h-5 w-5" />
                Comuni con COC attivati
                <span class="ml-2 inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-0.5 text-xs font-normal">
                    <x-heroicon-o-hashtag class="h-3.5 w-3.5" /> {{ $totale }}
                </span>
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-3 py-2 text-left">
                                <span class="inline-flex items-center gap-1.5">
                                    <x-heroicon-o-map-pin class="h-4 w-4" /> Provincia
                                </span>
                            </th>
                            <th class="px-3 py-2 text-left">
                                <span class="inline-flex items-center gap-1.5">
                                    <x-heroicon-o-building-office class="h-4 w-4" /> Comune
                                </span>
                            </th>
                            <th class="px-3 py-2 text-left">
                                <span class="inline-flex items-center gap-1.5">
                                    <x-heroicon-o-tag class="h-4 w-4" /> Categoria
                                </span>
                            </th>
                            <th class="px-3 py-2 text-left">
                                <span class="inline-flex items-center gap-1.5">
                                    <x-heroicon-o-calendar-days class="h-4 w-4" /> Data attivazione
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comuni as $c)
                        <tr class="border-t border-slate-200">
                            <td class="px-3 py-2">{{ $c['prov'] }}</td>
                            <td class="px-3 py-2">{{ $c['comune'] }}</td>
                            <td class="px-3 py-2">{{ $c['categoria'] }}</td>
                            <td class="px-3 py-2">{{ $c['data'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-card p-4 sm:p-6">
            <h3 class="mb-3 inline-flex items-center gap-2 text-base font-semibold text-slate-800">
                <x-heroicon-o-map class="h-5 w-5 text-brand-600" />
                Mappa situazione COC
            </h3>
            <div id="map-coc" class="h-[50vh] w-full rounded-lg"></div>
        </div>
    </div>
</div>

{{-- Leaflet CSS/JS (CDN) --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Dataset mock come in React
        const COMUNI = @json($comuni);

        // UI refs
        const selProv = document.getElementById('sel-provincia');
        const btnCerca = document.getElementById('btn-cerca-coc');
        const btnPrint = document.getElementById('btn-print');

        // Init mappa
        const map = L.map('map-coc', {
            center: [45.55, 11.55],
            zoom: 8
        });
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        let markersLayer = L.featureGroup().addTo(map);

        function drawMarkers(rows) {
            markersLayer.clearLayers();
            if (!rows.length) return;
            rows.forEach(r => {
                L.marker([r.lat, r.lon]).addTo(markersLayer)
                    .bindPopup(`<b>${escapeHtml(r.comune)}</b><br/>${escapeHtml(r.categoria)}`);
            });
            map.fitBounds(markersLayer.getBounds(), {
                padding: [20, 20]
            });
        }

        btnCerca.addEventListener('click', () => {
            const prov = selProv.value || 'ALL';
            const filtered = prov === 'ALL' ? COMUNI : COMUNI.filter(c => c.prov === prov);
            drawMarkers(filtered);
        });

        btnPrint.addEventListener('click', () => window.print());

        // Helpers
        function escapeHtml(s) {
            return (s ?? '').replace(/[&<>"']/g, m => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                '\'': '&#039;'
            } [m]));
        }
    });
</script>