<div class="p-6">
    <header class="mb-4">
        <h2 class="text-xl font-semibold">Telefonata reperibilità</h2>
        <p class="text-sm opacity-75 mt-1">Registra e consulta le telefonate di pronto reperibilità.</p>
    </header>

    @php
    // Seed iniziale (come nel componente React)
    $seed = [
    [
    'data' => '25/09/2025 09:31',
    'tipo' => 'U',
    'ente' => 'Provincia di Verona',
    'comune' => '',
    'sintesi' => "Armando Lorenzini 3351415320 segnala grandinate intense su Valpolicella (Bussolengo). Verona città non interessata.",
    'operatore' => 'emanuele barone',
    ],
    [
    'data' => '25/09/2025 09:21',
    'tipo' => 'U',
    'ente' => 'Provincia di Treviso',
    'comune' => '',
    'sintesi' => "Mina Carlucci 0422656663 chiede info su grandinate. Nessuna segnalazione ricevuta dal territorio.",
    'operatore' => 'nicola zennaro',
    ],
    [
    'data' => '25/09/2025 05:59',
    'tipo' => 'E',
    'ente' => 'Dipartimento Protezione Civile',
    'comune' => 'Valdobbiadene',
    'sintesi' => "SSI 0066804 chiede info meteo notte. Riferita grandinata a Valdobbiadene.",
    'operatore' => 'alberto favero',
    ],
    ];
    @endphp

    {{-- ========================= FORM REGISTRAZIONE ========================= --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white shadow-card p-4">
        <form id="form-telefonata" class="grid gap-4 md:grid-cols-2">
            <label class="grid gap-1.5 text-sm">
                <span class="inline-flex items-center gap-1.5 font-medium text-slate-700">
                    <x-heroicon-o-phone-arrow-down-left class="h-4 w-4" /> Entrata/Uscita
                </span>
                <select id="tipo"
                    class="h-10 w-full rounded-lg border border-slate-300 bg-white px-3 text-sm
                               focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <option value="E">Entrata</option>
                    <option value="U">Uscita</option>
                </select>
            </label>

            <label class="grid gap-1.5 text-sm">
                <span class="inline-flex items-center gap-1.5 font-medium text-slate-700">
                    <x-heroicon-o-user class="h-4 w-4" /> Segnalante
                </span>
                <input id="segnalante"
                    class="h-10 w-full rounded-lg border border-slate-300 bg-white px-3 text-sm
                              focus:outline-none focus:ring-2 focus:ring-brand-500" />
            </label>

            <label class="grid gap-1.5 text-sm">
                <span class="inline-flex items-center gap-1.5 font-medium text-slate-700">
                    <x-heroicon-o-phone class="h-4 w-4" /> Recapito telefonico
                </span>
                <input id="recapito"
                    class="h-10 w-full rounded-lg border border-slate-300 bg-white px-3 text-sm
                              focus:outline-none focus:ring-2 focus:ring-brand-500" />
            </label>

            <label class="grid gap-1.5 text-sm">
                <span class="inline-flex items-center gap-1.5 font-medium text-slate-700">
                    <x-heroicon-o-map-pin class="h-4 w-4" /> Comune
                </span>
                <input id="comune"
                    class="h-10 w-full rounded-lg border border-slate-300 bg-white px-3 text-sm
                              focus:outline-none focus:ring-2 focus:ring-brand-500" />
            </label>

            <div class="md:col-span-2">
                <label class="grid gap-1.5 text-sm">
                    <span class="inline-flex items-center gap-1.5 font-medium text-slate-700">
                        <x-heroicon-o-document-text class="h-4 w-4" /> Sintesi della telefonata
                    </span>
                    <textarea id="sintesi" rows="3"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm
                                     focus:outline-none focus:ring-2 focus:ring-brand-500"></textarea>
                </label>
            </div>

            <div class="md:col-span-2 flex justify-end">
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium
                               bg-brand-600 text-white hover:bg-brand-700
                               focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <x-heroicon-o-phone-arrow-down-left class="h-4 w-4" />
                    Registra Telefonata
                </button>
            </div>
        </form>
    </div>

    {{-- ============================== TABELLA ============================== --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-card p-4">
        <div class="mb-3 flex items-center justify-between gap-3">
            <h3 class="text-sm font-semibold">Telefonate ultime 24 ore</h3>

            <div class="flex items-center gap-2">
                <x-heroicon-o-magnifying-glass class="h-4 w-4 text-slate-400" />
                <input id="q" placeholder="Cerca…"
                    class="h-9 w-48 rounded-lg border border-slate-300 bg-white px-3 text-sm
                              focus:outline-none focus:ring-2 focus:ring-brand-500" />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="px-3 py-2">
                            <span class="inline-flex items-center gap-1.5">
                                <x-heroicon-o-calendar-days class="h-4 w-4" /> Data e ora
                            </span>
                        </th>
                        <th class="px-3 py-2">
                            <span class="inline-flex items-center gap-1.5">
                                <x-heroicon-o-phone-arrow-down-left class="h-4 w-4" /> E/U
                            </span>
                        </th>
                        <th class="px-3 py-2">
                            <span class="inline-flex items-center gap-1.5">
                                <x-heroicon-o-user class="h-4 w-4" /> Ente
                            </span>
                        </th>
                        <th class="px-3 py-2">
                            <span class="inline-flex items-center gap-1.5">
                                <x-heroicon-o-map-pin class="h-4 w-4" /> Comune
                            </span>
                        </th>
                        <th class="px-3 py-2">
                            <span class="inline-flex items-center gap-1.5">
                                <x-heroicon-o-document-text class="h-4 w-4" /> Sintesi
                            </span>
                        </th>
                        <th class="px-3 py-2">
                            <span class="inline-flex items-center gap-1.5">
                                <x-heroicon-o-user class="h-4 w-4" /> Operatore
                            </span>
                        </th>
                        <th class="px-3 py-2">
                            <span class="inline-flex items-center gap-1.5">
                                <x-heroicon-o-archive-box class="h-4 w-4" /> Azioni
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
        </div>
    </div>
</div>

{{-- ============================ SCRIPT ============================ --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Seed iniziale
        const SEED = @json($seed);
        let rows = SEED.map((r, i) => ({
            id: Date.now() + i,
            archived: false,
            ...r
        }));

        // Refs
        const form = document.getElementById('form-telefonata');
        const tipo = document.getElementById('tipo');
        const segnalante = document.getElementById('segnalante');
        const recapito = document.getElementById('recapito');
        const comune = document.getElementById('comune');
        const sintesi = document.getElementById('sintesi');
        const q = document.getElementById('q');
        const tbody = document.getElementById('tbody');

        function escapeHtml(s) {
            return (s ?? '').replace(/[&<>"']/g, m => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            } [m]));
        }

        function pill(tipo) {
            const isE = tipo === 'E';
            const base = 'inline-flex items-center gap-1 h-6 px-2 rounded-full text-xs font-semibold';
            const cls = isE ? ' bg-brand-100 text-brand-800' : ' bg-slate-100 text-slate-800';
            const icon = isE
                // ArrowDownLeft
                ?
                '<svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M15.75 8.25 8.25 15.75M8.25 15.75V8.25M8.25 15.75h7.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>'
                // ArrowUpRight
                :
                '<svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M8.25 15.75 15.75 8.25M15.75 8.25V15.75M15.75 8.25h-7.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            return `<span class="${base + cls}" title="${isE ? 'Entrata' : 'Uscita'}">${icon}${tipo}</span>`;
        }

        function rowTpl(r) {
            const dim = r.archived ? ' opacity-60' : '';
            return `
        <tr class="border-t border-slate-200${dim}">
            <td class="px-3 py-2">${escapeHtml(r.data)}</td>
            <td class="px-3 py-2">${pill(r.tipo)}</td>
            <td class="px-3 py-2">${escapeHtml(r.ente)}</td>
            <td class="px-3 py-2">${escapeHtml(r.comune || '')}</td>
            <td class="px-3 py-2">${escapeHtml(r.sintesi)}</td>
            <td class="px-3 py-2">${escapeHtml(r.operatore || '')}</td>
            <td class="px-3 py-2">
                <div class="flex gap-2">
                    <button data-action="archive" data-id="${r.id}"
                        class="rounded p-1 hover:bg-slate-100" title="${r.archived ? 'Ripristina' : 'Archivia'}">
                        <svg class="h-4 w-4 ${r.archived ? 'text-slate-500' : 'text-brand-600'}" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M3 7h18M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M6 7v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7" stroke-width="1.5"/>
                        </svg>
                    </button>
                    <button data-action="delete" data-id="${r.id}"
                        class="rounded p-1 hover:bg-slate-100" title="Elimina">
                        <svg class="h-4 w-4 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M6 7h12M9 7V5h6v2M8 7v12a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V7" stroke-width="1.5"/>
                        </svg>
                    </button>
                </div>
            </td>
        </tr>`;
        }

        function render() {
            const qv = (q.value || '').toLowerCase().trim();
            const filtered = rows.filter(r => {
                if (qv) {
                    const hay = [r.data, r.tipo, r.ente, r.comune, r.sintesi, r.operatore].join(' ').toLowerCase();
                    return hay.includes(qv);
                }
                return true;
            });
            tbody.innerHTML = filtered.map(rowTpl).join('');
        }

        // Submit form
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const now = new Date().toLocaleString('it-IT', {
                hour12: false
            });
            rows = [{
                    id: Date.now(),
                    archived: false,
                    data: now,
                    tipo: tipo.value || 'E',
                    ente: segnalante.value || '',
                    comune: comune.value || '',
                    sintesi: sintesi.value || '',
                    operatore: 'operatore demo',
                },
                ...rows
            ];
            // reset
            form.reset();
            tipo.value = 'E';
            render();
        });

        // Azioni archivio/elimina (delegation)
        tbody.addEventListener('click', (e) => {
            const btn = e.target.closest('button[data-action]');
            if (!btn) return;
            const id = Number(btn.getAttribute('data-id'));
            const action = btn.getAttribute('data-action');

            if (action === 'archive') {
                rows = rows.map(r => r.id === id ? {
                    ...r,
                    archived: !r.archived
                } : r);
            } else if (action === 'delete') {
                rows = rows.filter(r => r.id !== id);
            }
            render();
        });

        // Ricerca
        q.addEventListener('input', render);

        // Start
        render();
    });
</script>