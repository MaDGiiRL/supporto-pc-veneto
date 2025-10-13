<div class="p-6">
    <header class="mb-4">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold">{{ $page['label'] ?? 'Segnalazione generica' }}</h2>
                <p class="text-sm opacity-75 mt-1">Gestisci le segnalazioni generiche e di protezione civile.</p>
            </div>
            <button type="button"
                class="btn-open-modal inline-flex items-center gap-2 rounded-xl h-10 px-4 text-sm font-medium
                           bg-brand-600 text-white hover:bg-brand-700
                           focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-brand-500">
                <x-heroicon-o-plus class="h-4 w-4" />
                Nuova segnalazione
            </button>
        </div>
    </header>

    {{-- Empty state / placeholder lista segnalazioni --}}
    <div id="empty-state" class="rounded-2xl border border-slate-200 bg-white/70 shadow-card p-8 text-center">
        <div class="mx-auto flex size-16 items-center justify-center rounded-full bg-amber-50 ring-1 ring-amber-100 mb-3">
            <x-heroicon-o-exclamation-triangle class="h-8 w-8 text-amber-500" />
        </div>
        <h3 class="text-lg font-semibold text-slate-900">Nessuna segnalazione in elenco</h3>
        <p class="mx-auto mt-1 max-w-prose text-sm text-slate-600">Crea una nuova segnalazione per avviare il tracciamento dell’evento.</p>
        <div class="mt-4">
            <button type="button"
                class="btn-open-modal inline-flex items-center gap-2 rounded-xl h-10 px-4 text-sm font-medium
                           bg-brand-600 text-white hover:bg-brand-700
                           focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-brand-500">
                <x-heroicon-o-plus class="h-4 w-4" />
                Nuova segnalazione
            </button>
        </div>
    </div>

    {{-- (Opzionale) elenco segnalazioni create in questa sessione UI --}}
    <div id="list-wrapper" class="mt-6 hidden">
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card">
            <div class="border-b border-slate-200 px-4 py-3">
                <h3 class="text-base font-semibold text-slate-800">Segnalazioni recenti (UI)</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-left">
                        <tr>
                            <th class="px-3 py-2">Data/Ora</th>
                            <th class="px-3 py-2">Titolo</th>
                            <th class="px-3 py-2">Categoria</th>
                            <th class="px-3 py-2">Comune</th>
                            <th class="px-3 py-2">Priorità</th>
                            <th class="px-3 py-2 text-right">Azioni</th>
                        </tr>
                    </thead>
                    <tbody id="tbl-body"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ============================== MODALE ============================== --}}
<div id="overlay" class="fixed inset-0 z-[100000] bg-black/70 hidden"></div>

<div id="modal" class="fixed inset-0 z-[100001] hidden">
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="relative w-full max-w-4xl rounded-2xl border border-slate-200 bg-white shadow-lg p-6">
            <button type="button" id="btn-close"
                class="absolute right-3 top-3 rounded-lg p-2 text-slate-500 hover:bg-slate-100"
                aria-label="Chiudi">
                <x-heroicon-o-x-mark class="h-5 w-5" />
            </button>

            <div class="mb-1 inline-flex items-center gap-2">
                <span class="inline-flex size-7 items-center justify-center rounded-full bg-amber-50 ring-1 ring-amber-100">
                    <x-heroicon-o-exclamation-triangle class="h-4 w-4 text-amber-600" />
                </span>
                <h3 class="text-lg font-semibold">Segnalazione evento</h3>
            </div>
            <p class="mb-4 text-sm text-slate-600">Da utilizzare per registrare segnalazioni di eventi (generiche o di protezione civile)</p>

            <form id="form" class="grid gap-4 max-h-[75vh] overflow-auto pr-1">

                {{-- ========== BLOCCO INTESTAZIONE ========== --}}
                <div class="rounded-2xl border border-slate-200 bg-white/70 p-4">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <label class="grid gap-1.5">
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                <x-heroicon-o-tag class="h-4 w-4 text-slate-500" /> Categoria evento <span class="text-red-600">*</span>
                            </span>
                            <select name="categoria" id="fld-categoria" required
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                           focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500">
                                <option value="incendio_boschivo">Incendio boschivo</option>
                                <option value="alluvione">Alluvione</option>
                                <option value="frana">Frana</option>
                                <option value="neve">Neve/Ghiaccio</option>
                                <option value="vento">Vento</option>
                                <option value="altro">Altro</option>
                            </select>
                        </label>

                        <label class="grid gap-1.5">
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                <x-heroicon-o-adjustments-horizontal class="h-4 w-4 text-slate-500" /> Priorità <span class="text-red-600">*</span>
                            </span>
                            <select name="priorita" required
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                           focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500">
                                <option value="bassa">Bassa</option>
                                <option value="media" selected>Media</option>
                                <option value="alta">Alta</option>
                                <option value="critica">Critica</option>
                            </select>
                        </label>

                        <label class="grid gap-1.5">
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                <x-heroicon-o-document-text class="h-4 w-4 text-slate-500" /> Titolo segnalazione <span class="text-red-600">*</span>
                            </span>
                            <input name="titolo" maxlength="100" required placeholder="Es. Fumo avvistato in località Bosco Alto"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                          placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
                            <span class="text-xs text-slate-500">Breve descrizione (max 100 caratteri)</span>
                        </label>

                        <label class="grid gap-1.5">
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                <x-heroicon-o-map-pin class="h-4 w-4 text-slate-500" /> Selezionare il comune interessato <span class="text-red-600">*</span>
                            </span>
                            <input name="comune" required placeholder="Es. Adria"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                          placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
                            <span class="text-xs text-slate-500">Digita per cercare. (Suggerimento: integra una combobox)</span>
                        </label>

                        <label class="grid gap-1.5">
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                <x-heroicon-o-user class="h-4 w-4 text-slate-500" /> Persona di contatto
                            </span>
                            <input name="contatto" placeholder="Es. Mario Rossi – 3331234567"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                          placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
                            <span class="text-xs text-slate-500">Inserire nominativo e recapito</span>
                        </label>

                        <label class="grid gap-1.5">
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                <x-heroicon-o-cursor-arrow-rays class="h-4 w-4 text-slate-500" /> Latitudine <span class="text-red-600">*</span>
                            </span>
                            <input name="lat" type="number" step="0.000001" required placeholder="45.123456"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                          placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
                            <span class="text-xs text-slate-500">Latitudine 45... N in formato decimale</span>
                        </label>

                        <label class="grid gap-1.5">
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                <x-heroicon-o-cursor-arrow-rays class="h-4 w-4 text-slate-500" /> Longitudine <span class="text-red-600">*</span>
                            </span>
                            <input name="lon" type="number" step="0.000001" required placeholder="11.123456"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                          placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
                            <span class="text-xs text-slate-500">Longitudine 11... E in formato decimale</span>
                        </label>

                        <div class="md:col-span-2">
                            <button type="button"
                                class="inline-flex items-center gap-2 rounded-xl h-10 px-4 text-sm font-medium
                                           border border-slate-300 text-slate-800 hover:bg-slate-50
                                           focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-brand-500"
                                onclick="alert('Convertitore coordinate: da implementare')">
                                <x-heroicon-o-cursor-arrow-rays class="h-4 w-4" />
                                Convertitore coordinate
                            </button>
                        </div>

                        <label class="md:col-span-2 grid gap-1.5">
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                <x-heroicon-o-map-pin class="h-4 w-4 text-slate-500" /> Località
                            </span>
                            <input name="localita" placeholder="Es. Località Bosco Alto"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                          placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
                        </label>
                    </div>

                    <label class="mt-3 grid gap-1.5">
                        <span class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-700">
                            <x-heroicon-o-document-text class="h-4 w-4 text-slate-500" /> Note iniziali
                        </span>
                        <textarea name="noteIniziali" rows="3" placeholder="Descrizione iniziale dell'evento"
                            class="min-h-24 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm
                                         placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500"></textarea>
                        <span class="text-xs text-slate-500">
                            Indicare, se disponibili, gli effetti complessivamente subiti dai territori comunali selezionati a causa dell'evento.
                        </span>
                    </label>
                </div>

                {{-- ========== BLOCCO NECESSITÀ/NOTE FINALI ========== --}}
                <div class="rounded-2xl border border-slate-200 bg-white/70 p-4">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <label class="grid gap-1.5">
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                <x-heroicon-o-exclamation-triangle class="h-4 w-4 text-slate-500" /> Necessità
                            </span>
                            <textarea name="necessita" rows="3" placeholder="Es. mezzi aggiuntivi, supporto VVF…"
                                class="min-h-24 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm
                                             placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500"></textarea>
                        </label>
                        <label class="grid gap-1.5">
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                <x-heroicon-o-document-text class="h-4 w-4 text-slate-500" /> Note finali
                            </span>
                            <textarea name="noteFinali" rows="3" placeholder="Informazioni complementari"
                                class="min-h-24 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm
                                             placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500"></textarea>
                        </label>
                    </div>
                </div>

                {{-- ========== BLOCCO EFFETTI POPOLAZIONE/TERRITORIO ========== --}}
                <div class="rounded-2xl border border-slate-200 bg-white/70 p-4">
                    <div class="mb-2 flex items-center gap-2">
                        <x-heroicon-o-information-circle class="h-5 w-5 text-amber-600" />
                        <h4 class="text-sm font-semibold text-slate-800">Effetti su popolazione e territorio</h4>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <label class="grid gap-1.5">
                            <span class="text-sm font-medium text-slate-700">Tipologia abitato</span>
                            <input name="tipologiaAbitato" placeholder="Sparso, urbano, montano…"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                          placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
                        </label>
                        <label class="grid gap-1.5">
                            <span class="text-sm font-medium text-slate-700">Estensione territoriale</span>
                            <input name="estensione" placeholder="Es. areale 3 km²"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                          placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
                        </label>
                        <label class="grid gap-1.5">
                            <span class="text-sm font-medium text-slate-700">Popolazione coinvolta</span>
                            <input name="popolazioneCoinvolta" placeholder="Stima persone"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                          placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
                        </label>
                    </div>

                    <div class="mt-2 grid grid-cols-1 gap-4 md:grid-cols-4">
                        @foreach ([
                        ['name'=>'deceduti','label'=>'Deceduti','type'=>'number'],
                        ['name'=>'feriti','label'=>'Feriti','type'=>'number'],
                        ['name'=>'isolati','label'=>'Popolazione isolata','type'=>'number'],
                        ['name'=>'noteIsolati','label'=>'Note isolati'],
                        ['name'=>'evacuati','label'=>'Popolazione evacuata','type'=>'number'],
                        ['name'=>'noteEvacuati','label'=>'Note evacuati'],
                        ] as $f)
                        <label class="grid gap-1.5">
                            <span class="text-sm font-medium text-slate-700">{{ $f['label'] }}</span>
                            @if (($f['type'] ?? '') === 'number')
                            <input name="{{ $f['name'] }}" type="number" min="0" value="0"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                              focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
                            @else
                            <input name="{{ $f['name'] }}"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                              focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
                            @endif
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- ========== BLOCCO INFRASTRUTTURE/SERVIZI ========== --}}
                <div class="rounded-2xl border border-slate-200 bg-white/70 p-4">
                    <h4 class="mb-2 text-sm font-semibold text-slate-800">Infrastrutture e servizi</h4>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @foreach ([
                        ['energia','Problematiche energia elettrica'],
                        ['noteEnergia','Note energia elettrica'],
                        ['acqua','Problematiche acqua potabile'],
                        ['noteAcqua','Note acqua potabile'],
                        ['tlc','Problematiche telecomunicazioni'],
                        ['noteTlc','Note telecomunicazioni'],
                        ['viabilitaLocale','Problematiche viabilità locale'],
                        ['noteViabilitaLocale','Note viabilità locale'],
                        ['accessibilita','Problematiche accessibilità stradale'],
                        ['noteAccesso',"Note vie d'accesso"],
                        ] as $f)
                        <label class="grid gap-1.5">
                            <span class="text-sm font-medium text-slate-700">{{ $f[1] }}</span>
                            <input name="{{ $f[0] }}"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                          focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- ========== BLOCCO ALLEGATI ========== --}}
                <div class="rounded-2xl border border-slate-200 bg-white/70 p-4">
                    <h4 class="mb-2 text-sm font-semibold text-slate-800">Allegati</h4>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium text-slate-700">Link a file esterni (facoltativo)</span>
                        <input name="allegatiUrl" placeholder="https://..., https://..."
                            class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                      placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
                        <span class="text-xs text-slate-500">Inserisci URL separati da virgola (Drive, foto, PDF, ecc.)</span>
                    </label>
                </div>

                {{-- ========== BLOCCO SPECIFICO AIB (solo categoria incendio_boschivo) ========== --}}
                <div id="aib-extra" class="rounded-2xl border border-amber-200 bg-amber-50 p-4 hidden">
                    <div class="mb-2 flex items-center gap-2 text-amber-700">
                        <x-heroicon-o-fire class="h-5 w-5" />
                        <h4 class="text-sm font-semibold">Campi specifici AIB (opzionali)</h4>
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <label class="grid gap-1.5">
                            <span class="text-sm font-medium text-slate-700">Tipo combustibile</span>
                            <input name="aib_combustibile" placeholder="Es. Bosco di pino"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                          focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
                        </label>
                        <label class="grid gap-1.5">
                            <span class="text-sm font-medium text-slate-700">Direzione vento</span>
                            <input name="aib_dirVento" placeholder="Es. NE (45°)"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                          focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
                        </label>
                        <label class="grid gap-1.5">
                            <span class="text-sm font-medium text-slate-700">Velocità vento (km/h)</span>
                            <input name="aib_velVento" type="number" min="0" placeholder="Es. 20"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                          focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500" />
                        </label>
                    </div>
                </div>

                {{-- Footer form --}}
                <div class="flex flex-wrap items-center justify-end gap-2 pt-2">
                    <button type="button" id="btn-cancel"
                        class="rounded-xl h-10 px-4 text-sm font-medium
                                   bg-slate-100 text-slate-900 hover:bg-slate-200">
                        Annulla
                    </button>
                    <button type="submit"
                        class="rounded-xl h-10 px-4 text-sm font-medium
                                   bg-brand-600 text-white hover:bg-brand-700
                                   focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-brand-500">
                        Salva segnalazione
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================== SCRIPT ============================== --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const overlay = document.getElementById('overlay');
        const modal = document.getElementById('modal');
        const btnClose = document.getElementById('btn-close');
        const btnCancel = document.getElementById('btn-cancel');
        const form = document.getElementById('form');
        const catSel = document.getElementById('fld-categoria');
        const aibExtra = document.getElementById('aib-extra');

        const openers = Array.from(document.querySelectorAll('.btn-open-modal'));
        openers.forEach(b => b.addEventListener('click', openModal));

        function openModal() {
            overlay.classList.remove('hidden');
            modal.classList.remove('hidden');
        }

        function closeModal() {
            overlay.classList.add('hidden');
            modal.classList.add('hidden');
        }
        overlay.addEventListener('click', closeModal);
        btnClose.addEventListener('click', closeModal);
        btnCancel.addEventListener('click', closeModal);

        // Toggle blocco AIB su categoria
        function toggleAIB() {
            const isAIB = (catSel.value === 'incendio_boschivo');
            aibExtra.classList.toggle('hidden', !isAIB);
        }
        catSel.addEventListener('change', toggleAIB);
        toggleAIB(); // init

        // Mock: salvataggio + append su lista locale (solo UI)
        const tblBody = document.getElementById('tbl-body');
        const empty = document.getElementById('empty-state');
        const listWrap = document.getElementById('list-wrapper');

        form.addEventListener('submit', (e) => {
            e.preventDefault();

            const data = Object.fromEntries(new FormData(form).entries());
            // piccola validazione base (già required HTML)
            const now = new Date();
            const pad = n => String(n).padStart(2, '0');
            const stamp = `${pad(now.getDate())}/${pad(now.getMonth()+1)}/${now.getFullYear()} ${pad(now.getHours())}:${pad(now.getMinutes())}`;

            // append riga a tabella UI
            const tr = document.createElement('tr');
            tr.className = 'border-t border-slate-200 hover:bg-slate-50';
            tr.innerHTML = `
            <td class="px-3 py-2 align-top text-slate-800">${stamp}</td>
            <td class="px-3 py-2 align-top text-slate-800">${escapeHtml(data.titolo || '')}</td>
            <td class="px-3 py-2 align-top">
                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-semibold
                             bg-brand-50 text-brand-800 ring-1 ring-inset ring-brand-200">
                    ${escapeHtml(data.categoria || '')}
                </span>
            </td>
            <td class="px-3 py-2 align-top text-slate-800">${escapeHtml(data.comune || '')}</td>
            <td class="px-3 py-2 align-top">
                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-semibold
                             ${chipByPriority(data.priorita)}">
                    ${escapeHtml(data.priorita || '')}
                </span>
            </td>
            <td class="px-3 py-2 align-top text-right">
                <button class="rounded-xl p-2 text-slate-600 hover:bg-slate-100" title="Dettagli">
                    <x-heroicon-o-document-text class="h-4 w-4" />
                </button>
            </td>
        `;
            tblBody.prepend(tr);

            // mostra lista, nasconde empty state
            empty.classList.add('hidden');
            listWrap.classList.remove('hidden');

            alert('Segnalazione salvata (solo UI).');
            form.reset();
            toggleAIB();
            closeModal();
        });

        function escapeHtml(s) {
            return (s ?? '').replace(/[&<>"']/g, m => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            } [m]));
        }

        function chipByPriority(p) {
            switch (p) {
                case 'critica':
                    return 'bg-red-50 text-red-800 ring-1 ring-inset ring-red-200';
                case 'alta':
                    return 'bg-amber-50 text-amber-800 ring-1 ring-inset ring-amber-200';
                case 'media':
                    return 'bg-brand-50 text-brand-800 ring-1 ring-inset ring-brand-200';
                default:
                    return 'bg-slate-100 text-slate-800 ring-1 ring-inset ring-slate-200';
            }
        }
    });
</script>