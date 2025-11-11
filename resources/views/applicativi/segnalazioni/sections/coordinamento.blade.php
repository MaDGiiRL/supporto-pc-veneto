<style>
    /* ====== STYLES (identici ai tuoi, compattati) ====== */
    :root {
        --line: #e2e8f0;
        --bg: #f7f9fc;
        --card: #fff;
        --muted: #64748b;
        --txt: #0f172a;
        --blue: #2563eb;
        --blue-50: #eff6ff;
        --amber: #d97706;
        --amber-50: #fffbeb;
        --slate-50: #f1f5f9;
        --shadow: 0 12px 34px rgba(2, 6, 23, .10), 0 1px 3px rgba(2, 6, 23, .06);
        --ev-sismico: #dc2626;
        --ev-sismico-50: #fef2f2;
        --ev-vulcanico: #9a3412;
        --ev-vulcanico-50: #fff7ed;
        --ev-idraulico: #0ea5e9;
        --ev-idraulico-50: #e0f2fe;
        --ev-idrogeologico: #10b981;
        --ev-idrogeologico-50: #d1fae5;
        --ev-maremoto: #0284c7;
        --ev-maremoto-50: #e0f2fe;
        --ev-deficit-idrico: #a16207;
        --ev-deficit-idrico-50: #fefce8;
        --ev-meteo-avverso: #7c3aed;
        --ev-meteo-avverso-50: #f3e8ff;
        --ev-aib: #f97316;
        --ev-aib-50: #ffedd5;
        --ev-uomo: #334155;
        --ev-uomo-50: #e2e8f0;
        --accent-note: #2563eb;
        --accent-form: #7c3aed;
        --note-bg: color-mix(in oklab, var(--accent-note) 7%, #fff);
        --form-bg: color-mix(in oklab, var(--accent-form) 6%, #fff)
    }

    body {
        margin: 0;
        background: var(--bg);
        color: var(--txt);
        font: 14px/1.45 system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, 'Helvetica Neue', Arial
    }

    #coord-app {
        padding: 1.25rem
    }

    .coord-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.1rem 1.25rem;
        border: 1px solid var(--line);
        border-radius: 1rem;
        background: #fff;
        margin-bottom: 1rem;
        box-shadow: var(--shadow)
    }

    .title {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 800
    }

    .role {
        display: flex;
        align-items: center;
        gap: .6rem
    }

    .lbl {
        font-size: .82rem;
        color: #475569;
        display: block;
        margin-bottom: .35rem;
        font-weight: 600
    }

    .lbl--inline {
        margin: 0
    }

    .coord-root {
        display: flex;
        flex-direction: column;
        gap: 1.1rem
    }

    .input {
        height: 2.55rem;
        border: 1px solid var(--line);
        border-radius: .7rem;
        padding: .45rem .7rem;
        font-size: .94rem;
        background: #fff;
        width: 100%;
        line-height: 1.3
    }

    .input:hover {
        border-color: #cbd5e1
    }

    .input:focus {
        outline: 3px solid color-mix(in oklab, var(--accent-form) 28%, transparent);
        border-color: color-mix(in oklab, var(--accent-form) 45%, var(--line))
    }

    .input.textarea {
        min-height: 132px;
        resize: vertical;
        padding: .6rem .7rem
    }

    .field {
        margin-bottom: .9rem
    }

    .form-help {
        margin: .35rem 0 0;
        color: #b91c1c;
        font-size: .8rem
    }

    .debug {
        border: 1px dashed #f59e0b;
        background: #fffbeb;
        border-radius: .9rem;
        padding: 1rem 1.1rem;
        margin-bottom: 1rem
    }

    .debug__msg {
        display: flex;
        gap: .6rem;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: .45rem
    }

    .legend {
        display: flex;
        flex-wrap: wrap;
        gap: .6rem .85rem;
        margin: 0 0 .8rem 0;
        align-items: center
    }

    .legend__item {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        font-size: .82rem;
        color: #334155;
        border: 1px solid var(--line);
        border-radius: .8rem;
        padding: .3rem .65rem;
        background: #fff
    }

    .legend__dot {
        width: .9rem;
        height: .9rem;
        border-radius: 999px;
        display: inline-block;
        background-color: var(--ev, #64748b);
        box-shadow: 0 0 0 2px color-mix(in oklab, var(--ev, #64748b) 25%, #fff) inset
    }

    .tabbar {
        display: flex;
        gap: .5rem;
        border-bottom: 1px solid var(--line);
        padding-bottom: .5rem;
        margin-bottom: .8rem
    }

    .tab {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        border: 1px solid var(--line);
        background: #fff;
        border-radius: .7rem;
        padding: .45rem .7rem;
        cursor: pointer;
        font-size: .9rem;
        box-shadow: var(--shadow)
    }

    .tab[aria-selected="true"] {
        border-color: var(--blue);
        background: var(--blue-50)
    }

    .tab__count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 1.2rem;
        height: 1.2rem;
        padding: 0 .3rem;
        border-radius: .65rem;
        font-size: .75rem;
        background: #fff;
        border: 1px solid var(--line)
    }

    .sec {
        border: 1px solid var(--line);
        border-radius: 1rem;
        background: #fff;
        overflow: hidden;
        box-shadow: var(--shadow)
    }

    .sec__head {
        display: flex;
        align-items: center;
        gap: .7rem;
        padding: 1rem 1.1rem;
        border-bottom: 1px solid var(--line)
    }

    .sec__title {
        margin: 0;
        font-weight: 800;
        font-size: 1rem
    }

    .sec__meta {
        margin-left: auto;
        color: var(--muted);
        font-size: .84rem
    }

    .sec--queue .sec__head {
        background: var(--amber-50)
    }

    .sec--work .sec__head {
        background: var(--blue-50)
    }

    .sec--closed .sec__head {
        background: var(--slate-50)
    }

    .list {
        display: grid;
        gap: 1rem;
        padding: 1.1rem
    }

    .empty {
        padding: 1rem;
        color: var(--muted);
        font-size: .92rem
    }

    .droprow {
        display: flex;
        gap: .5rem;
        margin-left: .9rem
    }

    .drop {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        border: 2px dashed transparent;
        border-radius: .7rem;
        padding: .3rem .65rem;
        font-size: .82rem
    }

    .drop[data-target] {
        border-color: #cbd5e1;
        background: #fff
    }

    .drop.over {
        border-color: #2563eb;
        background: var(--blue-50)
    }

    .card {
        border: 1px solid var(--line);
        border-radius: 1rem;
        background: #fff;
        overflow: hidden;
        transition: transform .08s ease, box-shadow .1s ease
    }

    .card:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 22px rgba(2, 6, 23, .08)
    }

    .card__head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .7rem .9rem;
        border-bottom: 1px solid var(--line);
        background: #fafbff
    }

    .badge {
        display: inline-block;
        font-weight: 800;
        font-size: .72rem;
        padding: .22rem .55rem;
        border-radius: .5rem;
        border: 1px solid transparent
    }

    .b-queue {
        background: var(--amber-50);
        border-color: #fde68a;
        color: #7c2d12
    }

    .b-work {
        background: var(--blue-50);
        border-color: #bfdbfe;
        color: #1e3a8a
    }

    .b-closed {
        background: #eef2f7;
        border-color: #e5e7eb;
        color: #334155
    }

    .muted {
        color: var(--muted);
        font-size: .85rem
    }

    .card__body {
        padding: 1rem
    }

    .row {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem
    }

    @media(min-width:900px) {
        .row {
            grid-template-columns: 2fr 1fr
        }
    }

    .pill {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        border: 1px solid var(--line);
        border-radius: 999px;
        padding: .2rem .6rem;
        font-size: .76rem;
        background: #fff
    }

    .tag {
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        border: 1px solid var(--line);
        border-radius: .5rem;
        padding: .2rem .5rem;
        font-size: .74rem;
        background: #fff
    }

    .tip-row {
        display: flex;
        align-items: center;
        gap: .5rem;
        flex-wrap: wrap
    }

    .tip-badge.legend__item {
        padding: .22rem .55rem;
        font-size: .84rem
    }

    .instructions {
        border: 1px solid color-mix(in oklab, #dc2626 22%, var(--line));
        border-left-width: 6px;
        border-left-color: #dc2626;
        border-radius: .75rem;
        padding: .65rem .7rem;
        background: color-mix(in oklab, #dc2626 12%, #fff);
        line-height: 1.45;
        font-weight: 500
    }

    .note {
        border: 1px solid color-mix(in oklab, var(--accent-note) 20%, var(--line));
        border-left-width: 6px;
        border-left-color: var(--accent-note);
        border-radius: .75rem;
        padding: .65rem .7rem;
        background: var(--note-bg);
        line-height: 1.45
    }

    .card__footer {
        display: flex;
        align-items: center;
        gap: .45rem;
        border-top: 1px solid var(--line);
        padding: .65rem .75rem;
        background: #fff
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        border: 1px solid var(--line);
        border-radius: .65rem;
        background: #fff;
        padding: .4rem .7rem;
        font-size: .86rem;
        cursor: pointer;
        transition: background .08s ease, box-shadow .08s ease
    }

    .btn:hover {
        background: #f8fafc;
        box-shadow: 0 1px 0 rgba(2, 6, 23, .04) inset
    }

    .btn-primary {
        background: var(--blue);
        border-color: var(--blue);
        color: #fff
    }

    .btn-primary:hover {
        filter: brightness(.96)
    }

    .k-sep {
        flex: 1
    }

    .hi {
        width: 18px;
        height: 18px;
        display: inline-block;
        vertical-align: middle
    }

    .card[data-type] {
        border-left: 8px solid var(--ev, var(--line))
    }

    .card[data-type] .card__head {
        background: var(--ev-50, #fafbff)
    }

    .pager {
        display: flex;
        align-items: center;
        gap: .6rem;
        justify-content: center;
        padding: .6rem 1.1rem;
        border-top: 1px solid var(--line);
        background: #fff
    }

    .pager .btn {
        padding: .35rem .6rem
    }

    .pager__label {
        font-size: .88rem;
        color: var(--muted)
    }

    .modal {
        position: fixed;
        inset: 0;
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 50
    }

    .modal.is-open {
        display: flex
    }

    .modal__backdrop {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, .45);
        backdrop-filter: saturate(120%) blur(2px)
    }

    .modal__dialog {
        position: relative;
        width: min(900px, 92vw);
        max-height: 88vh;
        display: flex;
        flex-direction: column;
        border-radius: 1rem;
        background: #fff;
        box-shadow: var(--shadow);
        overflow: hidden
    }

    .modal__head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.1rem;
        border-bottom: 1px solid var(--line);
        background: #fafafa
    }

    .modal__head--note {
        background: var(--note-bg);
        border-bottom-color: color-mix(in oklab, var(--accent-note) 25%, var(--line))
    }

    .modal__title {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 800
    }

    .modal__x {
        border: none;
        background: transparent;
        font-size: 1.6rem;
        line-height: 1;
        cursor: pointer;
        color: #475569
    }

    .modal__body {
        padding: 1.1rem;
        overflow: auto;
        background: var(--form-bg)
    }

    .modal__foot {
        display: flex;
        gap: .6rem;
        justify-content: flex-end;
        padding: .85rem 1.1rem;
        border-top: 1px solid var(--line);
        background: #fff
    }

    /* Palette data-type */
    .card[data-type="sismico"] {
        --ev: var(--ev-sismico);
        --ev-50: var(--ev-sismico-50)
    }

    .card[data-type="vulcanico"] {
        --ev: var(--ev-vulcanico);
        --ev-50: var(--ev-vulcanico-50)
    }

    .card[data-type="idraulico"] {
        --ev: var(--ev-idraulico);
        --ev-50: var(--ev-idraulico-50)
    }

    .card[data-type="idrogeologico"] {
        --ev: var(--ev-idrogeologico);
        --ev-50: var(--ev-idrogeologico-50)
    }

    .card[data-type="maremoto"] {
        --ev: var(--ev-maremoto);
        --ev-50: var(--ev-maremoto-50)
    }

    .card[data-type="deficit-idrico"] {
        --ev: var(--ev-deficit-idrico);
        --ev-50: var(--ev-deficit-idrico-50)
    }

    .card[data-type="meteo-avverso"] {
        --ev: var(--ev-meteo-avverso);
        --ev-50: var(--ev-meteo-avverso-50)
    }

    .card[data-type="aib"] {
        --ev: var(--ev-aib);
        --ev-50: var(--ev-aib-50)
    }

    .card[data-type="uomo"] {
        --ev: var(--ev-uomo);
        --ev-50: var(--ev-uomo-50)
    }

    .card[data-type="altro"] {
        --ev: #64748b;
        --ev-50: #f1f5f9
    }
</style>


<section class="w-full h-full" id="coord-app">
    <header class="coord-head">
        <div>
            <h2 class="title">Coordinamento</h2>
        </div>
        <div class="role">
            <label class="lbl lbl--inline">Ruolo</label>
            <select id="role" class="input">
                <option>—</option>
            </select>
        </div>
    </header>

    <div id="coord-debug" class="debug" hidden>
        <div class="debug__msg">
            ⚠️ Non sto ricevendo dati dal backend.
            <button id="debug-retry" class="btn" type="button">Riprova lettura</button>
        </div>
        <div class="debug__howto">
            Verifica gli endpoint:
            <code>GET /sor/roles</code>, <code>GET /sor/segnalazioni?status=…</code>,
            <code>PATCH /sor/segnalazioni/{id}/assign</code>, <code>PATCH /sor/segnalazioni/{id}/close</code>,
            <code>POST /sor/segnalazioni/{id}/notes</code>, <code>GET /sor/logs</code>.
            <br />Il client prova anche <code>/api/sor/*</code> in fallback.
        </div>
    </div>

    <section class="legend" id="ev-legend" aria-label="Legenda eventi"></section>
    <nav class="tabbar" id="coord-tabs" role="tablist" aria-label="Stati segnalazioni"></nav>
    <div id="coord-root" class="coord-root"></div>

    <!-- LOG admin -->
    <section id="coord-log" class="sec" style="margin-top:1rem;display:none">
        <div class="sec__head">
            <svg class="hi" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3h9v3h-9zM4.5 6h15v15h-15zM9 10.5h6M9 15h6" />
            </svg>
            <h3 class="sec__title">Registro attività (Admin)</h3>
            <div class="sec__meta"><span id="log-total">0</span> eventi</div>
        </div>
        <div class="list" style="padding:0">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left">
                        <tr>
                            <th class="px-3 py-2">Data/Ora</th>
                            <th class="px-3 py-2">Azione</th>
                            <th class="px-3 py-2">Segnalazione</th>
                            <th class="px-3 py-2">Da → A</th>
                            <th class="px-3 py-2">Utente</th>
                            <th class="px-3 py-2">Nota</th>
                        </tr>
                    </thead>
                    <tbody id="log-body">
                        <tr>
                            <td colspan="6" class="px-3 py-3 opacity-70">Nessun log.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pager" data-kind="log">
            <button class="btn" id="log-prev">«</button>
            <span class="pager__label" id="log-page">Pagina 1 di 1</span>
            <button class="btn" id="log-next">»</button>
        </div>
    </section>
</section>

<!-- Modale NOTE -->
<div class="modal" id="note-modal" aria-hidden="true" aria-labelledby="note-title" role="dialog" style="display:none">
    <div class="modal__backdrop" data-close="note"></div>
    <div class="modal__dialog" role="document">
        <header class="modal__head modal__head--note">
            <h3 id="note-title" class="modal__title">Aggiungi nota</h3>
            <button class="modal__x" data-close="note" aria-label="Chiudi">&times;</button>
        </header>
        <form class="modal__body" id="note-form">
            <div class="field">
                <label class="lbl">Nota *</label>
                <textarea id="note-text" class="input textarea" placeholder="Scrivi qui…"></textarea>
                <p class="form-help" id="note-err" hidden>La nota è obbligatoria.</p>
                <input type="hidden" id="note-id">
            </div>
        </form>
        <footer class="modal__foot">
            <button class="btn" data-close="note" type="button">Annulla</button>
            <button class="btn btn-primary" id="note-save" type="button">Salva nota</button>
        </footer>
    </div>
</div>

<script type="module">
    /* ===== Helpers & Icons ===== */
    const $ = s => document.querySelector(s);
    const $$ = s => Array.from(document.querySelectorAll(s));

    function icon(name, cls = 'hi') {
        const m = {
            clock: '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            inbox: '<path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0h-3.586a1 1 0 00-.707.293l-1.414 1.414a2 2 0 01-1.414.586h-2a2 2 0 01-1.414-.586L7.293 13.293A1 1 0 006.586 13H3m17 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5"/>',
            check: '<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>',
            tag: '<path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M3 10l7.586-7.586a2 2 0 012.828 0L21 10l-7 7-8-7z"/>',
            chat: '<path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5m7 1a2 2 0 01-2 2H8l-4 4V6a2 2 0 012-2h12a2 2 0 012 2v9z"/>',
            docArrow: '<path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5V3m0 0l-3 3m3-3l3 3M6 13.5a3 3 0 013-3h6a3 3 0 013 3V18a3 3 0 01-3 3H9a3 3 0 01-3-3v-4.5z"/>',
            information: '<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25h1.5v5.25h-1.5zM12 7.5h.008v.008H12V7.5z"/>'
        };
        return `<svg class="${cls}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">${m[name]||''}</svg>`;
    }
    const PAGE_SIZE = 5;
    const TYPE_LABELS = {
        sismico: 'Sismico',
        vulcanico: 'Vulcanico',
        idraulico: 'Idraulico',
        idrogeologico: 'Idrogeologico',
        maremoto: 'Maremoto',
        'deficit-idrico': 'Deficit Idrico',
        'meteo-avverso': 'Meteo Avverso',
        aib: 'AIB',
        uomo: `Prodotti dall'uomo`,
        altro: 'Altro'
    };
    const FMT = (iso) => new Intl.DateTimeFormat('it-IT', {
        dateStyle: 'short',
        timeStyle: 'short'
    }).format(new Date(iso || Date.now()));

    /* ====== STATI (mappa UI ↔ Backend) ====== */
    const BACKEND_STATUS = {
        open: 'aperta',
        work: 'in_lavorazione',
        closed: 'chiusa'
    };

    function normStatus(s) {
        const v = (s || '').toString().toLowerCase();
        if (['queue', 'aperta', 'aperte', 'open', 'aperto'].includes(v)) return 'queue';
        if (['assigned', 'in_lavorazione', 'working', 'work', 'lavorazione'].includes(v)) return 'assigned';
        if (['closed', 'chiusa', 'chiuse', 'close', 'chiuso'].includes(v)) return 'closed';
        return 'queue';
    }

    function toBackendStatus(internal) {
        if (internal === 'queue') return BACKEND_STATUS.open;
        if (internal === 'assigned') return BACKEND_STATUS.work;
        return BACKEND_STATUS.closed;
    }

    /* ===== API con fallback /sor -> /api/sor ===== */
    const API = {
        bases: ['/sor', '/api/sor'],
        csrf() {
            return document.querySelector('meta[name="csrf-token"]')?.content || '';
        },
        async _fetch(path, opt = {}, base) {
            const url = new URL((base || this.bases[0]) + path, location.origin);
            const o = {
                method: 'GET',
                credentials: 'include',
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                ...opt
            };
            if (o.body && !(o.body instanceof FormData)) {
                o.headers['Content-Type'] = 'application/json';
                o.body = JSON.stringify(o.body);
            }
            if (o.method !== 'GET') o.headers['X-CSRF-TOKEN'] = this.csrf();
            const res = await fetch(url.toString(), o);
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            const ct = res.headers.get('content-type') || '';
            return ct.includes('application/json') ? res.json() : res;
        },
        async _req(path, opt) {
            for (const b of this.bases) {
                try {
                    return await this._fetch(path, opt, b);
                } catch {}
            }
            throw new Error('All endpoints failed');
        },
        roles() {
            return this._req('/roles');
        },
        listSegnalazioni(params) {
            const sp = new URLSearchParams(Object.entries(params || {}).filter(([, v]) => v !== undefined && v !== null && v !== ''));
            return this._req(`/segnalazioni?${sp.toString()}`);
        },
        assign(id, to, instructions) {
            return this._req(`/segnalazioni/${id}/assign`, {
                method: 'PATCH',
                body: {
                    to,
                    instructions: instructions || null
                }
            });
        },
        close(id) {
            return this._req(`/segnalazioni/${id}/close`, {
                method: 'PATCH'
            });
        },
        addNote(id, text) {
            return this._req(`/segnalazioni/${id}/notes`, {
                method: 'POST',
                body: {
                    text
                }
            });
        },
        logs(params) {
            const sp = new URLSearchParams(Object.entries(params || {}).filter(([, v]) => v != null && v !== ''));
            return this._req(`/logs?${sp.toString()}`);
        },
    };

    /* ===== State & Roles ===== */
    const ROLES_FALLBACK = [{
            slug: 'coordinamento',
            label: 'Coordinamento (Admin)',
            can_assign: true,
            can_close: true
        },
        {
            slug: 'volontariato',
            label: 'Volontariato',
            can_assign: false,
            can_close: true
        },
        {
            slug: 'mezzi',
            label: 'Mezzi e Materiali',
            can_assign: false,
            can_close: true
        },
        {
            slug: 'prociv',
            label: 'Protezione Civile',
            can_assign: false,
            can_close: true
        }
    ];
    const state = {
        roles: ROLES_FALLBACK,
        role: 'coordinamento',
        pages: {
            queue: 1,
            work: 1,
            closed: 1,
            log: 1
        },
        activeTab: 'queue',
        lists: {
            queue: [],
            work: [],
            closed: []
        },
        counts: {
            queue: 0,
            work: 0,
            closed: 0
        },
        logs: {
            data: [],
            meta: {
                current_page: 1,
                last_page: 1,
                total: 0
            }
        }
    };
    const roleSel = $('#role'),
        tabsBar = $('#coord-tabs'),
        root = $('#coord-root');
    const roleMap = () => Object.fromEntries(state.roles.map(r => [r.slug, r]));
    const canAssign = slug => !!roleMap()[slug]?.can_assign;
    const canClose = slug => !!roleMap()[slug]?.can_close;
    const labelRole = slug => roleMap()[slug]?.label || slug;
    const assignableRoles = () => state.roles.filter(r => r.slug !== 'coordinamento');

    /* ===== Legend & Tabs ===== */
    function renderLegend() {
        const mount = $('#ev-legend');
        if (!mount) return;
        const keys = ['sismico', 'vulcanico', 'idraulico', 'idrogeologico', 'maremoto', 'deficit-idrico', 'meteo-avverso', 'aib', 'uomo', 'altro'];
        mount.innerHTML = keys.map(t => `
    <span class="legend__item" data-type="${t}" style="--ev: var(--ev-${t});">
      <i class="legend__dot" aria-hidden="true"></i>${TYPE_LABELS[t]}
    </span>`).join('');
    }

    function bindTabs() {
        const c = state.counts,
            role = state.role;
        const tabs = [{
                key: 'queue',
                label: `${icon('inbox')} Aperte`,
                count: c.queue
            },
            {
                key: 'work',
                label: `${icon('clock')} In lavorazione`,
                count: c.work
            },
            {
                key: 'closed',
                label: `${icon('check')} Chiuse`,
                count: c.closed
            },
        ].filter(t => role === 'coordinamento' || t.key !== 'queue');
        tabsBar.innerHTML = tabs.map(t => `
    <button class="tab" role="tab" aria-selected="${t.key===state.activeTab}" data-tab="${t.key}">
      ${t.label} <span class="tab__count">${t.count}</span>
    </button>`).join('');
        tabsBar.querySelectorAll('.tab').forEach(btn => {
            btn.addEventListener('click', () => {
                state.activeTab = btn.dataset.tab;
                render();
            }, {
                once: true
            });
        });
    }

    /* ===== Paginazione ===== */
    function paginate(arr, key) {
        const total = Math.max(1, Math.ceil(arr.length / PAGE_SIZE));
        state.pages[key] = Math.min(Math.max(1, state.pages[key] || 1), total);
        const start = (state.pages[key] - 1) * PAGE_SIZE;
        return {
            slice: arr.slice(start, start + PAGE_SIZE),
            page: state.pages[key],
            total
        };
    }

    /* ===== Card & footer ===== */
    function card(row) {
        const g = row;
        const el = document.createElement('article');
        el.className = 'card';
        el.setAttribute('draggable', 'true');
        el.dataset.id = g.id;
        el.dataset.status = g.status;
        if (g.tipologia) el.setAttribute('data-type', g.tipologia);
        const badge = g.status === 'queue' ? 'b-queue' : g.status === 'assigned' ? 'b-work' : 'b-closed';
        const stxt = g.status === 'queue' ? 'In coda' : g.status === 'assigned' ? 'In lavorazione' : 'Chiusa';
        const areas = (g.aree || []).join(', ') || '—';
        const lastNote = g.last_note ? {
            text: g.last_note.text,
            by: g.last_note.by,
            at: g.last_note.at
        } : null;
        el.innerHTML = `
    <div class="card__head">
      <div><strong>GEN-${g.id}</strong> <span class="muted">• ${FMT(g.created_at)}</span></div>
      <div class="badge ${badge}">${stxt}</div>
    </div>
    <div class="card__body">
      <div class="row">
        <div>
          <div class="muted" style="margin-bottom:.3rem">${icon('tag','hi')} Tipologia</div>
          <div class="tip-row">
            <span class="legend__item tip-badge" style="--ev: var(--ev-${g.tipologia||'altro'});">
              <i class="legend__dot" aria-hidden="true"></i>${TYPE_LABELS[g.tipologia]||g.tipologia||'Altro'}
            </span>
            ${g.operatore?`<span class="muted">• Operatore: ${g.operatore}</span>`:''}
          </div>
          ${g.instructions?`<div class="instructions" style="margin-top:.75rem">${icon('information')} <strong>Indicazioni operative:</strong> ${g.instructions}</div>`:''}
          ${g.sintesi?`<div class="note" style="margin-top:.75rem">${icon('chat')} ${g.sintesi}</div>`:''}
          ${lastNote?`<div class="note" style="margin-top:.55rem">${icon('chat')} <strong>Ultima nota:</strong> ${lastNote.text} <span class="muted">(${lastNote.by}, ${FMT(lastNote.at)})</span></div>`:''}
        </div>
        <div>
          <div class="muted" style="margin-bottom:.3rem">${icon('information','hi')} Aree interessate</div>
          <div>${areas!=='—' ? areas.split(',').map(a=>`<span class="tag">${a.trim()}</span>`).join(' ') : '—'}</div>
        </div>
      </div>
    </div>
    <div class="card__footer" data-id="${g.id}">
      <span class="muted" style="margin-right:auto">${icon('information')} Azioni</span>
      ${footerActions(state.role, g.status, g.id, g.assigned_to)}
    </div>`;
        // DnD
        el.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('text/id', g.id);
            e.dataTransfer.setData('text/status', g.status);
        });
        return el;
    }

    function footerActions(role, status, id, assignedTo) {
        if (status === 'queue') {
            if (!canAssign(role)) return `<span class="muted">In attesa di smistamento…</span>`;
            return assignableRoles().map(rr => `
      <button class="btn" data-act="assign" data-to="${rr.slug}" data-id="${id}">${icon('docArrow')} ${rr.label}</button>
    `).join('');
        }
        if (status === 'assigned') {
            const canManage = (role === assignedTo) || canClose(role) || role === 'coordinamento';
            return `
      <button class="btn" data-act="note" data-id="${id}">📝 Nota…</button>
      <span class="k-sep"></span>
      ${canManage?`<button class="btn btn-primary" data-act="close" data-id="${id}">${icon('check')} Chiudi</button>`:''}`;
        }
        return `<button class="btn" data-act="note" data-id="${id}">📝 Aggiungi nota</button>`;
    }

    /* ===== Section & Render ===== */
    function section(title, kind, rows) {
        const {
            slice,
            page,
            total
        } = paginate(rows, kind);
        const sec = document.createElement('section');
        sec.className = `sec sec--${kind}`;
        const dropRow = (canAssign(state.role) && kind === 'queue') ?
            `<div class="droprow">${assignableRoles().map(rr=>`<span class="drop" data-target="${rr.slug}">${icon('docArrow')} ${rr.label}</span>`).join('')}</div>` :
            (kind === 'work' && canClose(state.role) ? `<div class="droprow"><span class="drop" data-target="close">${icon('check')} Chiudi</span></div>` : '');
        sec.innerHTML = `
    <div class="sec__head">
      ${kind==='queue'?icon('inbox'):kind==='work'?icon('clock'):icon('check')}
      <h3 class="sec__title">${title}</h3>
      ${dropRow}
      <div class="sec__meta">${rows.length} elementi totali</div>
    </div>
    <div class="list" data-kind="${kind}">
      ${slice.length ? '' : `<div class="empty">Nessuna voce.</div>`}
    </div>
    <div class="pager" data-kind="${kind}">
      <button class="btn" data-pg="prev" ${page<=1?'disabled':''}>«</button>
      <span class="pager__label">Pagina ${page} di ${total}</span>
      <button class="btn" data-pg="next" ${page>=total?'disabled':''}>»</button>
    </div>`;
        const list = sec.querySelector('.list');
        slice.forEach(r => list.appendChild(card(r)));
        // drop targets
        sec.querySelectorAll('.drop[data-target]').forEach(t => {
            t.addEventListener('dragover', e => {
                e.preventDefault();
                t.classList.add('over');
            });
            t.addEventListener('dragleave', () => t.classList.remove('over'));
            t.addEventListener('drop', async e => {
                e.preventDefault();
                t.classList.remove('over');
                const id = e.dataTransfer.getData('text/id');
                const src = e.dataTransfer.getData('text/status');
                await handleDropAction(id, src, t.dataset.target);
            });
        });
        return sec;
    }

    function bindPaging() {
        root.querySelectorAll('.pager').forEach(pg => {
            const kind = pg.dataset.kind;
            pg.querySelectorAll('[data-pg]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const dir = btn.dataset.pg;
                    const total = Number(pg.querySelector('.pager__label')?.textContent.match(/di\s+(\d+)/)?.[1] || 1);
                    if (dir === 'prev') state.pages[kind] = Math.max(1, (state.pages[kind] || 1) - 1);
                    if (dir === 'next') state.pages[kind] = Math.min(total, (state.pages[kind] || 1) + 1);
                    render();
                });
            });
        });
    }

    function render() {
        renderLegend();
        state.counts = {
            queue: state.lists.queue.length,
            work: state.lists.work.length,
            closed: state.lists.closed.length
        };
        bindTabs();
        root.replaceChildren();
        const effTab = (state.role !== 'coordinamento' && state.activeTab === 'queue') ? 'work' : state.activeTab;
        if (effTab === 'queue') root.appendChild(section('Aperte', 'queue', state.lists.queue));
        if (effTab === 'work') root.appendChild(section('In lavorazione', 'work', state.lists.work));
        if (effTab === 'closed') root.appendChild(section('Chiuse', 'closed', state.lists.closed));
        bindHandlers();
        bindPaging();
        $('#coord-log').style.display = (state.role === 'coordinamento') ? '' : 'none';
    }

    /* ===== Handlers ===== */
    function toastOK(t, txt = '') {
        if (window.Swal) Swal.fire({
            title: t,
            text: txt,
            icon: 'success',
            toast: true,
            timer: 1500,
            showConfirmButton: false,
            position: 'top-end'
        });
    }

    function toastInfo(t, txt = '') {
        if (window.Swal) Swal.fire({
            title: t,
            text: txt,
            icon: 'info',
            toast: true,
            timer: 1500,
            showConfirmButton: false,
            position: 'top-end'
        });
    }

    function askConfirm(title, text) {
        return window.Swal ? Swal.fire({
            title,
            text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Conferma',
            cancelButtonText: 'Annulla',
            confirmButtonColor: '#2563eb'
        }) : Promise.resolve({
            isConfirmed: confirm(title)
        });
    }

    async function promptInstructions() {
        if (!window.Swal) return {
            confirmed: true,
            text: ''
        };
        const {
            value: isText,
            isConfirmed
        } = await Swal.fire({
            title: 'Indicazioni operative (facoltative)',
            input: 'textarea',
            inputLabel: 'Puoi lasciare vuoto',
            inputPlaceholder: 'Es. priorità, azioni… (facoltativo)',
            showCancelButton: true,
            confirmButtonText: 'Conferma',
            cancelButtonText: 'Annulla',
            confirmButtonColor: '#2563eb'
        });
        return {
            confirmed: isConfirmed,
            text: (isText ?? '').trim()
        };
    }
    async function handleDropAction(id, srcStatus, target) {
        try {
            if (srcStatus === 'queue' && assignableRoles().some(r => r.slug === target)) {
                const {
                    confirmed,
                    text
                } = await promptInstructions();
                if (!confirmed) return;
                // persist
                await API.assign(id, target, text || null);
                // aggiorna liste in memoria (sparisce da aperte, compare in lavorazione)
                moveInState(+id, 'queue', 'work');
                toastOK('Segnalazione smistata', `Assegnata a ${labelRole(target)}`);
                await reloadData('work');
                return;
            }
            if (srcStatus === 'assigned' && target === 'close' && canClose(state.role)) {
                await API.close(id);
                moveInState(+id, 'work', 'closed');
                toastOK('Segnalazione chiusa');
                await reloadData('closed');
                return;
            }
            toastInfo('Operazione non permessa');
        } catch (e) {
            console.error(e);
            toastInfo('Errore backend');
        }
    }

    function bindHandlers() {
        root.querySelectorAll('[data-act="assign"]').forEach(b => {
            b.addEventListener('click', async () => {
                const id = +b.dataset.id,
                    to = b.dataset.to;
                const {
                    confirmed,
                    text
                } = await promptInstructions();
                if (!confirmed) return;
                await API.assign(id, to, text || null);
                moveInState(id, 'queue', 'work');
                toastOK('Segnalazione smistata', `Assegnata a ${labelRole(to)}`);
                await reloadData('work');
            });
        });
        root.querySelectorAll('[data-act="note"]').forEach(b => b.addEventListener('click', () => NoteModal.open(b.dataset.id)));
        root.querySelectorAll('[data-act="close"]').forEach(b => {
            b.addEventListener('click', async () => {
                const id = +b.dataset.id;
                const c = await askConfirm('Chiudere la segnalazione?', 'Potrai comunque aggiungere note.');
                if (!c.isConfirmed) return;
                await API.close(id);
                moveInState(id, 'work', 'closed');
                toastOK('Segnalazione chiusa');
                await reloadData('closed');
            });
        });
    }

    /* ===== Move helpers (liste + DOM) ===== */
    function listEl(kind) {
        return document.querySelector(`.sec--${kind} .list`);
    }

    function moveCardDOM(id, toKind) {
        const card = document.querySelector(`.card[data-id="${CSS.escape(String(id))}"]`);
        if (!card) return;
        const dest = listEl(toKind);
        card.dataset.status = (toKind === 'work' ? 'assigned' : toKind);
        if (dest) dest.prepend(card);
    }

    function moveInState(id, fromKind, toKind) {
        // aggiorna state.lists
        const pull = arr => {
            const i = arr.findIndex(x => Number(x.id) === Number(id));
            if (i >= 0) return arr.splice(i, 1)[0];
            return null;
        };
        let row = null;
        if (fromKind === 'queue') row = pull(state.lists.queue);
        if (fromKind === 'work') row = pull(state.lists.work);
        if (fromKind === 'closed') row = pull(state.lists.closed);
        if (row) {
            row.status = (toKind === 'work' ? 'assigned' : toKind === 'queue' ? 'queue' : 'closed');
            if (toKind === 'queue') state.lists.queue.unshift(row);
            if (toKind === 'work') state.lists.work.unshift(row);
            if (toKind === 'closed') state.lists.closed.unshift(row);
            moveCardDOM(id, toKind);
            render(); // ricalcola pagine/contatori
        }
    }

    /* ===== Modal NOTE ===== */
    const NoteModal = {
        el: $('#note-modal'),
        open(id) {
            $('#note-id').value = id;
            $('#note-text').value = '';
            $('#note-err').hidden = true;
            $('#note-title').textContent = 'Aggiungi nota';
            this.el.classList.add('is-open');
            setTimeout(() => $('#note-text').focus(), 30);
        },
        close() {
            this.el.classList.remove('is-open');
        }
    };
    document.querySelectorAll('[data-close="note"]').forEach(n => n.addEventListener('click', () => NoteModal.close()));
    $('#note-save').addEventListener('click', async () => {
        const id = $('#note-id').value;
        const text = $('#note-text').value.trim();
        $('#note-err').hidden = !!text;
        if (!text) {
            $('#note-text').focus();
            return;
        }
        await API.addNote(id, text);
        NoteModal.close();
        toastInfo('Nota aggiunta');
        await reloadData(state.activeTab === 'closed' ? 'closed' : 'work');
    });

    /* ===== Data load/map ===== */
    function mapSeg(s) {
        return {
            id: s.id,
            created_at: s.creata_il || s.created_at,
            tipologia: s.tipologia || 'altro',
            aree: s.aree || [],
            sintesi: s.sintesi || '',
            operatore: s.operatore || '',
            status: normStatus(s.status),
            assigned_to: s.assigned_to || null,
            instructions: s.instructions || null,
            last_note: s.last_note || null
        };
    }
    async function loadRoles() {
        try {
            const r = await API.roles();
            if (Array.isArray(r) && r.length) state.roles = r;
        } catch {}
        roleSel.innerHTML = state.roles.map(r => `<option value="${r.slug}">${r.label}</option>`).join('');
        if (!state.roles.some(r => r.slug === state.role)) state.role = state.roles[0]?.slug || 'coordinamento';
        roleSel.value = state.role;
        roleSel.addEventListener('change', async () => {
            state.role = roleSel.value;
            if (state.role !== 'coordinamento' && state.activeTab === 'queue') state.activeTab = 'work';
            await loadData();
            render();
            if (state.role === 'coordinamento') {
                $('#coord-log').style.display = '';
                await loadLogs();
            } else $('#coord-log').style.display = 'none';
        });
    }
    async function loadList(kind) {
        const params = {
            page: 1,
            per_page: 200
        };
        if (kind === 'queue') {
            params.status = toBackendStatus('queue');
        }
        if (kind === 'work') {
            params.status = toBackendStatus('assigned');
            if (state.role !== 'coordinamento') params.assigned_to = state.role;
        }
        if (kind === 'closed') {
            params.status = toBackendStatus('closed');
            if (state.role !== 'coordinamento') params.assigned_to = state.role;
        }
        const res = await API.listSegnalazioni(params);
        const rows = Array.isArray(res) ? res : (res.data || []);
        return rows.map(mapSeg);
    }
    async function loadData() {
        try {
            $('#coord-debug').hidden = true;
            const [q, w, c] = await Promise.all([loadList('queue'), loadList('work'), loadList('closed')]);
            state.lists.queue = q;
            state.lists.work = w;
            state.lists.closed = c;
        } catch (e) {
            console.error(e);
            $('#coord-debug').hidden = false;
            state.lists = {
                queue: [],
                work: [],
                closed: []
            };
        }
    }
    async function reloadData(which) {
        try {
            if (which === 'queue') state.lists.queue = await loadList('queue');
            if (which === 'work') state.lists.work = await loadList('work');
            if (which === 'closed') state.lists.closed = await loadList('closed');
            render();
        } catch (e) {
            console.error(e);
        }
    }

    /* ===== Logs ===== */
    function renderLogs() {
        const tbody = $('#log-body');
        const meta = state.logs.meta || {};
        $('#log-total').textContent = meta.total ?? state.logs.data.length;
        $('#log-page').textContent = `Pagina ${meta.current_page??1} di ${meta.last_page??1}`;
        $('#log-prev').disabled = (meta.current_page ?? 1) <= 1;
        $('#log-next').disabled = (meta.current_page ?? 1) >= (meta.last_page ?? 1);
        tbody.replaceChildren();
        const rows = state.logs.data;
        if (!rows.length) {
            const tr = document.createElement('tr');
            tr.innerHTML = `<td colspan="6" class="px-3 py-3 opacity-70">Nessun log.</td>`;
            tbody.appendChild(tr);
            return;
        }
        rows.forEach(l => {
            const tr = document.createElement('tr');
            tr.className = 'border-t';
            const when = FMT(l.created_at || l.at);
            const action = l.action || l.type || '—';
            const seg = l.segnalazione_id ? `GEN-${l.segnalazione_id}` : '—';
            const daA = `${l.from_status||l.from||'—'} → ${l.to_status||l.to||'—'}` + (l.from_assignee || l.to_assignee ? ` • ${l.from_assignee||'—'} → ${l.to_assignee||'—'}` : '');
            const by = l.by || l.user || '—';
            const nota = l.note || l.details || '';
            tr.innerHTML = `
      <td class="px-3 py-2">${when}</td>
      <td class="px-3 py-2">${action}</td>
      <td class="px-3 py-2">${seg}</td>
      <td class="px-3 py-2">${daA}</td>
      <td class="px-3 py-2">${by}</td>
      <td class="px-3 py-2">${nota}</td>`;
            tbody.appendChild(tr);
        });
    }
    async function loadLogs() {
        try {
            const res = await API.logs({
                entity: 'segnalazione',
                page: state.pages.log,
                per_page: 10
            });
            const data = Array.isArray(res) ? res : (res.data || []);
            state.logs.data = data;
            state.logs.meta = res.meta || {
                current_page: 1,
                last_page: 1,
                total: data.length
            };
            renderLogs();
        } catch (e) {
            console.error('logs', e);
            state.logs = {
                data: [],
                meta: {
                    current_page: 1,
                    last_page: 1,
                    total: 0
                }
            };
            renderLogs();
        }
    }
    $('#log-prev')?.addEventListener('click', async () => {
        state.pages.log = Math.max(1, (state.pages.log || 1) - 1);
        await loadLogs();
    });
    $('#log-next')?.addEventListener('click', async () => {
        state.pages.log = (state.pages.log || 1) + 1;
        await loadLogs();
    });

    /* ===== Boot ===== */
    async function boot() {
        renderLegend();
        await loadRoles();
        await loadData();
        render();
        if (state.role === 'coordinamento') {
            $('#coord-log').style.display = '';
            await loadLogs();
        }
    }
    $('#debug-retry').addEventListener('click', boot);
    boot();
</script>