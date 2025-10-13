@php
// Dati statici (come nel componente React)
$RISKS = [
'Sismico','Meteo','Idrogeologico','Idraulico','Incendi boschivi',
'Sanitario','Ambientale','Industriale','Altro',
];

$CONFIGS = [
['code' => 'S0', 'label' => 'Ordinaria'],
['code' => 'S1', 'label' => 'Vigilanza'],
['code' => 'S2', 'label' => 'Presidio operativo'],
['code' => 'S3', 'label' => 'Emergenza'],
];

$FUNZIONI = [
['code'=>'FVS','label'=>'Valutazione situazione'],
['code'=>'F1','label'=>'Tecnica e di pianificazione'],
['code'=>'F2','label'=>'Sanità, assistenza sociale e veterinaria'],
['code'=>'F3','label'=>'Mass-media e informazione'],
['code'=>'F4','label'=>'Volontariato'],
['code'=>'F5','label'=>'Materiali e mezzi'],
['code'=>'F6','label'=>'Trasporti, circolazione e viabilità'],
['code'=>'F7','label'=>'Telecomunicazioni'],
['code'=>'F8','label'=>'Servizi essenziali'],
['code'=>'F9','label'=>'Censimento danni'],
['code'=>'F10','label'=>'Strutture operative'],
['code'=>'F11','label'=>'Enti locali'],
['code'=>'F12','label'=>'Materiali pericolosi'],
['code'=>'F13','label'=>'Assistenza alla popolazione'],
['code'=>'F14','label'=>'Coordinamento centri operativi'],
['code'=>'FS','label'=>'Segreteria'],
];
@endphp

<div class="p-6">
    <header class="mb-4">
        <h2 class="text-xl font-semibold">{{ $page['label'] ?? 'Apertura/Chiusura SOR' }}</h2>
        <p class="text-sm opacity-75 mt-1">Aggiorna lo stato della Sala Operativa Regionale e genera una nota sintetica.</p>
    </header>

    {{-- Banner stato attuale (colore dinamico via JS) --}}
    <div id="sor-banner" class="mb-6 rounded-2xl border p-4 sm:p-5 border-emerald-200 bg-emerald-50">
        <p class="flex items-center gap-2 text-lg font-semibold text-slate-900">
            <x-heroicon-o-information-circle class="h-5 w-5" />
            Attuale situazione della Sala Operativa Regionale:
            <span id="sor-banner-stato" class="ml-1">chiusa</span>
        </p>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-3 grid gap-6 lg:grid-cols-3">

            {{-- Sezione: Aggiornamento stato --}}
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <header class="flex items-center gap-2 rounded-t-2xl px-4 py-3 text-sm font-medium bg-blue-50 text-slate-800">
                    <x-heroicon-o-power class="h-4 w-4" />
                    <h3 class="text-base font-semibold">Aggiornamento stato</h3>
                </header>
                <div class="p-4 sm:p-6">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="flex flex-col gap-2">
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                <x-heroicon-o-power class="h-4 w-4 text-slate-500" />
                                Aggiorna lo stato a
                            </span>
                            <select id="fld-stato"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                                <option value="aperta">aperta</option>
                                <option value="chiusa" selected>chiusa</option>
                            </select>
                        </label>

                        <label class="flex flex-col gap-2">
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                <x-heroicon-o-calendar-days class="h-4 w-4 text-slate-500" />
                                Con decorrenza
                            </span>
                            <input id="fld-decorrenza" type="date"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500" />
                        </label>
                    </div>

                    <label class="mt-4 block">
                        <span class="mb-2 inline-flex items-center gap-1.5 text-sm font-medium text-slate-700">
                            <x-heroicon-o-document-text class="h-4 w-4 text-slate-500" />
                            Descrizione
                        </span>
                        <textarea id="fld-descrizione" rows="4"
                            placeholder="Eventuale sintetica descrizione. Attenzione: viene inclusa nella nota stampata!"
                            class="w-full rounded-xl border border-slate-300 bg-white p-3 text-sm placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"></textarea>
                    </label>
                </div>
            </section>

            {{-- Sezione: Rischio in atto --}}
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <header class="flex items-center gap-2 rounded-t-2xl px-4 py-3 text-sm font-medium bg-slate-50 text-slate-700">
                    <x-heroicon-o-exclamation-triangle class="h-4 w-4" />
                    <h3 class="text-base font-semibold">Rischio in atto</h3>
                </header>
                <div class="p-4 sm:p-6">
                    <ul class="divide-y divide-slate-100">
                        @foreach ($RISKS as $r)
                        <li class="flex items-center justify-between py-2.5">
                            <span class="text-sm text-slate-800">{{ $r }}</span>
                            <input type="checkbox" class="risk h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                value="{{ $r }}" aria-label="{{ $r }}">
                        </li>
                        @endforeach
                    </ul>
                </div>
            </section>

            {{-- Sezione: Configurazione operativa (UNA VOCE PER RIGA) --}}
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <header class="flex items-center gap-2 rounded-t-2xl px-4 py-3 text-sm font-medium bg-slate-50 text-slate-700">
                    <x-heroicon-o-cog-6-tooth class="h-4 w-4" />
                    <h3 class="text-base font-semibold">Configurazione operativa</h3>
                </header>

                <div class="p-4 sm:p-6">
                    {{-- da griglia 2x2 -> lista verticale --}}
                    <div class="space-y-3">
                        @foreach ($CONFIGS as $c)
                        <label class="group flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 p-3 transition hover:border-blue-400 hover:bg-blue-50">
                            <input
                                type="radio"
                                name="config"
                                class="cfg h-4 w-4 border-slate-400 text-blue-600 focus:ring-blue-500"
                                value="{{ $c['code'] }}"
                                {{ $c['code'] === 'S0' ? 'checked' : '' }}>
                            <span class="inline-flex h-6 w-12 items-center justify-center rounded-lg bg-slate-100 text-[11px] font-semibold tracking-wide text-slate-700">
                                {{ $c['code'] }}
                            </span>
                            <span class="text-sm text-slate-800">{{ $c['label'] }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </section>


            {{-- Sezione: Funzioni attivate --}}
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm lg:col-span-3">
                <header class="flex items-center gap-2 rounded-t-2xl px-4 py-3 text-sm font-medium bg-slate-50 text-slate-700">
                    <x-heroicon-o-clipboard-document-check class="h-4 w-4" />
                    <h3 class="text-base font-semibold">Funzioni attivate</h3>
                </header>
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                        @foreach ($FUNZIONI as $f)
                        <label class="flex items-center justify-between rounded-xl border border-slate-200 p-3 transition hover:border-blue-400 hover:bg-blue-50">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-6 w-12 items-center justify-center rounded-lg bg-slate-100 text-[11px] font-semibold tracking-wide text-slate-700">
                                    {{ $f['code'] }}
                                </span>
                                <span class="text-sm text-slate-800">{{ $f['label'] }}</span>
                            </div>
                            <input type="checkbox" class="fn h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                value="{{ $f['code'] }}" aria-label="{{ $f['label'] }}">
                        </label>
                        @endforeach
                    </div>
                </div>
            </section>

        </div>
    </div>

    {{-- Footer azioni --}}
    <div class="sticky bottom-3 mt-8 flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white/90 p-3 backdrop-blur">
        <div class="flex items-center gap-2 text-xs text-slate-600">
            <span class="rounded-md bg-emerald-50 px-2 py-1 font-medium text-emerald-700">
                Anteprima nota
            </span>
            <code id="nota" class="max-w-[52ch] truncate whitespace-pre text-[11px] text-slate-700"></code>
        </div>
        <div class="ml-auto flex items-center gap-2">
            <button id="btn-reset" type="button"
                class="h-10 px-4 text-sm rounded-xl bg-slate-100 text-slate-900 hover:bg-slate-200">
                Reimposta
            </button>
            <button id="btn-save" type="button"
                class="h-10 px-4 text-sm rounded-xl bg-blue-600 text-white hover:bg-blue-700">
                Salva aggiornamento
            </button>
        </div>
    </div>
</div>

{{-- Script: gestione stato/anteprima (vanilla JS) --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Costanti lato JS (arrivano dal PHP)
        const CONFIGS = @json($CONFIGS);

        // Riferimenti
        const statoSel = document.getElementById('fld-stato');
        const dataInp = document.getElementById('fld-decorrenza');
        const descTA = document.getElementById('fld-descrizione');
        const banner = document.getElementById('sor-banner');
        const bannerTxt = document.getElementById('sor-banner-stato');
        const notaEl = document.getElementById('nota');
        const riskCbs = [...document.querySelectorAll('input.risk')];
        const cfgRds = [...document.querySelectorAll('input.cfg')];
        const fnCbs = [...document.querySelectorAll('input.fn')];
        const btnReset = document.getElementById('btn-reset');
        const btnSave = document.getElementById('btn-save');

        // Stato UI
        let stato = 'chiusa';
        let decorrenza = new Date().toISOString().slice(0, 10);
        let descrizione = '';
        let rischi = new Set();
        let config = 'S0';
        let funzioni = new Set();

        // Init campi
        dataInp.value = decorrenza;
        updateBanner();
        updateNota();

        // Helpers
        function updateBanner() {
            banner.classList.remove('border-emerald-200', 'bg-emerald-50', 'border-amber-200', 'bg-amber-50');
            if (stato === 'chiusa') {
                banner.classList.add('border-emerald-200', 'bg-emerald-50');
            } else {
                banner.classList.add('border-amber-200', 'bg-amber-50');
            }
            bannerTxt.textContent = stato;
        }

        function updateNota() {
            const cfgLabel = (CONFIGS.find(c => c.code === config) || {}).label || '';
            const nota = [
                `Stato SOR: ${stato.toUpperCase()}`,
                `Decorrenza: ${decorrenza}`,
                `Configurazione: ${config} - ${cfgLabel}`,
                `Rischi in atto: ${rischi.size ? Array.from(rischi).join(', ') : 'nessuno'}`,
                `Funzioni attivate: ${funzioni.size ? Array.from(funzioni).join(', ') : 'nessuna'}`
            ].join(' \n');
            notaEl.textContent = nota;
        }

        // Listeners
        statoSel.addEventListener('change', (e) => {
            stato = e.target.value;
            updateBanner();
            updateNota();
        });

        dataInp.addEventListener('change', (e) => {
            decorrenza = e.target.value || decorrenza;
            updateNota();
        });

        descTA.addEventListener('input', (e) => {
            descrizione = e.target.value; // non usata nella nota sintetica, ma disponibile
        });

        riskCbs.forEach(cb => cb.addEventListener('change', (e) => {
            const v = e.target.value;
            if (e.target.checked) rischi.add(v);
            else rischi.delete(v);
            updateNota();
        }));

        cfgRds.forEach(rd => rd.addEventListener('change', (e) => {
            if (e.target.checked) {
                config = e.target.value;
                updateNota();
            }
        }));

        fnCbs.forEach(cb => cb.addEventListener('change', (e) => {
            const v = e.target.value;
            if (e.target.checked) funzioni.add(v);
            else funzioni.delete(v);
            updateNota();
        }));

        // Reset
        btnReset.addEventListener('click', () => {
            stato = 'chiusa';
            statoSel.value = 'chiusa';
            decorrenza = new Date().toISOString().slice(0, 10);
            dataInp.value = decorrenza;
            descrizione = '';
            descTA.value = '';
            rischi.clear();
            riskCbs.forEach(cb => cb.checked = false);
            config = 'S0';
            cfgRds.forEach(rd => rd.checked = (rd.value === 'S0'));
            funzioni.clear();
            fnCbs.forEach(cb => cb.checked = false);
            updateBanner();
            updateNota();
        });

        // Salva (mock)
        btnSave.addEventListener('click', () => {
            alert('Stato SOR aggiornato (solo UI).');
        });
    });
</script>