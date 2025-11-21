@php
$activeRisks     = $rischi->where('attivo', true);
$activeFunctions = $funzioni->where('attiva', true);
$activeConfig    = $configurazioni->firstWhere('attiva', true);
@endphp

<div class="p-6 space-y-6">

    {{-- HEADER + TOOLBAR --}}
    <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-xs font-medium uppercase tracking-[0.2em] text-slate-400">
                Sala Operativa Regionale
            </p>
            <h2 class="mt-1 text-2xl font-semibold text-slate-900">
                {{ $page['label'] ?? 'Apertura/Chiusura SOR' }}
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Gestisci lo stato operativo della SOR, i rischi in atto e le funzioni attivate. La nota generata verrà
                utilizzata per comunicazioni interne ed estrazioni reportistiche.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <span
                class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-xs font-medium
                       @if(($statoAttuale->stato_sala_op ?? 0) === 0)
                           border-emerald-200 bg-emerald-50 text-emerald-800
                       @elseif(($statoAttuale->stato_sala_op ?? 0) === 1)
                           border-amber-200 bg-amber-50 text-amber-800
                       @else
                           border-rose-200 bg-rose-50 text-rose-800
                       @endif">
                <span class="h-2 w-2 rounded-full
                    @if(($statoAttuale->stato_sala_op ?? 0) === 0)
                        bg-emerald-500
                    @elseif(($statoAttuale->stato_sala_op ?? 0) === 1)
                        bg-amber-500
                    @else
                        bg-rose-500
                    @endif">
                </span>
                Stato attuale:
                <span class="font-semibold ml-1" id="sor-current-state">
                    {{ $statoAttuale->stato_descrizione ?? 'N/D' }}
                </span>
            </span>

            <span
                class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1 text-xs text-slate-600 shadow-sm">
                <x-heroicon-o-clock class="h-3.5 w-3.5 text-slate-400" />
                Ultimo aggiornamento:
                <span class="font-medium ml-1" id="sor-last-update">
                    @if(!empty($statoAttuale->data_ora))
                        {{ \Carbon\Carbon::parse($statoAttuale->data_ora)->format('d/m/Y H:i') }}
                    @else
                        N/D
                    @endif
                </span>
            </span>
        </div>
    </header>

    {{-- INFO STRIP / KPI --}}
    <section class="grid gap-4 md:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-slate-50 to-slate-100 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                        Configurazione attiva
                    </p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">
                        <span id="kpi-config-sigla">{{ $activeConfig->sigla ?? 'N/D' }}</span>
                        <span class="ml-1 text-xs font-normal text-slate-500" id="kpi-config-label">
                            {{ $activeConfig->configurazione ?? 'Nessuna configurazione selezionata' }}
                        </span>
                    </p>
                </div>
                <div
                    class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-white shadow-sm border border-slate-200">
                    <x-heroicon-o-cog-6-tooth class="h-4 w-4 text-slate-500" />
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-amber-100 bg-amber-50/70 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-amber-700">
                        Rischi in atto
                    </p>
                    <p class="mt-1 text-2xl font-semibold text-amber-900" id="kpi-risks-count">
                        {{ $activeRisks->count() }}
                    </p>
                    <p class="text-xs text-amber-900/70">
                        {{ $activeRisks->count() ? 'Selezionati nella colonna dedicata.' : 'Nessun rischio attivo.' }}
                    </p>
                </div>
                <div
                    class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-white shadow-sm border border-amber-100">
                    <x-heroicon-o-exclamation-triangle class="h-4 w-4 text-amber-500" />
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-sky-100 bg-sky-50/70 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-sky-700">
                        Funzioni attive
                    </p>
                    <p class="mt-1 text-2xl font-semibold text-sky-900" id="kpi-fn-count">
                        {{ $activeFunctions->count() }}
                    </p>
                    <p class="text-xs text-sky-900/70">
                        {{ $activeFunctions->count() ? 'Funzioni selezionate per la gestione dell’evento.' : 'Nessuna funzione attiva.' }}
                    </p>
                </div>
                <div
                    class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-white shadow-sm border border-sky-100">
                    <x-heroicon-o-clipboard-document-check class="h-4 w-4 text-sky-500" />
                </div>
            </div>
        </div>
    </section>

    {{-- MAIN GRID --}}
    <div class="grid gap-6 xl:grid-cols-[minmax(0,3fr)_minmax(0,2fr)]">

        {{-- COLONNA SINISTRA --}}
        <div class="space-y-6">

            {{-- CARD: Stato + descrizione --}}
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <header
                    id="sor-banner"
                    class="flex items-center justify-between gap-2 rounded-t-2xl px-4 py-3 text-sm font-medium bg-slate-50 text-slate-800">
                    <div class="flex items-center gap-2">
                        <span
                            class="inline-flex h-7 w-7 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                            <x-heroicon-o-power class="h-4 w-4" />
                        </span>
                        <div>
                            <h3 class="text-sm font-semibold">
                                Attuale situazione della Sala Operativa
                            </h3>
                            <p class="text-xs text-slate-500">
                                Stato operativo e decorrenza della nuova configurazione.
                            </p>
                        </div>
                    </div>
                    <span class="text-xs text-slate-600">
                        Stato:
                        <span id="sor-banner-stato" class="font-semibold">
                            {{ $statoAttuale->stato_descrizione ?? 'N/D' }}
                        </span>
                    </span>
                </header>

                <div class="p-4 sm:p-6 space-y-4">
                    <div class="grid gap-4 sm:grid-cols-2">
                        {{-- Stato SOR --}}
                        <label class="flex flex-col gap-2">
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase text-slate-600">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Stato SOR
                            </span>
                            <div class="relative">
                                <x-heroicon-o-chevron-down
                                    class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                                <select id="fld-stato"
                                    class="h-10 w-full appearance-none rounded-xl border border-slate-300 bg-white px-3 pr-8 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                                    @foreach ($statiSale as $stato)
                                        <option value="{{ $stato->id_stati_sale_operative }}"
                                            {{ $statoAttuale->stato_sala_op == $stato->id_stati_sale_operative ? 'selected' : '' }}>
                                            {{ $stato->descrizione }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </label>

                        {{-- Decorrenza --}}
                        <label class="flex flex-col gap-2">
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase text-slate-600">
                                <x-heroicon-o-calendar-days class="h-4 w-4 text-slate-500" />
                                Decorrenza
                            </span>
                            <input
                                id="fld-decorrenza"
                                type="date"
                                value="{{ now()->format('Y-m-d') }}"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500" />
                            <p class="mt-1 text-[11px] text-slate-400">
                                Di default è impostata alla data odierna, ma puoi modificarla se necessario.
                            </p>
                        </label>
                    </div>

                    <label class="block">
                        <span class="mb-2 inline-flex items-center gap-1.5 text-xs font-semibold uppercase text-slate-600">
                            <x-heroicon-o-document-text class="h-4 w-4 text-slate-500" />
                            Descrizione sintetica
                        </span>
                        <textarea id="fld-descrizione" rows="4"
                            placeholder="Eventuale sintetica descrizione. Attenzione: viene inclusa nella nota stampata!"
                            class="w-full rounded-xl border border-slate-300 bg-white p-3 text-sm placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">{{ $statoAttuale->nota_stato_sala_op }}</textarea>
                        <p class="mt-1 text-[11px] text-slate-400">
                            Usa questo campo per sintetizzare il contesto operativo (es. “attivazione presidio operativo per criticità meteo-idro”).
                        </p>
                    </label>
                </div>
            </section>

            {{-- CARD: Rischi + Configurazione --}}
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <header
                    class="flex items-center justify-between gap-2 rounded-t-2xl px-4 py-3 text-sm font-medium bg-slate-50 text-slate-800">
                    <div class="flex items-center gap-2">
                        <span
                            class="inline-flex h-7 w-7 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                            <x-heroicon-o-exclamation-triangle class="h-4 w-4" />
                        </span>
                        <div>
                            <h3 class="text-sm font-semibold">Rischi & configurazione operativa</h3>
                            <p class="text-xs text-slate-500">Seleziona i rischi in atto e la configurazione di lavoro.</p>
                        </div>
                    </div>
                </header>

                <div class="p-4 sm:p-6 grid gap-6 lg:grid-cols-[minmax(0,2fr)_minmax(0,3fr)]">
                    {{-- Rischio in atto --}}
                    <div>
                        <p class="mb-3 text-xs font-semibold uppercase text-slate-600">
                            Rischio in atto
                        </p>
                        <div class="rounded-xl border border-slate-100 bg-slate-50/70">
                            <ul class="divide-y divide-slate-100">
                                @foreach ($rischi as $r)
                                    <li class="flex items-center justify-between px-3 py-2.5">
                                        <span class="text-sm text-slate-800">{{ $r->rischio }}</span>
                                        <input type="checkbox"
                                            class="risk h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                            value="{{ $r->id_rischio }}"
                                            data-label="{{ $r->rischio }}"
                                            {{ $r->attivo ? 'checked' : '' }}
                                            aria-label="{{ $r->rischio }}">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- Configurazione operativa --}}
                    <div>
                        <p class="mb-3 text-xs font-semibold uppercase text-slate-600">
                            Configurazione operativa
                        </p>
                        <div class="space-y-2">
                            @foreach ($configurazioni as $c)
                                <label
                                    class="group flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm transition hover:border-blue-400 hover:bg-blue-50/60">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="config"
                                            class="cfg h-4 w-4 border-slate-400 text-blue-600 focus:ring-blue-500"
                                            value="{{ $c->id_configurazione }}"
                                            {{ $c->attiva ? 'checked' : '' }}>
                                        <span
                                            class="inline-flex h-6 min-w-[3rem] items-center justify-center rounded-lg bg-slate-100 text-[11px] font-semibold tracking-wide text-slate-700 group-hover:bg-blue-100 group-hover:text-blue-700">
                                            {{ $c->sigla }}
                                        </span>
                                        <span class="text-sm text-slate-800">
                                            {{ $c->configurazione }}
                                        </span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </div>

        {{-- COLONNA DESTRA --}}
        <div class="space-y-6">

            {{-- CARD: Funzioni attivate --}}
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <header
                    class="flex items-center gap-2 rounded-t-2xl px-4 py-3 text-sm font-medium bg-slate-50 text-slate-700">
                    <span
                        class="inline-flex h-7 w-7 items-center justify-center rounded-xl bg-indigo-100 text-indigo-700">
                        <x-heroicon-o-clipboard-document-check class="h-4 w-4" />
                    </span>
                    <div>
                        <h3 class="text-sm font-semibold">Funzioni attivate</h3>
                        <p class="text-xs text-slate-500">Seleziona le funzioni coinvolte nell’operatività attuale.</p>
                    </div>
                </header>
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                        @foreach ($funzioni as $f)
                            <label
                                class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50/60 p-3 text-sm transition hover:border-blue-400 hover:bg-blue-50">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="inline-flex h-6 min-w-[3rem] items-center justify-center rounded-lg bg-white text-[11px] font-semibold tracking-wide text-slate-700 shadow-sm">
                                        {{ $f->sigla }}
                                    </span>
                                    <span class="text-sm text-slate-800">{{ $f->funzione }}</span>
                                </div>
                                <input type="checkbox"
                                    class="fn h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                    value="{{ $f->id_funzione }}"
                                    data-label="{{ $f->funzione }}"
                                    data-code="{{ $f->sigla }}"
                                    {{ $f->attiva ? 'checked' : '' }}
                                    aria-label="{{ $f->funzione }}">
                            </label>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- CARD: Anteprima nota + azioni --}}
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <header
                    class="flex items-center justify-between gap-2 rounded-t-2xl px-4 py-3 text-sm font-medium bg-slate-50 text-slate-700">
                    <div class="flex items-center gap-2">
                        <span
                            class="inline-flex h-7 w-7 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                            <x-heroicon-o-document-text class="h-4 w-4" />
                        </span>
                        <div>
                            <h3 class="text-sm font-semibold">Anteprima nota</h3>
                            <p class="text-xs text-slate-500">Verifica il riepilogo prima di confermare l’aggiornamento.</p>
                        </div>
                    </div>
                </header>
                <div class="p-4 sm:p-6 space-y-4">
                    <div
                        id="nota"
                        class="rounded-xl border border-dashed border-emerald-200 bg-emerald-50/50 p-3 text-[11px] font-mono text-slate-800 whitespace-pre-line max-h-52 overflow-auto">
                        {{-- Riempito da JS --}}
                    </div>

                    <div class="flex items-center justify-between gap-3 pt-2 border-t border-slate-100">
                        <div class="flex items-center gap-2 text-[11px] text-slate-500">
                            <x-heroicon-o-information-circle class="h-4 w-4 text-slate-400" />
                            <span>
                                Il salvataggio aggiorna lo stato SOR e le tabelle di rischio, configurazione e funzioni.
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button id="btn-print" type="button"
                                class="h-9 px-3 text-xs rounded-xl bg-emerald-100 text-emerald-900 hover:bg-emerald-200">
                                Stampa nota
                            </button>
                            <button id="btn-reset" type="button"
                                class="h-9 px-3 text-xs rounded-xl bg-slate-100 text-slate-900 hover:bg-slate-200">
                                Reimposta
                            </button>
                            <button id="btn-save" type="button"
                                class="h-9 px-4 text-xs rounded-xl bg-blue-600 text-white shadow-sm hover:bg-blue-700">
                                Salva aggiornamento
                            </button>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Configurazioni dal backend (costruiamo l'array JS via Blade)
        const CONFIGS = [
            @foreach($configurazioni as $c)
                {
                    id: {{ (int) $c->id_configurazione }},
                    code: @json($c->sigla),
                    label: @json($c->configurazione),
                    active: {{ $c->attiva ? 'true' : 'false' }},
                }@if(!$loop->last),@endif
            @endforeach
        ];

        // Riferimenti DOM
        const statoSel   = document.getElementById('fld-stato');
        const dataInp    = document.getElementById('fld-decorrenza');
        const descTA     = document.getElementById('fld-descrizione');
        const banner     = document.getElementById('sor-banner');
        const bannerTxt  = document.getElementById('sor-banner-stato');
        const notaEl     = document.getElementById('nota');
        const riskCbs    = Array.from(document.querySelectorAll('input.risk'));
        const cfgRds     = Array.from(document.querySelectorAll('input.cfg'));
        const fnCbs      = Array.from(document.querySelectorAll('input.fn'));
        const btnReset   = document.getElementById('btn-reset');
        const btnSave    = document.getElementById('btn-save');
        const btnPrint   = document.getElementById('btn-print');

        // Header / KPI per aggiornamento realtime
        const elCurrentState   = document.getElementById('sor-current-state');
        const elLastUpdate     = document.getElementById('sor-last-update');
        const elKpiCfgSigla    = document.getElementById('kpi-config-sigla');
        const elKpiCfgLabel    = document.getElementById('kpi-config-label');
        const elKpiRisksCount  = document.getElementById('kpi-risks-count');
        const elKpiFnCount     = document.getElementById('kpi-fn-count');

        const today = () => new Date().toISOString().slice(0, 10);

        const formatDateTime = (d) => {
            const pad = (n) => String(n).padStart(2, '0');
            const day   = pad(d.getDate());
            const month = pad(d.getMonth() + 1);
            const year  = d.getFullYear();
            const hour  = pad(d.getHours());
            const min   = pad(d.getMinutes());
            return `${day}/${month}/${year} ${hour}:${min}`;
        };

        // Dizionari descrizioni
        const riskLabels = {};
        riskCbs.forEach(cb => {
            riskLabels[cb.value] = cb.dataset.label || cb.value;
        });

        const fnLabels = {};
        const fnCodes  = {};
        fnCbs.forEach(cb => {
            fnLabels[cb.value] = cb.dataset.label || cb.value;
            fnCodes[cb.value]  = cb.dataset.code || '';
        });

        // Stato iniziale (valori attuali in pagina)
        let stato       = statoSel ? statoSel.value : '';
        let decorrenza  = dataInp && dataInp.value ? dataInp.value : today();
        let descrizione = descTA ? (descTA.value || '') : '';
        let rischi      = new Set(riskCbs.filter(cb => cb.checked).map(cb => cb.value));
        let config      = null;

        if (cfgRds.length > 0) {
            const checkedCfg = cfgRds.find(rd => rd.checked);
            config = checkedCfg ? checkedCfg.value : (CONFIGS[0] ? String(CONFIGS[0].id) : null);
        } else if (CONFIGS[0]) {
            config = String(CONFIGS[0].id);
        }

        let funzioni    = new Set(fnCbs.filter(cb => cb.checked).map(cb => cb.value));

        const initialState = {
            stato,
            decorrenza,
            descrizione,
            rischi: new Set(rischi),
            config,
            funzioni: new Set(funzioni),
        };

        function findConfigById(id) {
            return CONFIGS.find(c => String(c.id) === String(id)) || null;
        }

        function updateBanner() {
            if (!banner || !statoSel || !bannerTxt) return;

            const selected = statoSel.options[statoSel.selectedIndex];
            const label    = selected ? selected.textContent : '';

            banner.classList.remove(
                'border-emerald-200', 'bg-emerald-50',
                'border-amber-200', 'bg-amber-50'
            );

            if (parseInt(stato, 10) === 0) {
                banner.classList.add('border-emerald-200', 'bg-emerald-50');
            } else {
                banner.classList.add('border-amber-200', 'bg-amber-50');
            }

            bannerTxt.textContent = label;
        }

        function updateNota() {
            if (!notaEl) return;

            const cfgObj   = findConfigById(config) || {};
            const cfgCode  = cfgObj.code || '';
            const cfgLabel = cfgObj.label || '';

            const rischiDesc = rischi.size
                ? Array.from(rischi).map(id => riskLabels[id] || id).join(', ')
                : 'nessuno';

            const funzioniDesc = funzioni.size
                ? Array.from(funzioni).map(id => {
                    const code  = fnCodes[id] || '';
                    const label = fnLabels[id] || id;
                    return code ? (code + ' - ' + label) : label;
                }).join(', ')
                : 'nessuna';

            let descrizioneLinea = (descrizione || '').trim();
            if (!descrizioneLinea) {
                descrizioneLinea = '—';
            }

            const nota = [
                'Stato SOR: ' + (bannerTxt ? bannerTxt.textContent : ''),
                'Decorrenza: ' + decorrenza,
                'Configurazione: ' + (cfgCode ? (cfgCode + ' - ') : '') + (cfgLabel || ''),
                'Rischi in atto: ' + rischiDesc,
                'Funzioni attivate: ' + funzioniDesc,
                'Descrizione: ' + descrizioneLinea,
            ].join('\n');

            notaEl.textContent = nota;
        }

        function updateHeaderAndKpiRealtime() {
            const cfgObj = findConfigById(config) || {};

            if (elCurrentState && bannerTxt) {
                elCurrentState.textContent = bannerTxt.textContent;
            }

            if (elLastUpdate) {
                elLastUpdate.textContent = formatDateTime(new Date());
            }

            if (elKpiCfgSigla) {
                elKpiCfgSigla.textContent = cfgObj.code || 'N/D';
            }

            if (elKpiCfgLabel) {
                elKpiCfgLabel.textContent = cfgObj.label || 'Nessuna configurazione selezionata';
            }

            if (elKpiRisksCount) {
                elKpiRisksCount.textContent = rischi.size;
            }

            if (elKpiFnCount) {
                elKpiFnCount.textContent = funzioni.size;
            }
        }

        // Funzione di reset usata sia dal bottone che dopo il salvataggio
        function resetForm() {
            stato       = initialState.stato;
            decorrenza  = today(); // oppure initialState.decorrenza se vuoi ripristinare esattamente il valore iniziale
            descrizione = initialState.descrizione;
            rischi      = new Set(initialState.rischi);
            config      = initialState.config;
            funzioni    = new Set(initialState.funzioni);

            if (statoSel) statoSel.value = stato;
            if (dataInp)  dataInp.value  = decorrenza;
            if (descTA)   descTA.value   = descrizione;

            riskCbs.forEach(cb => cb.checked = rischi.has(cb.value));
            cfgRds.forEach(rd => rd.checked = (rd.value === String(config)));
            fnCbs.forEach(cb => cb.checked = funzioni.has(cb.value));

            updateBanner();
            updateNota();
        }

        // Init
        if (dataInp) dataInp.value = decorrenza;
        updateBanner();
        updateNota();

        // Listeners
        if (statoSel) {
            statoSel.addEventListener('change', (e) => {
                stato = e.target.value;
                updateBanner();
                updateNota();
            });
        }

        if (dataInp) {
            dataInp.addEventListener('change', (e) => {
                decorrenza = e.target.value || decorrenza;
                updateNota();
            });
        }

        if (descTA) {
            descTA.addEventListener('input', (e) => {
                descrizione = e.target.value;
                updateNota();
            });
        }

        riskCbs.forEach(cb =>
            cb.addEventListener('change', (e) => {
                const v = e.target.value;
                if (e.target.checked) rischi.add(v);
                else rischi.delete(v);
                updateNota();
            })
        );

        cfgRds.forEach(rd =>
            rd.addEventListener('change', (e) => {
                if (e.target.checked) {
                    config = e.target.value;
                    updateNota();
                }
            })
        );

        fnCbs.forEach(cb =>
            cb.addEventListener('change', (e) => {
                const v = e.target.value;
                if (e.target.checked) funzioni.add(v);
                else funzioni.delete(v);
                updateNota();
            })
        );

        // Reset
        if (btnReset) {
            btnReset.addEventListener('click', resetForm);
        }

        // Stampa nota
        if (btnPrint) {
            btnPrint.addEventListener('click', () => {
                if (!notaEl) return;

                const contenuto = notaEl.textContent || '';

                const win = window.open('', '_blank', 'width=800,height=600');
                if (!win) return;

                win.document.open();
                win.document.write(`
                    <!DOCTYPE html>
                    <html lang="it">
                    <head>
                        <meta charset="utf-8" />
                        <title>Nota SOR</title>
                        <style>
                            body {
                                font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
                                padding: 24px;
                                font-size: 12px;
                                color: #0f172a;
                                background: #ffffff;
                            }
                            h1 {
                                font-size: 16px;
                                margin-bottom: 12px;
                            }
                            pre {
                                white-space: pre-wrap;
                                word-wrap: break-word;
                                border: 1px solid #d1d5db;
                                border-radius: 8px;
                                padding: 12px;
                                background: #f9fafb;
                            }
                        </style>
                    </head>
                    <body>
                        <h1>Nota Sala Operativa Regionale</h1>
                        <pre>${contenuto.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</pre>
                        <script>
                            window.onload = function() {
                                window.print();
                            };
                        <\/script>
                    </body>
                    </html>
                `);
                win.document.close();
            });
        }

        // Salvataggio
        if (btnSave) {
            btnSave.addEventListener('click', () => {
                decorrenza = (dataInp && dataInp.value) ? dataInp.value : today();
                updateNota();

                fetch("{{ route('sor.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        stato_id:   parseInt(stato, 10),
                        decorrenza: decorrenza,
                        descrizione: descrizione,
                        rischi:     Array.from(rischi).map(v => parseInt(v, 10)),
                        config_id:  parseInt(config, 10),
                        funzioni:   Array.from(funzioni).map(v => parseInt(v, 10)),
                    }),
                })
                    .then(res => {
                        if (!res.ok) throw new Error('Errore salvataggio');
                        return res.json();
                    })
                    .then(() => {
                        // SweetAlert di conferma
                        if (window.Swal) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Aggiornato',
                                text: 'Stato SOR aggiornato con successo.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            alert('Stato SOR aggiornato con successo.');
                        }

                        // Aggiornamento realtime header/KPI
                        updateHeaderAndKpiRealtime();

                        // Reset dei form
                        resetForm();
                    })
                    .catch(() => {
                        if (window.Swal) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Errore',
                                text: 'Errore nel salvataggio dello stato SOR.'
                            });
                        } else {
                            alert('Errore nel salvataggio dello stato SOR.');
                        }
                    });
            });
        }
    });
</script>
