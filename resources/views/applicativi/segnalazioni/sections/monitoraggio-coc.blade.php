<div class="p-6" id="coc-monitoraggio-root">
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

        <form method="GET"
            action="{{ route('segnalazioni.section', ['page' => 'monitoraggio-coc']) }}"
            class="grid gap-4 md:grid-cols-4">
            {{-- Data inizio --}}
            <label class="grid gap-1.5 text-sm">
                <span class="inline-flex items-center gap-1.5 font-medium text-slate-700">
                    <x-heroicon-o-calendar-days class="h-4 w-4" /> Data inizio
                </span>
                <input id="dt-inizio" name="data_inizio" type="datetime-local"
                    value="{{ old('data_inizio', $dataInizio) }}"
                    class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                           focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
            </label>

            {{-- Data fine --}}
            <label class="grid gap-1.5 text-sm">
                <span class="inline-flex items-center gap-1.5 font-medium text-slate-700">
                    <x-heroicon-o-calendar-days class="h-4 w-4" /> Data fine
                </span>
                <input id="dt-fine" name="data_fine" type="datetime-local"
                    value="{{ old('data_fine', $dataFine) }}"
                    class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                           focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
            </label>

            {{-- Provincia --}}
            <label class="grid gap-1.5 text-sm">
                <span class="inline-flex items-center gap-1.5 font-medium text-slate-700">
                    <x-heroicon-o-map-pin class="h-4 w-4" /> Provincia
                </span>
                <select id="sel-provincia" name="provincia"
                    class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                           focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500">
                    <option value="ALL" @selected($provinciaSelezionata==='ALL' )>Tutte le Province</option>
                    @foreach ($province as $p)
                    <option value="{{ $p }}" @selected($provinciaSelezionata===$p)>{{ $p }}</option>
                    @endforeach
                </select>
            </label>

            {{-- Bottone cerca --}}
            <div class="flex items-end">
                <button type="submit" id="btn-cerca-coc"
                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl h-10 px-4 text-sm font-medium
                           bg-brand-600 text-white hover:bg-brand-700
                           focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-brand-500">
                    <x-heroicon-o-magnifying-glass class="h-4 w-4" />
                    Cerca COC
                </button>
            </div>
        </form>
    </div>

    {{-- Statistiche --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white shadow-card p-4 sm:p-6 coc-print-block">
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
            <table class="w-full text-sm coc-stats-table">
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
        {{-- Tabella comuni --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card p-4 sm:p-6 coc-print-block">
            <h3 class="mb-3 inline-flex items-center gap-2 text-base font-semibold text-slate-800">
                <x-heroicon-o-building-office class="h-5 w-5" />
                Comuni con COC attivati
                <span class="ml-2 inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-0.5 text-xs font-normal">
                    <x-heroicon-o-hashtag class="h-3.5 w-3.5" /> {{ $totale }}
                </span>
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm coc-comuni-table">
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
                        @forelse ($comuniRows as $c)
                        <tr class="border-t border-slate-200">
                            <td class="px-3 py-2">{{ $c->prov }}</td>
                            <td class="px-3 py-2">{{ $c->comune }}</td>
                            <td class="px-3 py-2">{{ $c->categoria }}</td>
                            <td class="px-3 py-2">{{ $c->data }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-3 py-4 text-center text-slate-500">
                                Nessun COC attivo nel periodo selezionato.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mappa --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card p-4 sm:p-6 coc-map-wrapper">
            <h3 class="mb-3 inline-flex items-center gap-2 text-base font-semibold text-slate-800">
                <x-heroicon-o-map class="h-5 w-5 text-brand-600" />
                Mappa situazione COC
            </h3>
            <div id="map-coc" class="coc-map h-[50vh] w-full rounded-lg"></div>
        </div>
    </div>
</div>

{{-- Leaflet CSS/JS (CDN) --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="anonymous"></script>


<style>
    /* ====== Monitoraggio COC – foglio di stile ====== */

    /* Contenitore principale (solo se serve differenziarlo) */
    #coc-monitoraggio-root {
        /* opzionale */
    }

    /* Tabelle statistiche e comuni */
    .coc-stats-table th,
    .coc-stats-table td,
    .coc-comuni-table th,
    .coc-comuni-table td {
        white-space: nowrap;
    }

    .coc-comuni-table td:nth-child(2),
    .coc-comuni-table td:nth-child(3) {
        white-space: normal;
    }

    /* Wrapper mappa */
    .coc-map-wrapper {
        position: relative;
    }

    .coc-map {
        min-height: 320px;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        /* slate-200 */
    }

    /* Leaflet popup / tooltip leggera personalizzazione */
    .leaflet-container {
        font-family: inherit;
    }

    .leaflet-popup-content {
        margin: 8px 12px;
        line-height: 1.4;
    }

    /* Stampa */
    @media print {

        /* Nascondi il bottone di stampa e i controlli superflui */
        #btn-print,
        #btn-cerca-coc,
        #sel-provincia,
        #dt-inizio,
        #dt-fine {
            display: none !important;
        }

        /* Rimuovi ombre e bordi per una stampa più pulita */
        .shadow-card {
            box-shadow: none !important;
        }

        .coc-map-wrapper {
            display: none !important;
            /* se non vuoi stampare la mappa */
        }

        body {
            background: white !important;
            font-size: 11px;
            line-height: 1.3;
        }

        .coc-print-block {
            page-break-inside: avoid;
        }

        table {
            border-collapse: collapse !important;
        }

        .coc-stats-table th,
        .coc-stats-table td,
        .coc-comuni-table th,
        .coc-comuni-table td {
            border: 1px solid #000 !important;
            padding: 4px 3px !important;
        }

        .coc-stats-table thead tr,
        .coc-comuni-table thead tr {
            background-color: #f0f0f0 !important;
        }
    }
</style>