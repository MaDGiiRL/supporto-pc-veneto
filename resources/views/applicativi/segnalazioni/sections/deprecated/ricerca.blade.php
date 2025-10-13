@php
// Tipologie ente (come nel componente React)
$TIPI_ENTE = [
"Centro Operativo Intercomunale",
"COM",
"Comunità Montana",
"Consorzi di bonifica",
"Distretto",
"Esterni",
"Prefettura",
"Provincia",
"Rappresentanti volontariato",
"Regione (e uffici)",
"Reti tecnologiche",
"Servizio Intercomunale",
"Unione dei Comuni",
"Viabilità e trasporti",
"Vigili del Fuoco",
];
@endphp

<div class="p-6">
    <header class="mb-4">
        <h2 class="text-xl font-semibold">{{ $page['label'] ?? 'Ricerca enti' }}</h2>
        <p class="text-sm opacity-75 mt-1">Cerca per <strong>denominazione</strong> oppure per <strong>tipologia di ente</strong>.</p>
    </header>

    {{-- Avviso: usare un solo criterio --}}
    <div class="mb-5 flex items-start gap-2 rounded-xl border border-brand-200 bg-brand-50 px-4 py-3 text-sm text-brand-900">
        <x-heroicon-o-information-circle class="mt-0.5 h-4 w-4 shrink-0 text-brand-600" />
        <span>Seleziona <strong>un solo</strong> criterio di ricerca (o denominazione, o tipologia).</span>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        {{-- Sezione: Denominazione --}}
        <section class="rounded-2xl border border-slate-200 bg-white shadow-card">
            <header class="flex items-center gap-2 rounded-t-2xl bg-brand-50 px-4 py-3 text-sm font-semibold text-slate-800">
                <x-heroicon-o-pencil-square class="h-4 w-4 text-brand-600" />
                Denominazione
            </header>
            <div class="p-4 sm:p-6">
                <label class="grid gap-1.5">
                    <span class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-700">
                        <x-heroicon-o-building-office-2 class="h-4 w-4 text-slate-500" />
                        Denominazione ente
                    </span>
                    <input id="fld-denominazione" type="text" placeholder="Inserisci parte della denominazione"
                        class="h-11 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                  placeholder:text-slate-400
                                  focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
                </label>
                <p id="hint-den" class="mt-2 text-xs text-slate-500 hidden">
                    Disabilitato perché è stata selezionata una tipologia di ente.
                </p>
            </div>
        </section>

        {{-- Sezione: Tipologia ente --}}
        <section class="rounded-2xl border border-slate-200 bg-white shadow-card">
            <header class="flex items-center gap-2 rounded-t-2xl bg-brand-50 px-4 py-3 text-sm font-semibold text-slate-800">
                <x-heroicon-o-rectangle-stack class="h-4 w-4 text-brand-600" />
                Selezionare tipologia di ente
            </header>
            <div class="p-4 sm:p-6">
                <label class="grid gap-1.5">
                    <span class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-700">
                        <x-heroicon-o-rectangle-stack class="h-4 w-4 text-slate-500" />
                        Tipo ente
                    </span>
                    <select id="fld-tipo"
                        class="h-11 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                   focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500">
                        <option value="">scegli tipologia di ente</option>
                        @foreach ($TIPI_ENTE as $t)
                        <option value="{{ $t }}">{{ $t }}</option>
                        @endforeach
                    </select>
                </label>
                <p id="hint-tipo" class="mt-2 text-xs text-slate-500 hidden">
                    Disabilitato perché è stata inserita una denominazione.
                </p>
            </div>
        </section>
    </div>

    {{-- Azioni --}}
    <div class="mt-6 flex flex-wrap items-center gap-3">
        <button id="btn-search" type="button" disabled
            class="inline-flex items-center justify-center rounded-xl h-10 px-4 text-sm font-medium
                       bg-brand-600 text-white hover:bg-brand-700
                       focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-brand-500
                       disabled:opacity-60 disabled:pointer-events-none">
            <x-heroicon-o-magnifying-glass class="mr-1.5 h-4 w-4" />
            Ricerca
        </button>

        <button id="btn-reset" type="button"
            class="inline-flex items-center justify-center rounded-xl h-10 px-4 text-sm font-medium
                       border border-brand-300 text-brand-700 bg-brand-50 hover:bg-brand-100
                       focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-brand-500">
            <x-heroicon-o-arrow-path class="mr-1.5 h-4 w-4" />
            Reimposta
        </button>

        <span id="hint-global" class="text-xs text-slate-500">
            Il pulsante “Ricerca” si attiva compilando solo uno dei due campi.
        </span>
    </div>
</div>

{{-- =================== Script: logica UI/ricerca (vanilla JS) =================== --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const denInp = document.getElementById('fld-denominazione');
        const tipoSel = document.getElementById('fld-tipo');
        const btnSearch = document.getElementById('btn-search');
        const btnReset = document.getElementById('btn-reset');
        const hintDen = document.getElementById('hint-den');
        const hintTipo = document.getElementById('hint-tipo');

        function trim(v) {
            return (v || '').trim();
        }

        function updateState() {
            const den = trim(denInp.value);
            const tipo = trim(tipoSel.value);

            // regole: o solo den, o solo tipo
            const disableDen = !!tipo;
            const disableTipo = den.length > 0;
            const canSearch = (den.length > 0 && !tipo) || (!den && !!tipo);

            denInp.disabled = disableDen;
            tipoSel.disabled = disableTipo;

            hintDen.classList.toggle('hidden', !disableDen);
            hintTipo.classList.toggle('hidden', !disableTipo);

            btnSearch.disabled = !canSearch;
        }

        function doSearch() {
            const den = trim(denInp.value);
            const tipo = trim(tipoSel.value);
            if (btnSearch.disabled) return;

            if (den && !tipo) {
                alert(`Ricerca per denominazione: ${den}`);
            } else if (!den && tipo) {
                alert(`Ricerca per tipologia: ${tipo}`);
            }
        }

        function resetAll() {
            denInp.disabled = false;
            tipoSel.disabled = false;
            denInp.value = '';
            tipoSel.value = '';
            updateState();
        }

        denInp.addEventListener('input', updateState);
        tipoSel.addEventListener('change', updateState);
        btnSearch.addEventListener('click', doSearch);
        btnReset.addEventListener('click', resetAll);

        updateState();
    });
</script>