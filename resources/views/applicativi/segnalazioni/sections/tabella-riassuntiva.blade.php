<div class="p-6">
    <header class="mb-4">
        <h2 class="text-xl font-semibold">Tabella riassuntiva Comuni</h2>
        <p class="text-sm opacity-75 mt-1">Ricerca rapida, stato COC e dettaglio per singolo Comune.</p>
    </header>

    {{-- ========================= BARRA RICERCA ========================= --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white shadow-card p-4 sm:p-6">
        <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
            <label class="grid gap-1.5 text-sm">
                <span class="inline-flex items-center gap-1.5 font-medium text-slate-700">
                    <x-heroicon-o-magnifying-glass class="h-4 w-4" /> Cerca
                </span>
                <div class="relative">
                    <x-heroicon-o-magnifying-glass class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                    <input id="q" class="h-10 w-full rounded-xl border border-slate-300 bg-white px-9 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500" placeholder="Comune, stato, fase…" />
                </div>
            </label>
        </div>
    </div>

    {{-- ============================ TABELLA ============================ --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-card p-4 sm:p-6">
        <div class="mb-3 flex items-center justify-between">
            <h3 class="inline-flex items-center gap-2 text-base font-semibold text-slate-800">
                <x-heroicon-o-map-pin class="h-5 w-5" />
                Elenco Comuni
                <span class="ml-2 inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-800">
                    <x-heroicon-o-hashtag class="h-3.5 w-3.5" /> <span id="count">0</span>
                </span>
            </h3>
            <p class="text-xs text-slate-500">Mostrati 1–<span id="shown">0</span> di 560 (mock)</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="tbl">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-3 py-2 text-left">
                            <span class="inline-flex items-center gap-1.5">
                                <x-heroicon-o-pencil-square class="h-4 w-4" /> Modifica
                            </span>
                        </th>
                        <th class="px-3 py-2 text-left">
                            <span class="inline-flex items-center gap-1.5">
                                <x-heroicon-o-building-office-2 class="h-4 w-4" /> Comune
                            </span>
                        </th>
                        <th class="px-3 py-2 text-left">
                            <span class="inline-flex items-center gap-1.5">
                                <x-heroicon-o-information-circle class="h-4 w-4" /> Stato COC
                            </span>
                        </th>
                        <th class="px-3 py-2 text-left">
                            <span class="inline-flex items-center gap-1.5">
                                <x-heroicon-o-exclamation-circle class="h-4 w-4" /> Fase
                            </span>
                        </th>
                        <th class="px-3 py-2 text-left">
                            <span class="inline-flex items-center gap-1.5">
                                <x-heroicon-o-users class="h-4 w-4" /> Attivazioni
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
        </div>
    </div>
</div>

{{-- ============================= MODALE PRINCIPALE ============================= --}}
<div id="overlay" class="fixed inset-0 z-[900] bg-black/70 hidden"></div>

<div id="modal" class="fixed inset-0 z-[1000] hidden overflow-y-auto">
    <div class="min-h-full flex items-center justify-center p-4">
        <div class="relative w-full max-w-5xl rounded-2xl border border-slate-200 bg-white shadow-lg flex flex-col max-h-[90vh]">
            {{-- HEADER (non scrolla) --}}
            <div class="sticky top-0 z-10 px-6 pt-6 pb-3 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80">
                <button id="modal-close" class="absolute right-3 top-3 rounded-lg p-2 text-slate-400 hover:bg-slate-100" aria-label="Chiudi">
                    <x-heroicon-o-x-mark class="h-5 w-5" />
                </button>

                <h3 class="mb-1 flex items-center gap-2 text-lg font-semibold text-slate-900">
                    <x-heroicon-o-information-circle class="h-5 w-5 text-brand-500" />
                    <span id="modal-title">Gestione segnalazioni –</span>
                </h3>
                <p class="text-sm text-slate-600">
                    Gestisci stato COC, eventi attivi, comunicazioni e recapiti del comune selezionato.
                </p>
            </div>

            {{-- BODY (scrollabile) --}}
            <div id="modal-body" class="px-6 pb-6 overflow-y-auto">
                {{-- Stato sintetico --}}
                <div class="mb-4 rounded-2xl border border-slate-200 bg-white p-4">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <p class="mb-2 text-sm font-semibold text-slate-800">Situazione COC</p>
                            <span id="coc-stato-pill" class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-800">
                                <x-heroicon-o-building-office-2 class="h-4 w-4" />
                                <span id="coc-stato">-</span>
                            </span>
                            <div class="mt-1 flex items-center gap-1.5 text-sm text-slate-600">
                                <x-heroicon-o-calendar-days class="h-4 w-4" />
                                <span id="coc-stato-data">-</span>
                            </div>
                        </div>

                        <div>
                            <p class="mb-2 text-sm font-semibold text-slate-800">Fase operativa</p>
                            <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-900">
                                <x-heroicon-o-exclamation-circle class="h-4 w-4" />
                                <span id="fase-pill">-</span>
                            </span>
                            <div class="mt-1 flex items-center gap-1.5 text-sm text-slate-600">
                                <x-heroicon-o-calendar-days class="h-4 w-4" />
                                <span id="fase-data">-</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4 md:w-2/3">
                        <div class="rounded-2xl border border-slate-200 bg-white p-3">
                            <p class="text-xs text-slate-500">Sq. vol. operative</p>
                            <div class="mt-1 flex items-center gap-2 text-lg font-semibold">
                                <x-heroicon-o-users class="h-5 w-5 text-brand-500" /> 0
                            </div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-3">
                            <p class="text-xs text-slate-500">Sq. vol. in attivazione</p>
                            <div class="mt-1 flex items-center gap-2 text-lg font-semibold">
                                <x-heroicon-o-users class="h-5 w-5 text-amber-500" /> 0
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Eventi attivi --}}
                <div class="mb-4 rounded-2xl border border-slate-200 bg-white p-4">
                    <h4 class="mb-2 inline-flex items-center gap-2 text-sm font-semibold text-slate-800">
                        <x-heroicon-o-information-circle class="h-4 w-4 text-brand-500" />
                        Eventi attivi sul territorio
                    </h4>
                    <p class="text-sm text-slate-600">Nessun evento attivo registrato per questo comune.</p>
                </div>

                {{-- Comunicazioni ultime 48 ore --}}
                <div class="mb-4 rounded-2xl border border-slate-200 bg-white p-4">
                    <h4 class="mb-3 inline-flex items-center gap-2 text-sm font-semibold text-slate-800">
                        <x-heroicon-o-phone class="h-4 w-4 text-brand-500" />
                        Comunicazioni telefoniche generiche intercorse (ultime 48 ore)
                    </h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-3 py-2 text-left">
                                        <span class="inline-flex items-center gap-1.5">
                                            <x-heroicon-o-calendar-days class="h-4 w-4" /> Data e ora
                                        </span>
                                    </th>
                                    <th class="px-3 py-2 text-left">
                                        <span class="inline-flex items-center gap-1.5">
                                            <x-heroicon-o-information-circle class="h-4 w-4" /> Sintesi
                                        </span>
                                    </th>
                                    <th class="px-3 py-2 text-left">
                                        <span class="inline-flex items-center gap-1.5">
                                            <x-heroicon-o-users class="h-4 w-4" /> Operatore
                                        </span>
                                    </th>
                                    <th class="px-3 py-2 text-left">
                                        <span class="inline-flex items-center gap-1.5">
                                            <x-heroicon-o-hashtag class="h-4 w-4" /> Azioni
                                        </span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="calls-tbody"></tbody>
                        </table>
                    </div>
                </div>

                {{-- Recapiti del Comune --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                    <div class="mb-3 flex items-center justify-between">
                        <h4 class="inline-flex items-center gap-2 text-sm font-semibold text-slate-800">
                            <x-heroicon-o-map-pin class="h-4 w-4 text-brand-500" />
                            Recapiti del Comune
                        </h4>
                        <button id="btn-google" type="button"
                            class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500">
                            <x-heroicon-o-arrow-top-right-on-square class="h-4 w-4" />
                            Cerca su Google
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-3 py-2 text-left">
                                        <span class="inline-flex items-center gap-1.5">
                                            <x-heroicon-o-information-circle class="h-4 w-4" /> Tipo recapito
                                        </span>
                                    </th>
                                    <th class="px-3 py-2 text-left">
                                        <span class="inline-flex items-center gap-1.5">
                                            <x-heroicon-o-phone class="h-4 w-4" /> Recapito
                                        </span>
                                    </th>
                                    <th class="px-3 py-2 text-left">
                                        <span class="inline-flex items-center gap-1.5">
                                            <x-heroicon-o-users class="h-4 w-4" /> Referente
                                        </span>
                                    </th>
                                    <th class="px-3 py-2 text-left">
                                        <span class="inline-flex items-center gap-1.5">
                                            <x-heroicon-o-information-circle class="h-4 w-4" /> Note
                                        </span>
                                    </th>
                                    <th class="px-3 py-2 text-left">
                                        <span class="inline-flex items-center gap-1.5">
                                            <x-heroicon-o-calendar-days class="h-4 w-4" /> Aggiornamento
                                        </span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="recapiti-tbody"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- FOOTER (non scrolla) --}}
            <div class="sticky bottom-0 z-10 border-t border-slate-200 bg-white/95 backdrop-blur px-6 py-4 supports-[backdrop-filter]:bg-white/80">
                <div class="flex justify-end">
                    <button id="modal-close-2"
                        class="inline-flex items-center justify-center rounded-xl h-10 px-4 text-sm font-medium bg-slate-600 text-white hover:bg-slate-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500">
                        Chiudi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================= MODALE DI MODIFICA (SOPRA) ============================= --}}
<div id="overlay-edit" class="fixed inset-0 z-[1100] bg-black/60 hidden"></div>

<div id="modal-edit" class="fixed inset-0 z-[1200] hidden overflow-y-auto">
    <div class="min-h-full flex items-center justify-center p-4">
        <div class="relative w-full max-w-2xl rounded-2xl border border-slate-200 bg-white shadow-xl flex flex-col max-h-[90vh]">
            {{-- Header --}}
            <div class="sticky top-0 z-10 px-6 pt-6 pb-3 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80">
                <button id="edit-close" class="absolute right-3 top-3 rounded-lg p-2 text-slate-400 hover:bg-slate-100" aria-label="Chiudi">
                    <x-heroicon-o-x-mark class="h-5 w-5" />
                </button>
                <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                    <x-heroicon-o-pencil-square class="h-5 w-5 text-amber-500" />
                    Modifica comunicazione
                </h3>
                <p class="text-sm text-slate-600">Aggiorna i dettagli della comunicazione selezionata.</p>
            </div>

            {{-- Body scrollabile --}}
            <div class="px-6 pb-6 overflow-y-auto">
                <form id="edit-form" class="grid gap-4">
                    <input type="hidden" id="edit-idx" />

                    <label class="grid gap-1.5 text-sm">
                        <span class="font-medium text-slate-700 inline-flex items-center gap-1.5">
                            <x-heroicon-o-calendar-days class="h-4 w-4" /> Data e ora
                        </span>
                        <input id="edit-ts" type="text" class="h-10 w-full rounded-xl border border-slate-300 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500" placeholder="es. 25/09/2025 09:31" />
                    </label>

                    <label class="grid gap-1.5 text-sm">
                        <span class="font-medium text-slate-700 inline-flex items-center gap-1.5">
                            <x-heroicon-o-users class="h-4 w-4" /> Operatore
                        </span>
                        <input id="edit-operatore" type="text" class="h-10 w-full rounded-xl border border-slate-300 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500" placeholder="Nome operatore" />
                    </label>

                    <label class="grid gap-1.5 text-sm">
                        <span class="font-medium text-slate-700 inline-flex items-center gap-1.5">
                            <x-heroicon-o-information-circle class="h-4 w-4" /> Sintesi
                        </span>
                        <textarea id="edit-sintesi" rows="5" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500" placeholder="Sintesi della chiamata..."></textarea>
                    </label>
                </form>
            </div>

            {{-- Footer --}}
            <div class="sticky bottom-0 z-10 border-t border-slate-200 bg-white/95 backdrop-blur px-6 py-4 supports-[backdrop-filter]:bg-white/80">
                <div class="flex justify-end gap-2">
                    <button id="edit-cancel" class="inline-flex items-center justify-center rounded-xl h-10 px-4 text-sm font-medium bg-slate-200 text-slate-900 hover:bg-slate-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500">
                        Annulla
                    </button>
                    <button id="edit-save" class="inline-flex items-center justify-center rounded-xl h-10 px-4 text-sm font-medium bg-amber-600 text-white hover:bg-amber-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500">
                        Salva
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================ STILI SCROLLBAR MODALI ============================ --}}
<style>
    #modal-body::-webkit-scrollbar,
    #modal-edit .overflow-y-auto::-webkit-scrollbar {
        width: 8px;
    }

    #modal-body::-webkit-scrollbar-thumb,
    #modal-edit .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 9999px;
    }

    #modal-body {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }

    #modal-edit .overflow-y-auto {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }
</style>

{{-- ============================ SCRIPT (UNICO) ============================ --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --------------------------- Dati mock ---------------------------
        const ROWS = [{
                comune: "Comune di Affi",
                stato: "chiusa dal 09/06/25",
                fase: "assenza allerta dal 17/06/25",
                attivazioni: ""
            },
            {
                comune: "Comune di Albaredo d'Adige",
                stato: "chiusa dal 11/09/25",
                fase: "assenza allerta dal 20/05/24",
                attivazioni: ""
            },
            {
                comune: "Comune di Angiari",
                stato: "chiusa dal 19/05/25",
                fase: "assenza allerta dal 14/05/25",
                attivazioni: ""
            },
            {
                comune: "Comune di Arcole",
                stato: "chiusa dal 28/02/24",
                fase: "assenza allerta dal 28/02/24",
                attivazioni: ""
            },
            {
                comune: "Comune di Badia Calavena",
                stato: "chiusa dal 08/09/24",
                fase: "assenza allerta dal 03/10/24",
                attivazioni: ""
            },
            {
                comune: "Comune di Bardolino",
                stato: "chiusa dal 25/08/25",
                fase: "assenza allerta dal 02/08/25",
                attivazioni: ""
            },
            {
                comune: "Comune di Belfiore",
                stato: "chiusa dal 17/05/24",
                fase: "assenza allerta dal 24/05/18",
                attivazioni: ""
            },
            {
                comune: "Comune di Bevilacqua",
                stato: "chiusa dal 08/09/24",
                fase: "assenza allerta dal 03/10/24",
                attivazioni: ""
            },
            {
                comune: "Comune di Bonavigo",
                stato: "chiusa dal 24/05/18",
                fase: "assenza allerta dal 24/05/18",
                attivazioni: ""
            },
            {
                comune: "Comune di Boschi Sant'Anna",
                stato: "chiusa dal 08/09/24",
                fase: "assenza allerta dal 24/05/18",
                attivazioni: ""
            },
        ];

        const RECENT_CALLS = [{
                ts: "25/09/2025 09:31",
                sintesi: "Provincia di Verona – grandinate in Valpolicella; Bussolengo e comuni verso il Garda. Verona città non interessata.",
                operatore: "emanuele barone"
            },
            {
                ts: "25/09/2025 05:59",
                sintesi: "DPC – richiesta informazioni meteo notturno. Riferita grandinata a Valdobbiadene.",
                operatore: "alberto favero"
            },
        ];
        let CALLS = RECENT_CALLS.slice();

        const RECAPITI_AFFI = [{
                tipo: "Cellulare",
                recapito: "3284174015",
                referente: "Sega Marco Giacomo",
                note: "SINDACO - Dato fornito da CFD",
                update: "09/06/2024"
            },
            {
                tipo: "Cellulare",
                recapito: "3382224626",
                referente: "Pezzo Ferdinando",
                note: "Dato fornito da CFD",
                update: "09/06/2024"
            },
            {
                tipo: "Cellulare",
                recapito: "3482443293",
                referente: "Ramon Stefano",
                note: "Dato fornito da CFD",
                update: "09/06/2024"
            },
            {
                tipo: "Telefono",
                recapito: "0456267472",
                referente: "Pezzo Ferdinando",
                note: "Dato fornito da CFD",
                update: "09/06/2024"
            },
            {
                tipo: "Telefono",
                recapito: "0457235042",
                referente: "Residori Ennio",
                note: "Resp. Lavori Pubblici - CFD",
                update: "09/06/2024"
            },
            {
                tipo: "PEC",
                recapito: "protocollo@pec.comune.affi.vr.it",
                referente: "",
                note: "Dato fornito da CFD",
                update: "09/06/2024"
            },
            {
                tipo: "Posta Elettronica",
                recapito: "sindaco@comune.affi.vr.it",
                referente: "Sega Marco Giacomo",
                note: "SINDACO - CFD",
                update: "09/06/2024"
            },
            {
                tipo: "Fax",
                recapito: "0456260473",
                referente: "",
                note: "",
                update: ""
            },
        ];

        // ------------------------------ Helpers ------------------------------
        const $ = s => document.querySelector(s);
        const $$ = s => Array.from(document.querySelectorAll(s));
        const esc = s => (s ?? '').toString().replace(/[&<>"']/g, m => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        } [m]));
        const splitDal = txt => {
            if (!txt) return ['-', '-'];
            const p = txt.split(' dal ');
            return [p[0] || '-', p[1] || '-'];
        };

        // --- Mappature colori semantici (no purge: inline HEX per l’accento di riga) ---
        function statoStyles(label) {
            const l = (label || '').toLowerCase();
            if (l.includes('aperta') || l.includes('presidio') || l.includes('attivo')) {
                return {
                    pill: 'bg-amber-100 text-amber-800',
                    dot: 'bg-amber-500'
                };
            }
            return {
                pill: 'bg-slate-100 text-slate-800',
                dot: 'bg-slate-400'
            }; // chiusa
        }

        function faseStyles(label) {
            const l = (label || '').toLowerCase();
            if (l.includes('allarme')) return {
                pill: 'bg-red-100 text-red-800',
                dot: 'bg-red-500',
                hex: '#fca5a5'
            }; // red-400
            if (l.includes('preallarme') || l.includes('attenzione'))
                return {
                    pill: 'bg-amber-100 text-amber-800',
                    dot: 'bg-amber-500',
                    hex: '#fbbf24'
                }; // amber-400
            return {
                pill: 'bg-emerald-100 text-emerald-800',
                dot: 'bg-emerald-500',
                hex: '#86efac'
            }; // emerald-300
        }
        const Dot = cls => `<span class="inline-block h-1.5 w-1.5 rounded-full ${cls}"></span>`;

        // ------------------------------ Rendering tabella ------------------------------
        const q = $('#q');
        const tbody = $('#tbody');
        const countEl = $('#count');
        const shownEl = $('#shown');

        function rowTpl(r, idx) {
            const [stLabel] = splitDal(r.stato);
            const [fzLabel] = splitDal(r.fase);
            const stC = statoStyles(stLabel);
            const fzC = faseStyles(fzLabel);

            return `
<tr class="hover:bg-slate-50" style="border-top:1px solid #e5e7eb; border-left:4px solid ${fzC.hex};">
  <td class="px-3 py-2">
    <button data-open="${idx}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-700 hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" title="Gestisci comune">
      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M16.862 4.487a1.5 1.5 0 0 1 2.121 2.121L8.25 17.34l-3 0.879 0.879-3 10.733-10.733Z" stroke-width="1.5"/></svg>
    </button>
  </td>
  <td class="px-3 py-2">
    <span class="inline-flex items-center gap-2 font-medium text-slate-800">
      <svg class="h-4 w-4 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 21h18M4.5 9.75h15M6 21V9.75m12 11.25V9.75M8.25 9.75V6a3.75 3.75 0 1 1 7.5 0v3.75" stroke-width="1.5"/></svg>
      ${esc(r.comune)}
    </span>
  </td>
  <td class="px-3 py-2">
    <span class="inline-flex items-center gap-1.5 rounded-full px-2 py-0.5 text-xs font-medium ${stC.pill}">
      ${Dot(stC.dot)} ${esc(stLabel)}
    </span>
    <span class="ml-2 text-xs text-slate-500">${esc(r.stato.split(' dal ')[1] || '')}</span>
  </td>
  <td class="px-3 py-2">
    <span class="inline-flex items-center gap-1.5 rounded-full px-2 py-0.5 text-xs font-medium ${faseStyles(fzLabel).pill}">
      ${Dot(fzC.dot)} ${esc(fzLabel)}
    </span>
    <span class="ml-2 text-xs text-slate-500">${esc(r.fase.split(' dal ')[1] || '')}</span>
  </td>
  <td class="px-3 py-2">
    ${r.attivazioni ? `<span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100 px-2 py-0.5 text-xs font-medium text-sky-800">
      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M7 8h10M7 12h10M7 16h10" stroke-width="1.5"/></svg>
      ${esc(r.attivazioni)}
    </span>` : `<span class="text-slate-400">—</span>`}
  </td>
</tr>`;
        }

        function render() {
            const needle = (q.value || '').toLowerCase().trim();
            const filtered = !needle ? ROWS : ROWS.filter(r =>
                r.comune.toLowerCase().includes(needle) ||
                r.stato.toLowerCase().includes(needle) ||
                r.fase.toLowerCase().includes(needle)
            );
            const page = filtered.slice(0, 10);
            tbody.innerHTML = page.map((r, i) => rowTpl(r, i)).join('');
            countEl.textContent = filtered.length;
            shownEl.textContent = page.length;

            $$('button[data-open]').forEach((btn, i) => {
                btn.addEventListener('click', () => {
                    const item = page[i];
                    if (item) openModal(item);
                });
            });
        }

        // ------------------------------- Modal Principale -------------------------------
        const overlay = $('#overlay');
        const modal = $('#modal');
        const modalClose = $('#modal-close');
        const modalClose2 = $('#modal-close-2');
        const titleEl = $('#modal-title');
        const cocStato = $('#coc-stato');
        const cocStatoData = $('#coc-stato-data');
        const fasePill = $('#fase-pill');
        const faseData = $('#fase-data');
        const callsTbody = $('#calls-tbody');
        const recapitiTbody = $('#recapiti-tbody');
        const btnGoogle = $('#btn-google');
        const cocPillEl = $('#coc-stato-pill');

        function lockBodyScroll() {
            document.documentElement.classList.add('overflow-hidden');
        }

        function unlockBodyScroll() {
            document.documentElement.classList.remove('overflow-hidden');
        }

        function renderCalls() {
            function draw() {
                callsTbody.innerHTML = CALLS.map((c, i) => `
                <tr class="border-t border-slate-200">
                    <td class="px-3 py-2 align-top">${esc(c.ts)}</td>
                    <td class="px-3 py-2 align-top">${esc(c.sintesi)}</td>
                    <td class="px-3 py-2 align-top capitalize">${esc(c.operatore)}</td>
                    <td class="px-3 py-2 align-top whitespace-nowrap min-w-[220px]">
                        <div class="flex items-center gap-2 flex-nowrap">
                            <button data-act="edit" data-idx="${i}" class="inline-flex items-center gap-1.5 h-8 px-3 rounded-lg bg-amber-500 text-white hover:bg-amber-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" title="Modifica">
                                <x-heroicon-o-pencil-square class="h-4 w-4" />
                                <span class="text-xs font-medium">Modifica</span>
                            </button>
                            <button data-act="delete" data-idx="${i}" class="inline-flex items-center gap-1.5 h-8 px-3 rounded-lg bg-red-600 text-white hover:bg-red-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" title="Elimina">
                                <x-heroicon-o-trash class="h-4 w-4" />
                                <span class="text-xs font-medium">Elimina</span>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('') || `<tr><td colspan="4" class="px-3 py-3 text-slate-500">Nessuna comunicazione nelle ultime 48 ore.</td></tr>`;
            }
            draw();

            callsTbody.onclick = (e) => {
                const btn = e.target.closest('button[data-act]');
                if (!btn) return;
                const idx = Number(btn.dataset.idx);
                const act = btn.dataset.act;

                if (act === 'delete') {
                    CALLS.splice(idx, 1);
                    draw();
                    return;
                }
                if (act === 'edit') {
                    openEditModal(idx);
                    return;
                }
            };
        }

        function iconForTipo(tipo) {
            const t = (tipo || '').toLowerCase();
            if (t.includes('cell')) return '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="7.5" y="2.25" width="9" height="19.5" rx="2" stroke-width="1.5"/><path d="M9 18.75h6" stroke-width="1.5"/></svg>';
            if (t === 'telefono') return '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2.25 6.75c0 7.18 7.82 13.5 12 13.5 1.15 0 2.36-.35 3.15-1.14l1.11-1.11a1.5 1.5 0 0 0 0-2.12l-2.06-2.06a1.5 1.5 0 0 0-2.12 0l-.62.62a.75.75 0 0 1-1.06 0l-2.13-2.13a.75.75 0 0 1 0-1.06l.62-.62a1.5 1.5 0 0 0 0-2.12L8.62 4.5a1.5 1.5 0 0 0-2.12 0L5.39 5.61C4.6 6.4 4.25 7.61 4.25 8.76" stroke-width="1.5"/></svg>';
            if (t.includes('pec')) return '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2.25 6.75a2.25 2.25 0 0 1 2.25-2.25h15a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-15A2.25 2.25 0 0 1 2.25 17.25V6.75Z" stroke-width="1.5"/><path d="m3 7 9 6 9-6" stroke-width="1.5"/></svg>';
            if (t.includes('posta elettronica') || t.includes('email') || t.includes('@'))
                return '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 7h18M3 7l9 6 9-6" stroke-width="1.5"/><rect x="3" y="7" width="18" height="10" rx="2" stroke-width="1.5"/></svg>';
            if (t.includes('fax')) return '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M7.5 8.25V3h9v5.25" stroke-width="1.5"/><rect x="3" y="8.25" width="18" height="9.75" rx="2" stroke-width="1.5"/><path d="M7.5 12h9" stroke-width="1.5"/></svg>';
            return '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M11.25 3.75h1.5v1.5h-1.5v-1.5Zm0 4.5h1.5v12h-1.5v-12Z" stroke-width="1.5"/></svg>';
        }

        function renderRecapiti(item) {
            let recapiti = [];
            if ((item.comune || '').toLowerCase().includes('affi')) recapiti = RECAPITI_AFFI;
            const recapitiTbody = $('#recapiti-tbody');
            recapitiTbody.innerHTML = recapiti.length ? recapiti.map(r => `
            <tr class="border-t border-slate-200">
                <td class="px-3 py-2"><span class="inline-flex items-center gap-1.5">${iconForTipo(r.tipo)} ${esc(r.tipo)}</span></td>
                <td class="px-3 py-2">${esc(r.recapito || '-')}</td>
                <td class="px-3 py-2">${esc(r.referente || '-')}</td>
                <td class="px-3 py-2">${esc(r.note || '-')}</td>
                <td class="px-3 py-2">${esc(r.update || '-')}</td>
            </tr>
        `).join('') : `<tr><td colspan="5" class="px-3 py-3 text-slate-500">Nessun recapito disponibile.</td></tr>`;
        }

        function openModal(item) {
            titleEl.textContent = `Gestione segnalazioni ${item.comune}`;

            const [stLabel, stDate] = splitDal(item.stato);
            const [fzLabel, fzDate] = splitDal(item.fase);
            const stC = statoStyles(stLabel);
            const fzC = faseStyles(fzLabel);

            // Stato COC
            cocStato.textContent = stLabel || '-';
            cocStatoData.textContent = stDate || '-';
            cocPillEl.className = `inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium ${stC.pill}`;
            cocPillEl.innerHTML = `${Dot(stC.dot)} <span id="coc-stato">${esc(stLabel || '-')}</span>`;

            // Fase
            const faseWrapper = fasePill.parentElement;
            faseWrapper.className = `inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium ${fzC.pill}`;
            fasePill.textContent = fzLabel || '-';
            faseData.textContent = fzDate || '-';

            renderCalls();
            renderRecapiti(item);

            btnGoogle.onclick = () => {
                const url = `https://www.google.com/search?q=${encodeURIComponent(item.comune)}`;
                window.open(url, '_blank');
            };

            overlay.classList.remove('hidden');
            modal.classList.remove('hidden');
            lockBodyScroll();
            document.addEventListener('keydown', escHandlerMain);
        }

        function closeModal() {
            modal.classList.add('hidden');
            overlay.classList.add('hidden');
            unlockBodyScroll();
            document.removeEventListener('keydown', escHandlerMain);
        }

        function escHandlerMain(e) {
            if (e.key === 'Escape') closeModal();
        }
        $('#modal-close').addEventListener('click', closeModal);
        $('#modal-close-2').addEventListener('click', closeModal);
        $('#overlay').addEventListener('click', closeModal);

        // ------------------------------- Modale di Modifica (sopra) -------------------------------
        const overlayEdit = $('#overlay-edit');
        const modalEdit = $('#modal-edit');
        const editClose = $('#edit-close');
        const editCancel = $('#edit-cancel');
        const editSave = $('#edit-save');
        const editIdx = $('#edit-idx');
        const editTs = $('#edit-ts');
        const editOperatore = $('#edit-operatore');
        const editSintesi = $('#edit-sintesi');

        function openEditModal(idx) {
            const c = CALLS[idx] || {
                ts: '',
                sintesi: '',
                operatore: ''
            };
            editIdx.value = idx;
            editTs.value = c.ts || '';
            editOperatore.value = c.operatore || '';
            editSintesi.value = c.sintesi || '';

            overlayEdit.classList.remove('hidden');
            modalEdit.classList.remove('hidden');
            setTimeout(() => editTs.focus(), 0);
            document.addEventListener('keydown', escHandlerEdit);
        }

        function closeEditModal() {
            modalEdit.classList.add('hidden');
            overlayEdit.classList.add('hidden');
            document.removeEventListener('keydown', escHandlerEdit);
        }

        function escHandlerEdit(e) {
            if (e.key === 'Escape') closeEditModal();
        }

        editClose.addEventListener('click', closeEditModal);
        editCancel.addEventListener('click', (e) => {
            e.preventDefault();
            closeEditModal();
        });
        overlayEdit.addEventListener('click', closeEditModal);
        editSave.addEventListener('click', (e) => {
            e.preventDefault();
            const idx = Number(editIdx.value);
            if (Number.isNaN(idx) || !CALLS[idx]) {
                closeEditModal();
                return;
            }
            CALLS[idx] = {
                ts: editTs.value.trim(),
                operatore: editOperatore.value.trim(),
                sintesi: editSintesi.value.trim()
            };
            renderCalls();
            closeEditModal();
        });

        // ------------------------------- Search -------------------------------
        q.addEventListener('input', render);

        // init
        render();
    });
</script>