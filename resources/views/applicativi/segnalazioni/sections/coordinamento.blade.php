<section class="w-full h-full" id="coord-app">
    <header class="coord-head">
        <div>
            <h2 class="title">Coordinamento</h2>
        </div>
        <div class="role">
            <label class="lbl lbl--inline">Ruolo</label>
            <select id="role" class="input">
                <option value="coordinamento">Coordinamento (Admin)</option>
                <option value="volontariato">Volontariato</option>
                <option value="mezzi">Mezzi e Materiali</option>
                <option value="prociv">Protezione Civile</option>
            </select>
        </div>
    </header>

    {{-- Barra debug: stato bridge + dati demo --}}
    <div id="coord-debug" class="debug" hidden>
        <div class="debug__msg">
            ⚠️ Non sto ricevendo dati dalla dashboard.
            <button id="debug-load" class="btn btn-primary" type="button">Carica dati demo</button>
            <button id="debug-retry" class="btn" type="button">Riprova lettura</button>
        </div>
        <div class="debug__howto">
            Suggerimento: includi in dashboard un bridge che risponde a <code>SOR_DASH_REQUEST</code>
            e/o scrivi <code>localStorage["sor-dash-v18-ux-pill-openfilter"]</code> con <code>{gen, ongoing}</code>.
        </div>
    </div>

    {{-- Legenda eventi (come dashboard) --}}
    <section class="legend" id="ev-legend" aria-label="Legenda eventi"></section>

    {{-- TABBAR --}}
    <nav class="tabbar" id="coord-tabs" role="tablist" aria-label="Stati segnalazioni">
        <!-- ricostruita dinamicamente in bindTabs() per nascondere "Aperte" ai non-coord -->
    </nav>

    <div id="coord-root" class="coord-root"></div>
</section>

<!-- ===== Modali ===== -->
<div class="modal" id="note-modal" aria-hidden="true" aria-labelledby="note-title" role="dialog">
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

<div class="modal" id="team-modal" aria-hidden="true" aria-labelledby="team-title" role="dialog">
    <div class="modal__backdrop" data-close="team"></div>
    <div class="modal__dialog" role="document">
        <header class="modal__head modal__head--team">
            <h3 id="team-title" class="modal__title">Crea squadra</h3>
            <button class="modal__x" data-close="team" aria-label="Chiudi">&times;</button>
        </header>

        <form class="modal__body" id="team-form" novalidate>
            <input type="hidden" id="team-id">
            <input type="hidden" id="team-index">

            <div class="grid grid-2">
                <div class="field">
                    <label class="lbl">Nome squadra *</label>
                    <input id="t-name" class="input" placeholder="Es. Alfa 1">
                    <p class="form-help" id="err-t-name" hidden>Il nome squadra è obbligatorio.</p>
                </div>
                <div class="field">
                    <label class="lbl">Caposquadra *</label>
                    <input id="t-lead" class="input" placeholder="Nome e cognome">
                    <p class="form-help" id="err-t-lead" hidden>Il caposquadra è obbligatorio.</p>
                </div>
            </div>

            <div class="grid grid-2">
                <div class="field">
                    <label class="lbl">Contatto</label>
                    <input id="t-contact" class="input" placeholder="Tel / Email">
                </div>
                <div class="field">
                    <label class="lbl">Mezzo/risorsa</label>
                    <input id="t-asset" class="input" placeholder="Pick-up, AIB, Ambulanza…">
                </div>
            </div>

            <div class="grid grid-2">
                <div class="field">
                    <label class="lbl">Zona/area</label>
                    <input id="t-area" class="input" placeholder="Comune/Zona operativa">
                </div>
                <div class="grid grid-2 inner">
                    <div class="field">
                        <label class="lbl">Inizio</label>
                        <input id="t-start" class="input" type="datetime-local">
                    </div>
                    <div class="field">
                        <label class="lbl">Fine</label>
                        <input id="t-end" class="input" type="datetime-local">
                        <p class="form-help" id="err-t-range" hidden>La fine deve essere successiva all'inizio.</p>
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="lbl">Componenti (separati da virgola)</label>
                <input id="t-members" class="input" placeholder="Mario, Luca, Sara…">
            </div>
            <div class="field">
                <label class="lbl">Note operative</label>
                <textarea id="t-notes" class="input textarea" placeholder="Indicazioni, priorità, DPI…"></textarea>
            </div>
        </form>

        <footer class="modal__foot">
            <button class="btn" data-close="team" type="button">Annulla</button>
            <button class="btn btn-primary" id="team-save" type="button">Salva</button>
        </footer>
    </div>
</div>

<style>
    :root {
        --line: #e2e8f0;
        --bg: #f7f9fc;
        --card: #fff;
        --muted: #64748b;
        --txt: #0f172a;
        --blue: #2563eb;
        --blue-50: #eff6ff;
        --green: #16a34a;
        --green-50: #ecfdf5;
        --amber: #d97706;
        --amber-50: #fffbeb;
        --slate: #334155;
        --slate-50: #f1f5f9;
        --shadow: 0 12px 34px rgba(2, 6, 23, .10), 0 1px 3px rgba(2, 6, 23, .06);

        /* palette dashboard */
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
        --accent-team: #16a34a;
        --accent-form: #7c3aed;
        --note-bg: color-mix(in oklab, var(--accent-note) 7%, #fff);
        --team-bg: color-mix(in oklab, var(--accent-team) 6%, #fff);
        --form-bg: color-mix(in oklab, var(--accent-form) 6%, #fff);
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
        font-weight: 800;
        color: var(--txt)
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

    /* legenda */
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

    /* TABBAR */
    .tabbar {
        display: flex;
        gap: .5rem;
        border-bottom: 1px solid var(--line);
        padding-bottom: .5rem;
        margin-bottom: .8rem
    }

    .tab {
        position: relative;
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

    /* sezioni */
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

    .sec__tools {
        display: flex;
        gap: .45rem;
        margin-left: .8rem
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

    /* drop targets */
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

    /* card & bits */
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

    /* badge tipologia (riuso stile legenda) */
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

    /* INDICAZIONI: sfondo ROSSO */
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

    .instructions strong {
        font-weight: 800
    }

    /* note/squadre accenti */
    .note {
        border: 1px solid color-mix(in oklab, var(--accent-note) 20%, var(--line));
        border-left-width: 6px;
        border-left-color: var(--accent-note);
        border-radius: .75rem;
        padding: .65rem .7rem;
        background: var(--note-bg);
        line-height: 1.45
    }

    .teams {
        margin-top: .9rem;
        border-top: 1px dashed var(--line);
        padding-top: .7rem
    }

    .teams h4 {
        margin: 0 0 .5rem 0;
        font-size: .95rem;
        display: flex;
        align-items: center;
        gap: .5rem;
        color: var(--accent-team)
    }

    .team {
        border: 1px solid color-mix(in oklab, var(--accent-team) 18%, var(--line));
        border-left: 6px solid var(--accent-team);
        border-radius: .8rem;
        padding: .6rem .7rem;
        margin-bottom: .6rem;
        background: var(--team-bg)
    }

    .team__meta {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem;
        margin: .4rem 0
    }

    .chip {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        border: 1px solid var(--line);
        border-radius: 999px;
        padding: .18rem .55rem;
        font-size: .74rem;
        background: #fff
    }

    .team__tools {
        display: flex;
        gap: .4rem;
        margin-left: auto
    }

    .tbtn {
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        border: 1px solid var(--line);
        border-radius: .5rem;
        background: #fff;
        padding: .22rem .5rem;
        font-size: .78rem;
        cursor: pointer
    }

    .tbtn:hover {
        background: #f8fafc
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

    /* card colori per tipo */
    .card[data-type] {
        border-left: 8px solid var(--ev, var(--line))
    }

    .card[data-type] .card__head {
        background: var(--ev-50, #fafbff)
    }

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

    /* modali */
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

    .modal__head--team {
        background: var(--team-bg);
        border-bottom-color: color-mix(in oklab, var(--accent-team) 25%, var(--line))
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
</style>

<script type="module">
    /* ====== Helpers / state ====== */
    const $ = s => document.querySelector(s);
    const root = $('#coord-root');
    const roleSel = $('#role');
    const tabsBar = $('#coord-tabs');

    const DASH_KEYS = ['sor-dash-v18-ux-pill-openfilter', 'dashboard_state', 'sor-dashboard', 'sor:state'];
    const META_KEY = 'sor-coord-meta-v10';
    const PAGES_KEY = 'sor-coord-pages-v2';
    const ROLE_KEY = 'sor-role';
    const TAB_KEY = 'sor-coord-tab';
    const PAGE_SIZE = 5;

    let ACTIVE_TAB = localStorage.getItem(TAB_KEY) || 'queue'; // queue | work | closed

    const FMT = (iso) => new Intl.DateTimeFormat('it-IT', {
        dateStyle: 'short',
        timeStyle: 'short'
    }).format(new Date(iso || Date.now()));

    const TYPES = ["sismico", "vulcanico", "idraulico", "idrogeologico", "maremoto", "deficit-idrico", "meteo-avverso", "aib", "uomo", "altro"];
    const TYPE_LABELS = {
        sismico: "Sismico",
        vulcanico: "Vulcanico",
        idraulico: "Idraulico",
        idrogeologico: "Idrogeologico",
        maremoto: "Maremoto",
        "deficit-idrico": "Deficit Idrico",
        "meteo-avverso": "Meteo Avverso",
        aib: "AIB",
        uomo: "Prodotti dall'uomo",
        altro: "Altro"
    };

    function icon(name, cls = 'hi') {
        const m = {
            clock: '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            inbox: '<path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0h-3.586a1 1 0 00-.707.293l-1.414 1.414a2 2 0 01-1.414.586h-2a2 2 0 01-1.414-.586L7.293 13.293A1 1 0 006.586 13H3m17 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5"/>',
            check: '<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>',
            users: '<path stroke-linecap="round" stroke-linejoin="round" d="M18 20a4 4 0 00-4-4H6a4 4 0 00-4 4m16-8a4 4 0 10-8 0 4 4 0 008 0z"/>',
            tag: '<path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M3 10l7.586-7.586a2 2 0 012.828 0L21 10l-7 7-8-7z"/>',
            chat: '<path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5m7 1a2 2 0 01-2 2H8l-4 4V6a2 2 0 012-2h12a2 2 0 012 2v9z"/>',
            paperAir: '<path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>',
            mapPin: '<path stroke-linecap="round" stroke-linejoin="round" d="M12 11a3 3 0 100-6 3 3 0 000 6z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.5-7.5 10.5-7.5 10.5S4.5 18 4.5 10.5a7.5 7.5 0 1115 0z"/>',
            docArrow: '<path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5V3m0 0l-3 3m3-3l3 3M6 13.5a3 3 0 013-3h6a3 3 0 013 3V18a3 3 0 01-3 3H9a3 3 0 01-3-3v-4.5z"/>',
            user: '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20.25a7.5 7.5 0 0115 0"/>',
            information: '<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25h1.5v5.25h-1.5zM12 7.5h.008v.008H12V7.5z"/>',
            pencil: '<path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487l3.651 3.65M4.5 19.5l4.5-1.125 9.712-9.712a2.58 2.58 0 000-3.651L16.863 3.49a2.58 2.58 0 00-3.651 0L3.5 13.2 2.25 18.75 7.8 17.5z"/>',
            trash: '<path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21a48.108 48.108 0 00-14.456 0M4.5 5.79L5.17 19.5A2.25 2.25 0 007.415 21h9.17A2.25 2.25 0 0018.83 19.5L19.5 5.79M9 5.25V4.5A1.5 1.5 0 0110.5 3h3A1.5 1.5 0 0115 4.5v.75"/>',
            download: '<path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M7.5 12 12 16.5 16.5 12M12 3v13.5"/>'
        };
        return `<svg class="${cls}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">${m[name]||''}</svg>`;
    }

    /* ====== Bridge Dashboard ====== */
    const MSG_TIMEOUT = 1500;
    let MSG_SNAPSHOT = null;

    function requestSnapshotFromOtherWindow() {
        return new Promise((resolve) => {
            const handler = (ev) => {
                if (ev?.data?.type === 'SOR_DASH_SNAPSHOT' && ev.data.payload) {
                    MSG_SNAPSHOT = ev.data.payload;
                    window.removeEventListener('message', handler);
                    resolve(true);
                }
            };
            window.addEventListener('message', handler);
            window.postMessage({
                type: 'SOR_DASH_REQUEST'
            }, '*');
            setTimeout(() => {
                window.removeEventListener('message', handler);
                resolve(false);
            }, MSG_TIMEOUT);
        });
    }

    function pickDashRaw() {
        if (window.SOR?.getState) return window.SOR.getState();
        if (MSG_SNAPSHOT) return MSG_SNAPSHOT;
        for (const k of DASH_KEYS) {
            const raw = localStorage.getItem(k);
            if (raw) {
                try {
                    return JSON.parse(raw);
                } catch {}
            }
        }
        if (window.__DASH__) return window.__DASH__;
        return null;
    }

    function normalizeDash(d) {
        if (!d) return {
            gen: [],
            ongoing: []
        };
        const gen = Array.isArray(d.gen) ? d.gen : (Array.isArray(d.items) ? d.items : []);
        const ongoing = Array.isArray(d.ongoing) ? d.ongoing : (Array.isArray(d.events) ? d.events : []);
        return {
            gen,
            ongoing
        };
    }

    function renderLegend() {
        const mount = document.getElementById('ev-legend');
        if (!mount) return;
        mount.innerHTML = TYPES.map(t => `
            <span class="legend__item" data-type="${t}" style="--ev: var(--ev-${t});">
              <i class="legend__dot" aria-hidden="true"></i>${TYPE_LABELS[t]}
            </span>
        `).join('');
    }

    /* ====== Stato locale ====== */
    const meta = load(META_KEY, {});
    const pages = load(PAGES_KEY, {
        queue: 1,
        work: 1,
        closed: 1
    });
    roleSel.value = localStorage.getItem(ROLE_KEY) || 'coordinamento';
    roleSel.addEventListener('change', () => {
        localStorage.setItem(ROLE_KEY, roleSel.value);
        render();
    });

    function load(key, fb) {
        try {
            return JSON.parse(localStorage.getItem(key) || JSON.stringify(fb));
        } catch {
            return fb;
        }
    }

    function save(key, obj) {
        localStorage.setItem(key, JSON.stringify(obj));
    }

    function hydrate(gen) {
        gen.forEach(g => {
            if (!meta[g.id]) {
                meta[g.id] = {
                    status: 'queue',
                    assigned_to: null,
                    assign_instructions: null,
                    opened_by: g.operatore || 'Operatore',
                    routed_by: null,
                    closed_by: null,
                    notes: [],
                    event_id: g.event_id || null,
                    teams: []
                };
            } else {
                if (g.event_id) meta[g.id].event_id = g.event_id;
                if (!Array.isArray(meta[g.id].teams)) meta[g.id].teams = [];
            }
        });
        save(META_KEY, meta);
    }

    /* ====== Toast/confirm ====== */
    function toastOK(title, text = '') {
        Swal.fire({
            title,
            text,
            icon: 'success',
            toast: true,
            timer: 1500,
            showConfirmButton: false,
            position: 'top-end'
        });
    }

    function toastInfo(title, text = '') {
        Swal.fire({
            title,
            text,
            icon: 'info',
            toast: true,
            timer: 1500,
            showConfirmButton: false,
            position: 'top-end'
        });
    }

    function askConfirm(title, text) {
        return Swal.fire({
            title,
            text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Conferma',
            cancelButtonText: 'Annulla',
            confirmButtonColor: '#2563eb'
        });
    }

    // Prompt indicazioni operative obbligatorie
    async function promptInstructions() {
        const {
            value: text,
            isConfirmed
        } = await Swal.fire({
            title: 'Indicazioni operative',
            input: 'textarea',
            inputLabel: 'Specificare istruzioni per la squadra/ruolo (obbligatorio)',
            inputPlaceholder: 'Es. Raggiungere area X da Nord, verificare criticità Y, priorità Z…',
            inputAttributes: {
                'aria-label': 'Indicazioni operative'
            },
            inputValidator: (v) => !v?.trim() ? 'Le indicazioni operative sono obbligatorie' : undefined,
            showCancelButton: true,
            confirmButtonText: 'Conferma',
            cancelButtonText: 'Annulla',
            confirmButtonColor: '#2563eb'
        });
        return isConfirmed ? text.trim() : null;
    }

    /* ====== Data shaping ====== */
    function computeLists(role, gen) {
        const rows = gen.map(g => ({
            rec: g,
            meta: meta[g.id]
        }));
        const byDateDesc = (a, b) => new Date(b.rec.created_at) - new Date(a.rec.created_at);
        if (role === 'coordinamento') {
            return {
                queue: rows.filter(r => r.meta?.status === 'queue').sort(byDateDesc),
                work: rows.filter(r => r.meta?.status === 'assigned').sort(byDateDesc),
                closed: rows.filter(r => r.meta?.status === 'closed').sort(byDateDesc)
            };
        }
        const mine = rows.filter(r => r.meta?.assigned_to === role);
        return {
            work: mine.filter(r => r.meta?.status === 'assigned').sort(byDateDesc),
            closed: mine.filter(r => r.meta?.status === 'closed').sort(byDateDesc),
            queue: []
        };
    }

    /* ====== Export ====== */
    function serializeNotes(meta) {
        if (!meta?.notes?.length) return '';
        return meta.notes.map(n => `- ${FMT(n.at)} (${n.by}): ${n.text}`).join('\n');
    }

    function serializeTeams(meta) {
        if (!meta?.teams?.length) return '';
        return meta.teams.map(t => {
            const members = (t.members || []).join(', ');
            const parts = [
                `• Nome: ${t.name||''}`,
                `  Caposquadra: ${t.lead||''}`,
                t.contact ? `  Contatto: ${t.contact}` : '',
                t.asset ? `  Mezzo/Risorsa: ${t.asset}` : '',
                t.area ? `  Area: ${t.area}` : '',
                (t.start || t.end) ? `  Orario: ${t.start?FMT(t.start):''}${t.end?` → ${FMT(t.end)}`:''}` : '',
                members ? `  Volontari: ${members}` : '',
                t.notes ? `  Note: ${t.notes}` : ''
            ].filter(Boolean).join('\n');
            return parts;
        }).join('\n\n');
    }

    function mapRowsForExport(kind, rows, snap) {
        return rows.map(({
            rec,
            meta
        }) => {
            const areas = (rec.aree || []).join(', ');
            const tipo = findEventTypeFor(rec, snap) || rec.tipologia || 'altro';
            const base = {
                ID: `GEN-${rec.id}`,
                DataApertura: FMT(rec.created_at),
                Tipologia: tipo,
                Stato: meta.status,
                AssegnatoA: meta.assigned_to || '',
                EventoID: rec.event_id || '',
                Aree: areas,
            };
            if (kind === 'work') {
                return {
                    ...base,
                    'Indicazioni operative': meta.assign_instructions || '',
                    'Ultima sintesi': rec.sintesi || '',
                    'Note (cronologia)': serializeNotes(meta),
                    'Squadre (dettaglio)': serializeTeams(meta)
                };
            }
            return {
                ...base,
                'Ultima sintesi': rec.sintesi || '',
                'Ultima nota': meta.notes?.[0] ? `${FMT(meta.notes[0].at)} (${meta.notes[0].by}): ${meta.notes[0].text}` : ''
            };
        });
    }

    function exportSectionToExcel(kind, rows, snap, role) {
        const data = mapRowsForExport(kind, rows, snap);
        const ws = XLSX.utils.json_to_sheet(data);
        const range = XLSX.utils.decode_range(ws['!ref']);
        for (let R = range.s.r; R <= range.e.r; ++R) {
            for (let C = range.s.c; C <= range.e.c; ++C) {
                const addr = XLSX.utils.encode_cell({
                    r: R,
                    c: C
                });
                if (ws[addr] && typeof ws[addr].v === 'string' && ws[addr].v.includes('\n')) {
                    ws[addr].t = 's';
                }
            }
        }
        const wb = XLSX.utils.book_new();
        const sheetName = kind === 'work' ? 'SMISTATE' : kind.toUpperCase();
        XLSX.utils.book_append_sheet(wb, ws, sheetName);
        const roletag = role === 'coordinamento' ? 'coord' : role;
        XLSX.writeFile(wb, `segnalazioni_${roletag}_${kind}.xlsx`);
    }

    /* ====== Pagination ====== */
    function paginate(arr, key) {
        const total = Math.max(1, Math.ceil(arr.length / PAGE_SIZE));
        pages[key] = Math.min(Math.max(1, pages[key] || 1), total);
        const start = (pages[key] - 1) * PAGE_SIZE;
        return {
            slice: arr.slice(start, start + PAGE_SIZE),
            page: pages[key],
            total
        };
    }

    /* ====== Tabs ====== */
    function bindTabs(counts) {
        const role = roleSel.value;
        const tabs = [{
                key: 'queue',
                label: `${icon('inbox')} Aperte`,
                count: counts.queue
            },
            {
                key: 'work',
                label: `${icon('clock')} In lavorazione`,
                count: counts.work
            },
            {
                key: 'closed',
                label: `${icon('check')} Chiuse`,
                count: counts.closed
            },
        ].filter(t => role === 'coordinamento' || t.key !== 'queue');

        tabsBar.innerHTML = tabs.map(t => `
          <button class="tab" role="tab" aria-selected="${t.key===ACTIVE_TAB}" data-tab="${t.key}">
            ${t.label} <span class="tab__count">${t.count}</span>
          </button>
        `).join('');

        if (role !== 'coordinamento' && ACTIVE_TAB === 'queue') {
            ACTIVE_TAB = 'work';
            localStorage.setItem(TAB_KEY, ACTIVE_TAB);
        }

        tabsBar.querySelectorAll('.tab').forEach(btn => {
            btn.addEventListener('click', () => {
                ACTIVE_TAB = btn.dataset.tab;
                localStorage.setItem(TAB_KEY, ACTIVE_TAB);
                render();
            }, {
                once: true
            });
        });
    }

    /* ====== Render ====== */
    function render() {
        const role = roleSel.value;
        const ds = normalizeDash(pickDashRaw());
        hydrate(ds.gen);

        $('#coord-debug').hidden = (ds.gen?.length || 0) > 0;
        renderLegend();

        const lists = computeLists(role, ds.gen);
        const counts = {
            queue: lists.queue?.length || 0,
            work: lists.work?.length || 0,
            closed: lists.closed?.length || 0
        };
        bindTabs(counts);

        root.replaceChildren();
        const effectiveTab = (role !== 'coordinamento' && ACTIVE_TAB === 'queue') ? 'work' : ACTIVE_TAB;
        if (effectiveTab === 'queue') root.appendChild(section('Aperte', 'queue', lists.queue, role, ds));
        if (effectiveTab === 'work') root.appendChild(section('In lavorazione', 'work', lists.work, role, ds));
        if (effectiveTab === 'closed') root.appendChild(section('Chiuse', 'closed', lists.closed, role, ds));
        attachHandlers();
    }

    function section(title, kind, rows, role, ds) {
        const {
            slice,
            page,
            total
        } = paginate(rows, kind);
        const sec = document.createElement('section');
        sec.className = `sec sec--${kind}`;

        const dropRow =
            role === 'coordinamento' && kind === 'queue' ?
            `<div class="droprow">
                 <span class="drop" data-target="volontariato">${icon('docArrow')} Volontariato</span>
                 <span class="drop" data-target="mezzi">${icon('docArrow')} Mezzi e Materiali</span>
                 <span class="drop" data-target="prociv">${icon('docArrow')} Protezione Civile</span>
               </div>` :
            (kind === 'work' ?
                `<div class="droprow"><span class="drop" data-target="close">${icon('check')} Chiudi</span></div>` :
                '');

        sec.innerHTML = `
          <div class="sec__head">
            ${kind==='queue' ? icon('inbox') : kind==='work' ? icon('clock') : icon('check')}
            <h3 class="sec__title">${title}</h3>
            ${dropRow}
            <div class="sec__meta">${rows.length} elementi totali</div>
            <div class="sec__tools">
              <button class="btn" data-exp="${kind}">${icon('download')} Export Excel</button>
            </div>
          </div>
          <div class="list" data-kind="${kind}">
            ${slice.length ? '' : `<div class="empty">Nessuna voce.</div>`}
          </div>
          <div class="pager" data-kind="${kind}">
            <button class="btn" data-pg="prev" ${page<=1?'disabled':''}>«</button>
            <span class="pager__label">Pagina ${page} di ${total}</span>
            <button class="btn" data-pg="next" ${page>=total?'disabled':''}>»</button>
          </div>
        `;
        const list = sec.querySelector('.list');
        slice.forEach(r => list.appendChild(card(r, role, ds)));
        sec.querySelector('[data-exp]')?.addEventListener('click', () => exportSectionToExcel(kind, rows, ds, role));

        // drop listeners
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

    async function handleDropAction(id, srcStatus, target) {
        if (srcStatus === 'queue' && ['volontariato', 'mezzi', 'prociv'].includes(target)) {
            const instr = await promptInstructions();
            if (!instr) return;
            meta[id].status = 'assigned';
            meta[id].assigned_to = target;
            meta[id].assign_instructions = instr;
            meta[id].routed_by = 'Coordinamento';
            save(META_KEY, meta);
            toastOK('Segnalazione smistata', `Assegnata a ${labelRole(target)}`);
            render();
            return;
        }
        if (srcStatus === 'assigned' && target === 'close') {
            meta[id].status = 'closed';
            meta[id].closed_by = labelRole(roleSel.value);
            save(META_KEY, meta);
            toastOK('Segnalazione chiusa');
            render();
            return;
        }
        toastInfo('Operazione non permessa');
    }

    function findEventTypeFor(rec, ds) {
        if (rec.event_id) {
            const ev = (ds.ongoing || []).find(e => String(e.id) === String(rec.event_id));
            if (ev && ev.tipo) return ev.tipo;
        }
        return rec.tipologia || 'altro';
    }

    function renderTeams(m, id) {
        if (!m?.teams?.length) return '';
        return `
          <div class="teams" data-id="${id}">
            <h4>${icon('users','hi')} Squadre (${m.teams.length})</h4>
            ${m.teams.map((t,idx)=>`
              <div class="team" data-team="${idx}">
                <div style="display:flex;align-items:center;gap:.6rem">
                  <div><strong>${t.name}</strong> <span class="muted">• caposquadra: ${t.lead}</span></div>
                  <div class="team__tools" style="margin-left:auto">
                    <button class="tbtn" data-team-edit="${idx}" title="Modifica">${icon('pencil')}</button>
                    <button class="tbtn" data-team-del="${idx}" title="Elimina">${icon('trash')}</button>
                  </div>
                </div>
                <div class="team__meta">
                  ${t.contact ? `<span class="chip">${icon('user')} ${t.contact}</span>`:''}
                  ${t.asset   ? `<span class="chip">${icon('tag')} ${t.asset}</span>`:''}
                  ${t.area    ? `<span class="chip">${icon('mapPin')} ${t.area}</span>`:''}
                  ${t.members?.length ? `<span class="chip">${icon('users')} ${t.members.length} componenti</span>`:''}
                  ${t.start ? `<span class="chip">${icon('clock')} ${FMT(t.start)}</span>`:''}
                  ${t.end   ? `<span class="chip">${icon('clock')} → ${FMT(t.end)}</span>`:''}
                </div>
                ${t.notes ? `<div class="note">${icon('chat')} ${t.notes}</div>`:''}
              </div>
            `).join('')}
          </div>
        `;
    }

    function card(r, role, ds) {
        const {
            rec: g,
            meta: m
        } = r;
        const statusBadge = m.status === 'queue' ? 'b-queue' : m.status === 'assigned' ? 'b-work' : 'b-closed';
        const statusText = m.status === 'queue' ? 'In coda' : m.status === 'assigned' ? 'In lavorazione' : 'Chiusa';
        const areas = (g.aree || []).join(', ') || '—';
        const lastNote = m.notes?.[0];
        const hasEvent = !!(g.event_id);
        const tipoForCard = findEventTypeFor(g, ds) || g.tipologia || 'altro';
        const dataType = hasEvent ? (tipoForCard || 'altro') : (g.tipologia || null);

        const el = document.createElement('article');
        el.className = 'card';
        el.setAttribute('draggable', 'true');
        el.dataset.id = g.id;
        el.dataset.status = m.status;
        if (dataType) el.setAttribute('data-type', dataType);

        el.innerHTML = `
          <div class="card__head">
            <div><strong>GEN-${g.id}</strong> <span class="muted">• ${FMT(g.created_at)}</span></div>
            <div class="badge ${statusBadge}">${statusText}</div>
          </div>

          <div class="card__body">
            <div class="row">
              <div>
                <div class="muted" style="margin-bottom:.3rem">${icon('tag','hi')} Tipologia</div>
                <div class="tip-row">
                  <span class="legend__item tip-badge" style="--ev: var(--ev-${tipoForCard});">
                    <i class="legend__dot" aria-hidden="true"></i>${TYPE_LABELS[tipoForCard] || tipoForCard}
                  </span>
                  <span class="muted">• Operatore: ${g.operatore||'—'}</span>
                </div>

                ${(m.status==='assigned' && m.assign_instructions)
                    ? `<div class="instructions" style="margin-top:.75rem">
                         ${icon('information')} <strong>Indicazioni operative:</strong> ${m.assign_instructions}
                       </div>` : ''
                }

                ${g.sintesi ? `<div class="note" style="margin-top:.75rem">${icon('chat')} ${g.sintesi}</div>`:''}
                ${lastNote ? `<div class="note" style="margin-top:.55rem">${icon('chat')} <strong>Ultima nota:</strong> ${lastNote.text} <span class="muted">(${lastNote.by}, ${FMT(lastNote.at)})</span></div>`:''}

                ${renderTeams(m, g.id)}
              </div>

              <div>
                <div class="muted" style="margin-bottom:.3rem">${icon('mapPin','hi')} Aree interessate</div>
                <div>${areas!=='—' ? areas.split(',').map(a=>`<span class="tag">${a.trim()}</span>`).join(' ') : '—'}</div>
              </div>
            </div>
          </div>

          <div class="card__footer" data-id="${g.id}">
            <span class="muted" style="margin-right:auto">${icon('information')} Azioni</span>
            ${footerActions(role, m.status, g.id, m.assigned_to)}
          </div>
        `;

        el.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('text/id', g.id);
            e.dataTransfer.setData('text/status', m.status);
        });

        return el;
    }

    function footerActions(role, status, id, assignedTo) {
        if (status === 'queue') {
            if (role !== 'coordinamento') return `<span class="muted">In attesa di smistamento…</span>`;
            return `
              <button class="btn" data-act="assign" data-to="volontariato" data-id="${id}">${icon('docArrow')} Volontariato</button>
              <button class="btn" data-act="assign" data-to="mezzi" data-id="${id}">${icon('docArrow')} Mezzi e Materiali</button>
              <button class="btn" data-act="assign" data-to="prociv" data-id="${id}">${icon('docArrow')} Protezione Civile</button>
            `;
        }
        if (status === 'assigned') {
            const canManage = role === assignedTo;
            return `
              <button class="btn" data-act="note" data-id="${id}">${icon('chat')} Nota…</button>
              ${canManage ? `<button class="btn" data-act="team" data-id="${id}">${icon('users')} Crea squadra…</button>`:''}
              <span class="k-sep"></span>
              ${canManage ? `<button class="btn btn-primary" data-act="close" data-id="${id}">${icon('check')} Chiudi</button>`:''}
            `;
        }
        return `<button class="btn" data-act="note" data-id="${id}">${icon('chat')} Aggiungi nota</button>`;
    }

    function labelRole(r) {
        return r === 'volontariato' ? 'Volontariato' : r === 'mezzi' ? 'Mezzi e Materiali' : r === 'prociv' ? 'Protezione Civile' : r;
    }

    /* ====== Modali ====== */
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
    const TeamModal = {
        el: $('#team-modal'),
        openCreate(id) {
            $('#team-id').value = id;
            $('#team-index').value = '';
            $('#team-title').textContent = 'Crea squadra';
            ['t-name', 't-lead', 't-contact', 't-asset', 't-area', 't-start', 't-end', 't-members', 't-notes'].forEach(i => document.getElementById(i).value = '');
            hideTeamErrors();
            this.el.classList.add('is-open');
            setTimeout(() => $('#t-name').focus(), 30);
        },
        openEdit(id, idx) {
            $('#team-id').value = id;
            $('#team-index').value = String(idx);
            $('#team-title').textContent = 'Modifica squadra';
            const t = meta[id].teams[idx] || {};
            $('#t-name').value = t.name || '';
            $('#t-lead').value = t.lead || '';
            $('#t-contact').value = t.contact || '';
            $('#t-asset').value = t.asset || '';
            $('#t-area').value = t.area || '';
            $('#t-start').value = t.start || '';
            $('#t-end').value = t.end || '';
            $('#t-members').value = (t.members || []).join(', ');
            $('#t-notes').value = t.notes || '';
            hideTeamErrors();
            this.el.classList.add('is-open');
            setTimeout(() => $('#t-name').focus(), 30);
        },
        close() {
            this.el.classList.remove('is-open');
        }
    };

    function hideTeamErrors() {
        $('#err-t-name').hidden = true;
        $('#err-t-lead').hidden = true;
        $('#err-t-range').hidden = true;
    }

    document.querySelectorAll('[data-close="note"]').forEach(n => n.addEventListener('click', () => NoteModal.close()));
    document.querySelectorAll('[data-close="team"]').forEach(n => n.addEventListener('click', () => TeamModal.close()));

    // Salva nota
    $('#note-save').addEventListener('click', () => {
        const id = $('#note-id').value;
        const text = $('#note-text').value.trim();
        $('#note-err').hidden = !!text;
        if (!text) {
            $('#note-text').focus();
            return;
        }
        const role = roleSel.value;
        meta[id].notes ||= [];
        meta[id].notes.unshift({
            text,
            by: labelRole(role),
            at: new Date().toISOString()
        });
        save(META_KEY, meta);
        NoteModal.close();
        toastInfo('Nota aggiunta');
        render();
    });

    // Salva squadra
    $('#team-save').addEventListener('click', () => {
        hideTeamErrors();
        const id = $('#team-id').value,
            idxStr = $('#team-index').value;
        const name = $('#t-name').value.trim(),
            lead = $('#t-lead').value.trim();
        const start = $('#t-start').value,
            end = $('#t-end').value;
        let ok = true;
        if (!name) {
            $('#err-t-name').hidden = false;
            ok = false;
        }
        if (!lead) {
            $('#err-t-lead').hidden = false;
            ok = false;
        }
        if (start && end && (new Date(end) <= new Date(start))) {
            $('#err-t-range').hidden = false;
            ok = false;
        }
        if (!ok) return;

        const data = {
            name,
            lead,
            contact: $('#t-contact').value.trim(),
            asset: $('#t-asset').value.trim(),
            area: $('#t-area').value.trim(),
            start,
            end,
            members: $('#t-members').value.split(',').map(s => s.trim()).filter(Boolean),
            notes: $('#t-notes').value.trim()
        };
        meta[id].teams ||= [];
        if (idxStr === '') {
            meta[id].teams.unshift({
                ...data,
                created_by: labelRole(roleSel.value),
                created_at: new Date().toISOString()
            });
            toastOK('Squadra creata');
        } else {
            const idx = Number(idxStr);
            meta[id].teams[idx] = {
                ...meta[id].teams[idx],
                ...data
            };
            toastOK('Squadra aggiornata');
        }
        save(META_KEY, meta);
        TeamModal.close();
        render();
    });

    /* ====== Handlers ====== */
    function attachHandlers() {
        root.querySelectorAll('[data-act="assign"]').forEach(b => {
            b.addEventListener('click', async () => {
                const id = b.dataset.id,
                    to = b.dataset.to;
                const instr = await promptInstructions();
                if (!instr) return;
                meta[id].status = 'assigned';
                meta[id].assigned_to = to;
                meta[id].assign_instructions = instr;
                meta[id].routed_by = 'Coordinamento';
                save(META_KEY, meta);
                toastOK('Segnalazione smistata', `Assegnata a ${labelRole(to)}`);
                render();
            });
        });

        root.querySelectorAll('[data-act="note"]').forEach(b => b.addEventListener('click', () => NoteModal.open(b.dataset.id)));
        root.querySelectorAll('[data-act="team"]').forEach(b => b.addEventListener('click', () => TeamModal.openCreate(b.dataset.id)));

        root.querySelectorAll('.teams').forEach(box => {
            const id = box.dataset.id;
            box.querySelectorAll('[data-team-edit]').forEach(btn => btn.addEventListener('click', () => TeamModal.openEdit(id, Number(btn.dataset.teamEdit))));
            box.querySelectorAll('[data-team-del]').forEach(btn => btn.addEventListener('click', async () => {
                const idx = Number(btn.dataset.teamDel);
                const ok = await askConfirm('Eliminare la squadra?', 'Questa operazione non può essere annullata.');
                if (!ok.isConfirmed) return;
                meta[id].teams.splice(idx, 1);
                save(META_KEY, meta);
                toastOK('Squadra eliminata');
                render();
            }));
        });

        root.querySelectorAll('[data-act="close"]').forEach(b => {
            b.addEventListener('click', async () => {
                const id = b.dataset.id;
                const c = await askConfirm('Chiudere la segnalazione?', 'Non sarà più operativa (potrai solo aggiungere note).');
                if (!c.isConfirmed) return;
                meta[id].status = 'closed';
                meta[id].closed_by = labelRole(roleSel.value);
                save(META_KEY, meta);
                toastOK('Segnalazione chiusa');
                render();
            });
        });

        root.querySelectorAll('.pager').forEach(pg => {
            const kind = pg.dataset.kind;
            pg.querySelectorAll('[data-pg]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const dir = btn.dataset.pg;
                    const total = Number(pg.querySelector('.pager__label')?.textContent.match(/di\s+(\d+)/)?.[1] || 1);
                    if (dir === 'prev') pages[kind] = Math.max(1, (pages[kind] || 1) - 1);
                    if (dir === 'next') pages[kind] = Math.min(total, (pages[kind] || 1) + 1);
                    save(PAGES_KEY, pages);
                    render();
                });
            });
        });
    }

    /* ====== Debug/demo ====== */
    $('#debug-load').addEventListener('click', () => {
        const demo = {
            gen: [{
                    id: 101,
                    created_at: new Date(Date.now() - 3600e3).toISOString(),
                    tipologia: 'aib',
                    operatore: 'Mario',
                    aree: ['Comune A', 'Zona 1'],
                    sintesi: 'Incendio sterpaglie.',
                    event_id: 1
                },
                {
                    id: 102,
                    created_at: new Date(Date.now() - 7200e3).toISOString(),
                    tipologia: 'idraulico',
                    operatore: 'Luca',
                    aree: ['Fiume B'],
                    sintesi: 'Argine a rischio.',
                    event_id: 2
                },
                {
                    id: 103,
                    created_at: new Date(Date.now() - 1800e3).toISOString(),
                    tipologia: 'meteo-avverso',
                    operatore: 'Sara',
                    aree: ['Comune C'],
                    sintesi: 'Vento forte, alberi.',
                    event_id: null
                },
                {
                    id: 104,
                    created_at: new Date(Date.now() - 900e3).toISOString(),
                    tipologia: 'uomo',
                    operatore: 'Paola',
                    aree: ['Tangenziale'],
                    sintesi: 'Sversamento liquidi.',
                    event_id: 3
                },
                {
                    id: 105,
                    created_at: new Date(Date.now() - 2600e3).toISOString(),
                    tipologia: 'sismico',
                    operatore: 'Enzo',
                    aree: ['Comune D'],
                    sintesi: 'Scosse avvertite.',
                    event_id: null
                },
                {
                    id: 106,
                    created_at: new Date(Date.now() - 5600e3).toISOString(),
                    tipologia: 'idrogeologico',
                    operatore: 'Anna',
                    aree: ['Versante E'],
                    sintesi: 'Frana attiva.',
                    event_id: 4
                },
            ],
            ongoing: [{
                id: 1,
                tipo: 'aib'
            }, {
                id: 2,
                tipo: 'idraulico'
            }, {
                id: 3,
                tipo: 'uomo'
            }, {
                id: 4,
                tipo: 'idrogeologico'
            }]
        };
        try {
            localStorage.setItem(DASH_KEYS[0], JSON.stringify(demo));
        } catch {}
        toastOK('Dati demo caricati');
        render();
    });
    $('#debug-retry').addEventListener('click', async () => {
        await requestSnapshotFromOtherWindow();
        render();
    });

    /* ====== Boot ====== */
    async function boot() {
        renderLegend();
        if (window.SOR?.getState) {
            render();
            window.SOR.subscribe?.(() => render());
        } else {
            await requestSnapshotFromOtherWindow();
            render();
            window.addEventListener('storage', (e) => {
                if (DASH_KEYS.includes(e.key)) render();
            });
            let lastRaw = '';
            setInterval(() => {
                const current = DASH_KEYS.map(k => localStorage.getItem(k) || '').join('|');
                if (current !== lastRaw) {
                    lastRaw = current;
                    render();
                }
            }, 1200);
        }
    }
    boot();
</script>