<div id="sor-logs" class="p-6 space-y-6">
    <h1 class="text-xl font-semibold mb-2">Log SOR</h1>

    <section id="coord-log" class="log-sec">
        <div class="log-head">
            <h3 class="log-title">Registro attività</h3>
            <div class="log-meta">
                <span id="log-total">0</span> eventi
                · Dashboard: {{ $dashboardLogs->total() }} · Coordinamento: {{ $coordLogs->total() }}
            </div>
        </div>

        {{-- TOOLBAR FILTRI --}}
        <div class="log-toolbar">
            <div class="log-field">
                <label class="lbl">Ricerca testo</label>
                <input id="log-q" class="log-input" placeholder="Operatore, nota, azione…" />
            </div>
            <div class="log-field">
                <label class="lbl">Azione</label>
                <select id="log-action" class="log-select">
                    <option value="">Tutte…</option>
                    <option value="assign">Assegnazione</option>
                    <option value="note">Nota</option>
                    <option value="close">Chiusura segnalazione</option>
                    {{-- Azioni specifiche SOR --}}
                    <option value="sor_open">Apertura SOR</option>
                    <option value="sor_close">Chiusura SOR</option>
                    <option value="sor_update">Aggiornamento SOR</option>
                </select>
            </div>
            <div class="log-field">
                <label class="lbl">Operatore</label>
                <input id="log-operator" class="log-input" placeholder="Nome / email…" />
            </div>
            <div class="log-field">
                <label class="lbl">Dal</label>
                <input id="log-from" type="date" class="log-input" />
            </div>
            <div class="log-field">
                <label class="lbl">Al</label>
                <input id="log-to" type="date" class="log-input" />
            </div>
            <div class="log-field">
                <label class="lbl">Fonte</label>
                <select id="log-source" class="log-select">
                    <option value="">Tutte</option>
                    <option value="dashboard">Dashboard</option>
                    <option value="coordinamento">Coordinamento</option>
                    <option value="sor">SOR</option>
                </select>
            </div>

            <div class="log-field" style="grid-column: 1 / -1; display:flex; gap:.6rem; align-items:center">
                <button id="log-reset" class="log-btn" type="button">Reset</button>
                <button id="log-export" class="log-btn" type="button">⬇️ Export CSV</button>

                <span class="log-muted" style="margin-left:auto">Vista:</span>
                <button id="log-view-table" class="log-btn log-btn--primary" type="button">Tabella</button>
                <button id="log-view-timeline" class="log-btn" type="button">Timeline</button>
            </div>
        </div>

        {{-- TABELLA --}}
        <div class="log-wrap" id="log-table-wrap">
            <table class="log-table">
                <thead>
                    <tr>
                        <th style="width: 140px">Data/Ora</th>
                        <th style="width: 140px">Fonte</th>
                        <th style="width: 220px">Azione</th>
                        <th style="width: 200px">Operatore</th>
                        <th style="width: 80px; text-align:center">Dettagli</th>
                    </tr>
                </thead>
                <tbody id="log-body">
                    <tr>
                        <td colspan="5" class="px-3 py-3 log-muted">Nessun log.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- TIMELINE --}}
        <div class="timeline" id="log-timeline" style="display:none"></div>

        {{-- PAGER --}}
        <div class="log-pager">
            <button class="log-btn" id="log-prev">«</button>
            <span class="pager__label" id="log-page">Pagina 1 di 1</span>
            <button class="log-btn" id="log-next">»</button>
        </div>
    </section>
</div>

{{-- MODALE DETTAGLIO LOG --}}
<div id="log-detail-modal-backdrop"
    style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.45); z-index:50; align-items:center; justify-content:center;">
    <div id="log-detail-modal"
        style="background:white; border-radius:12px; max-width:640px; width:100%; margin:0 16px; box-shadow:0 20px 45px rgba(15,23,42,0.25);">
        <div style="padding:12px 16px; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between;">
            <div>
                <h2 id="log-detail-title" style="font-size:14px; font-weight:600; color:#0f172a;">
                    Dettaglio evento
                </h2>
                <p id="log-detail-subtitle" style="font-size:11px; color:#6b7280; margin-top:2px;"></p>
            </div>
            <button type="button" id="log-detail-close"
                style="border:none; background:transparent; cursor:pointer; font-size:16px; line-height:1; color:#6b7280;">
                ×
            </button>
        </div>

        <div style="padding:12px 16px; font-size:12px; color:#111827; max-height:60vh; overflow:auto;">
            <dl style="display:grid; grid-template-columns:minmax(0,120px) minmax(0,1fr); row-gap:4px; column-gap:8px; margin-bottom:10px;">
                <dt style="font-weight:600; color:#6b7280;">Data/Ora</dt>
                <dd id="log-detail-when"></dd>

                <dt style="font-weight:600; color:#6b7280;">Fonte</dt>
                <dd id="log-detail-source"></dd>

                <dt style="font-weight:600; color:#6b7280;">Azione</dt>
                <dd id="log-detail-action"></dd>

                <dt style="font-weight:600; color:#6b7280;">Operatore</dt>
                <dd id="log-detail-operator"></dd>

                <dt style="font-weight:600; color:#6b7280;">Da</dt>
                <dd id="log-detail-from"></dd>

                <dt style="font-weight:600; color:#6b7280;">A</dt>
                <dd id="log-detail-to"></dd>
            </dl>

            <div>
                <div style="font-weight:600; color:#6b7280; margin-bottom:4px;">Dettaglio</div>
                <pre id="log-detail-body"
                    style="white-space:pre-wrap; word-break:break-word; border-radius:8px; border:1px solid #e5e7eb; background:#f9fafb; padding:8px; font-size:11px; font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;"></pre>
            </div>
        </div>

        <div style="padding:8px 16px; border-top:1px solid #e5e7eb; text-align:right;">
            <button type="button" id="log-detail-close-bottom"
                style="border-radius:999px; border:1px solid #d1d5db; padding:4px 12px; font-size:11px; cursor:pointer; background:#f9fafb;">
                Chiudi
            </button>
        </div>
    </div>
</div>

{{-- DUMP DATI DAL BACKEND (pagina corrente) --}}
<script>
    window.SOR_DASHBOARD_LOGS = @json($dashboardLogs->items());
    window.SOR_COORD_LOGS = @json($coordLogs->items());
</script>

<script type="module">
    const $ = s => document.querySelector(s);
    const $$ = s => Array.from(document.querySelectorAll(s));

    const FMT = (iso) => new Intl.DateTimeFormat('it-IT', {
        dateStyle: 'short',
        timeStyle: 'short'
    }).format(new Date(iso || Date.now()));

    const LOG_PAGE_SIZE = 20;

    const RAW_DASH = Array.isArray(window.SOR_DASHBOARD_LOGS) ? window.SOR_DASHBOARD_LOGS : [];
    const RAW_COORD = Array.isArray(window.SOR_COORD_LOGS) ? window.SOR_COORD_LOGS : [];

    function mapDashboardLog(l) {
        return {
            id: l.id ?? null,
            source: 'dashboard',
            created_at: l.created_at ?? null,
            action: l.action ?? '',
            from_status: l.from_status ?? '',
            to_status: l.to_status ?? '',
            from_assignee: l.from_assignee ?? '',
            to_assignee: l.to_assignee ?? '',
            details: l.details ?? '',
            performed_by: l.performed_by ?? '',
        };
    }

    function mapCoordLog(l) {
        return {
            id: l.id ?? null,
            source: 'coordinamento',
            created_at: l.created_at ?? null,
            action: l.action ?? '',
            from_status: l.from_status ?? '',
            to_status: l.to_status ?? '',
            from_assignee: l.from_assignee ?? '',
            to_assignee: l.to_assignee ?? '',
            details: l.details ?? '',
            performed_by: l.performed_by ?? '',
        };
    }

    const ts = d => d ? new Date(d).getTime() : 0;

    const ALL_LOGS = [
        ...RAW_DASH.map(mapDashboardLog),
        ...RAW_COORD.map(mapCoordLog),
    ].sort((a, b) => ts(b.created_at) - ts(a.created_at));

    // mappa id → log (con chiave di fallback se manca l'id)
    const LOG_BY_ID = {};
    ALL_LOGS.forEach((l, idx) => {
        const key = l.id != null ? String(l.id) : `row-${idx}`;
        l._key = key;
        LOG_BY_ID[key] = l;
    });

    const state = {
        all: ALL_LOGS,
        filtered: ALL_LOGS.slice(),
        page: 1,
        perPage: LOG_PAGE_SIZE,
        view: 'table',
        filters: {
            q: '',
            action: '',
            operator: '',
            from: '',
            to: '',
            source: '',
        }
    };

    function labelStatus(s) {
        const v = (s || '').toString().toLowerCase();
        if (['queue', 'aperta', 'open'].includes(v)) return 'Aperta';
        if (['assigned', 'work', 'in_lavorazione'].includes(v)) return 'In lavorazione';
        if (['closed', 'chiusa', 'close'].includes(v)) return 'Chiusa';
        return v || '—';
    }

    function statusClass(s) {
        const v = (s || '').toString().toLowerCase();
        if (['queue', 'aperta', 'open'].includes(v)) return 'st-queue';
        if (['assigned', 'work', 'in_lavorazione'].includes(v)) return 'st-assigned';
        if (['closed', 'chiusa', 'close'].includes(v)) return 'st-closed';
        return '';
    }

    // === NORMALIZZAZIONE AZIONI ===
    function normalizeAction(a) {
        const raw = (a || '').toString();
        const t = raw.toLowerCase();

        // CRUD generico
        if (t.startsWith('created_') || ['created', 'create'].includes(t)) {
            return {
                key: 'create',
                label: 'Create',
                raw
            };
        }
        if (t.startsWith('updated_') || ['updated', 'update'].includes(t)) {
            return {
                key: 'update',
                label: 'Update',
                raw
            };
        }
        if (t.startsWith('deleted_') || ['deleted', 'delete'].includes(t)) {
            return {
                key: 'delete',
                label: 'Delete',
                raw
            };
        }

        // Coordinamento segnalazioni
        if (t === 'assign' || t === 'assigned') {
            return {
                key: 'assign',
                label: 'Assegnazione',
                raw
            };
        }
        if (t === 'close' || t === 'closed') {
            return {
                key: 'close',
                label: 'Chiusura',
                raw
            };
        }
        if (t === 'note') {
            return {
                key: 'note',
                label: 'Nota',
                raw
            };
        }

        // Azioni specifiche SOR
        if (t === 'sor_open') {
            return {
                key: 'sor_open',
                label: 'Apertura SOR',
                raw
            };
        }
        if (t === 'sor_close') {
            return {
                key: 'sor_close',
                label: 'Chiusura SOR',
                raw
            };
        }
        if (t === 'sor_update') {
            return {
                key: 'sor_update',
                label: 'Aggiornamento SOR',
                raw
            };
        }

        if (!t) {
            return {
                key: 'other',
                label: '—',
                raw
            };
        }
        return {
            key: 'other',
            label: raw.replace(/_/g, ' '),
            raw,
        };
    }

    // Badge uniforme
    function actBadge(a) {
        const info = normalizeAction(a);
        return `
            <span class="badge badge-act badge-act--${info.key}" title="${info.raw}">
                ${info.label}
            </span>
        `;
    }

    // === TESTO UMANO PER LA COLONNA "AZIONE" ===
    function humanActionLabel(log) {
        const raw = (log.action || '').toString();
        const t = raw.toLowerCase();

        // Nuova segnalazione
        if (
            (t.startsWith('created_') || t.startsWith('create_')) &&
            t.includes('segnalazione')
        ) {
            return 'Nuova segnalazione';
        }

        // Nuovo evento
        if (
            (t.startsWith('created_') || t.startsWith('create_')) &&
            t.includes('evento')
        ) {
            return 'Nuovo evento';
        }

        // Fallback create generico
        if (t === 'create' || t === 'created') {
            return 'Creazione record';
        }

        if (t === 'assign' || t === 'assigned') {
            return 'Assegnazione segnalazione';
        }

        if (t === 'close' || t === 'closed') {
            return 'Chiusura segnalazione';
        }

        if (t === 'note') {
            return 'Inserita nota';
        }

        if (t === 'sor_open') {
            return 'Apertura Sala Operativa Regionale';
        }

        if (t === 'sor_close') {
            return 'Chiusura Sala Operativa Regionale';
        }

        if (t === 'sor_update') {
            return 'Aggiornamento configurazione / stato SOR';
        }

        // Ultimo fallback: etichetta normalizzata
        return normalizeAction(raw).label;
    }

    // Contenuto della cella "Azione": badge + descrizione testuale
    function formatActionCell(log) {
        const desc = humanActionLabel(log);
        return `
            <div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
                ${actBadge(log.action)}
                <div class="log-muted" style="font-size:.78rem; text-align:center;">
                    ${desc}
                </div>
            </div>
        `;
    }

    // === MODALE DETTAGLIO ===
    const modalBackdrop = $('#log-detail-modal-backdrop');
    const modalClose = $('#log-detail-close');
    const modalClose2 = $('#log-detail-close-bottom');

    function fillDetailModal(log) {
        const info = normalizeAction(log.action);

        $('#log-detail-title').textContent = humanActionLabel(log);
        $('#log-detail-subtitle').textContent = log.id ? `ID #${log.id}` : '';

        $('#log-detail-when').textContent = log.created_at ? FMT(log.created_at) : '—';

        const a = (log.action || '').toLowerCase();
        const isSor = a.startsWith('sor_');

        $('#log-detail-source').textContent = isSor
            ? 'SOR'
            : (log.source === 'dashboard'
                ? 'Dashboard'
                : (log.source === 'coordinamento'
                    ? 'Coordinamento'
                    : 'Altro'));

        $('#log-detail-action').textContent = info.raw || info.label;
        $('#log-detail-operator').textContent = log.performed_by || '—';

        const fromParts = [];
        if (log.from_status) fromParts.push(`Stato: ${labelStatus(log.from_status)}`);
        if (log.from_assignee) fromParts.push(`Operatore: ${log.from_assignee}`);
        $('#log-detail-from').textContent = fromParts.length ? fromParts.join(' · ') : '—';

        const toParts = [];
        if (log.to_status) toParts.push(`Stato: ${labelStatus(log.to_status)}`);
        if (log.to_assignee) toParts.push(`Operatore: ${log.to_assignee}`);
        $('#log-detail-to').textContent = toParts.length ? toParts.join(' · ') : '—';

        $('#log-detail-body').textContent = log.details || '—';
    }

    function openDetailModal(log) {
        if (!modalBackdrop) return;
        fillDetailModal(log);
        modalBackdrop.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeDetailModal() {
        if (!modalBackdrop) return;
        modalBackdrop.style.display = 'none';
        document.body.style.overflow = '';
    }

    if (modalClose) modalClose.addEventListener('click', closeDetailModal);
    if (modalClose2) modalClose2.addEventListener('click', closeDetailModal);
    if (modalBackdrop) {
        modalBackdrop.addEventListener('click', (e) => {
            if (e.target === modalBackdrop) {
                closeDetailModal();
            }
        });
    }
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeDetailModal();
        }
    });

    // === FILTRI ===
    function debounce(fn, ms = 300) {
        let t;
        return (...args) => {
            clearTimeout(t);
            t = setTimeout(() => fn(...args), ms);
        };
    }

    function applyFilters() {
        const f = state.filters;
        const q = f.q.toLowerCase();

        let rows = state.all;

        // filtro Fonte: dashboard / coordinamento / SOR (su azione sor_*)
        if (f.source === 'sor') {
            rows = rows.filter(r => (r.action || '').toLowerCase().startsWith('sor_'));
        } else if (f.source) {
            rows = rows.filter(r => r.source === f.source);
        }

        if (q) {
            rows = rows.filter(r => {
                const text = [
                    r.details,
                    r.action,
                    r.performed_by,
                ].join(' ').toLowerCase();
                return text.includes(q);
            });
        }

        if (f.action) {
            rows = rows.filter(r => (r.action || '').toLowerCase() === f.action.toLowerCase());
        }

        if (f.operator) {
            const op = f.operator.toLowerCase();
            rows = rows.filter(r => (r.performed_by || '').toLowerCase().includes(op));
        }

        if (f.from) {
            const fromDate = new Date(f.from + 'T00:00:00');
            rows = rows.filter(r => {
                if (!r.created_at) return false;
                return new Date(r.created_at) >= fromDate;
            });
        }

        if (f.to) {
            const toDate = new Date(f.to + 'T23:59:59');
            rows = rows.filter(r => {
                if (!r.created_at) return false;
                return new Date(r.created_at) <= toDate;
            });
        }

        state.filtered = rows;
        state.page = 1;
        renderLogs();
    }

    function getPageRows() {
        const start = (state.page - 1) * state.perPage;
        return state.filtered.slice(start, start + state.perPage);
    }

    // === RENDER TABELLA / TIMELINE ===
    function renderLogsTable() {
        const tbody = $('#log-body');
        tbody.replaceChildren();

        const total = state.filtered.length;
        $('#log-total').textContent = total;

        const lastPage = Math.max(1, Math.ceil(total / state.perPage));
        const curPage = Math.min(state.page, lastPage);
        state.page = curPage;

        $('#log-page').textContent = `Pagina ${curPage} di ${lastPage}`;
        $('#log-prev').disabled = curPage <= 1;
        $('#log-next').disabled = curPage >= lastPage;

        const rows = getPageRows();
        if (!rows.length) {
            const tr = document.createElement('tr');
            tr.innerHTML = '<td colspan="5" class="px-3 py-3 log-muted">Nessun log.</td>';
            tbody.appendChild(tr);
            return;
        }

        rows.forEach(l => {
            const tr = document.createElement('tr');
            tr.className = 'log-row';
            tr.dataset.action = (l.action || '').toLowerCase();
            tr.dataset.source = l.source || '';

            const when = l.created_at ? FMT(l.created_at) : '—';

            const a = (l.action || '').toLowerCase();
            const isSor = a.startsWith('sor_');
            const fonteKey = isSor ? 'sor' : (l.source || 'unknown');
            const fonteLabel = isSor
                ? 'SOR'
                : (l.source === 'dashboard'
                    ? 'Dashboard'
                    : (l.source === 'coordinamento'
                        ? 'Coordinamento'
                        : 'Altro'));

            const fonteHTML =
                `<span class="src-pill src-pill--${fonteKey}">
                    <span class="src-dot" aria-hidden="true"></span>
                    <span>${fonteLabel}</span>
                </span>`;

            const actionHTML = formatActionCell(l);

            tr.innerHTML =
                `<td>${when}</td>
                 <td>${fonteHTML}</td>
                 <td>${actionHTML}</td>
                 <td>${l.performed_by || '—'}</td>
                 <td style="text-align:center;">
                    <button type="button"
                            class="log-btn log-btn--icon log-open-detail"
                            data-key="${l._key}">
                        i
                    </button>
                 </td>`;

            tbody.appendChild(tr);
        });

        // bind tasto "i" → modale
        tbody.querySelectorAll('.log-open-detail').forEach(btn => {
            btn.addEventListener('click', () => {
                const key = btn.dataset.key;
                const log = LOG_BY_ID[key];
                if (log) {
                    openDetailModal(log);
                }
            });
        });
    }

    function formatTransition(fromStatus, toStatus, fromAssignee, toAssignee, action) {
        const a = (action || '').toLowerCase();

        // Azioni SOR nella timeline: descrizione generica
        if (a === 'sor_open') return '<em class="log-muted">Apertura Sala Operativa Regionale</em>';
        if (a === 'sor_close') return '<em class="log-muted">Chiusura Sala Operativa Regionale</em>';
        if (a === 'sor_update') return '<em class="log-muted">Aggiornamento stato/configurazione SOR</em>';

        if (a === 'note') {
            return '<em class="log-muted">Inserita una nota</em>';
        }

        if (!fromStatus && !toStatus && !fromAssignee && !toAssignee) {
            return '—';
        }

        const fromHTML =
            '<span class="chip chip--from">' +
            '<strong>Da</strong>' +
            `<span class="${statusClass(fromStatus)}">${labelStatus(fromStatus)}</span>` +
            (fromAssignee ? `<span class="log-muted">• ${fromAssignee}</span>` : '') +
            '</span>';

        const toHTML =
            '<span class="chip chip--to">' +
            '<strong>A</strong>' +
            `<span class="${statusClass(toStatus)}">${labelStatus(toStatus)}</span>` +
            (toAssignee ? `<span class="log-muted">• ${toAssignee}</span>` : '') +
            '</span>';

        return `<div class="flow">${fromHTML}<span class="arrow">→</span>${toHTML}</div>`;
    }

    function renderLogsTimeline() {
        const wrap = $('#log-timeline');
        wrap.replaceChildren();

        const rows = getPageRows();
        if (!rows.length) {
            const div = document.createElement('div');
            div.className = 'log-muted';
            div.textContent = 'Nessun log.';
            wrap.appendChild(div);
            return;
        }

        rows.forEach(l => {
            const it = document.createElement('div');
            it.className = 't-item';
            it.dataset.action = (l.action || '').toLowerCase();
            it.dataset.source = l.source || '';

            const when = l.created_at ? FMT(l.created_at) : '—';

            const a = (l.action || '').toLowerCase();
            const isSor = a.startsWith('sor_');
            const fonteKey = isSor ? 'sor' : (l.source || 'unknown');
            const fonteLabel = isSor
                ? 'SOR'
                : (l.source === 'dashboard'
                    ? 'Dashboard'
                    : (l.source === 'coordinamento'
                        ? 'Coordinamento'
                        : 'Altro'));

            const fonteHTML =
                `<span class="src-pill src-pill--${fonteKey}">
                    <span class="src-dot" aria-hidden="true"></span>
                    <span>${fonteLabel}</span>
                </span>`;

            const chainHTML = formatTransition(
                l.from_status,
                l.to_status,
                l.from_assignee,
                l.to_assignee,
                l.action
            );
            const det = (l.details || '').replace(/\n/g, '<br>');

            it.innerHTML =
                `<span class="t-dot" aria-hidden="true"></span>
                 <div class="t-meta">
                    <strong>${when}</strong>
                    <span>${actBadge(l.action)}</span>
                    ${fonteHTML}
                    <span class="log-muted">${l.performed_by || '—'}</span>
                 </div>
                 <div class="t-note">
                    <div style="margin-bottom:.35rem">${chainHTML}</div>
                    <div class="log-note">${det || '—'}</div>
                 </div>`;

            wrap.appendChild(it);
        });
    }

    function renderLogs() {
        const isTable = state.view === 'table';
        $('#log-table-wrap').style.display = isTable ? '' : 'none';
        $('#log-timeline').style.display = isTable ? 'none' : '';

        $('#log-view-table').classList.toggle('log-btn--primary', isTable);
        $('#log-view-timeline').classList.toggle('log-btn--primary', !isTable);

        if (isTable) renderLogsTable();
        else renderLogsTimeline();
    }

    function exportLogsCSV() {
        const rows = getPageRows();
        const esc = s => `"${String(s ?? '').replace(/"/g, '""')}"`;

        const header = [
            'data_ora',
            'fonte',
            'azione',
            'from_status',
            'to_status',
            'from_assignee',
            'to_assignee',
            'operatore',
            'dettagli',
        ];

        const lines = rows.map(l => [
            l.created_at ? FMT(l.created_at) : '',
            (l.action || '').toLowerCase().startsWith('sor_')
                ? 'SOR'
                : l.source,
            humanActionLabel(l),
            l.from_status || '',
            l.to_status || '',
            l.from_assignee || '',
            l.to_assignee || '',
            l.performed_by || '',
            l.details || '',
        ].map(esc).join(';'));

        const csv = [header.join(';'), ...lines].join('\r\n');
        const blob = new Blob([csv], {
            type: 'text/csv;charset=utf-8;'
        });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `sor_logs_${new Date().toISOString().slice(0,10)}.csv`;
        a.click();
        URL.revokeObjectURL(url);
    }

    /* ===== TOOLBAR / NAVIGAZIONE ===== */
    function bindToolbar() {
        const f = state.filters;
        const Q = $('#log-q');
        const A = $('#log-action');
        const OP = $('#log-operator');
        const FROM = $('#log-from');
        const TO = $('#log-to');
        const SRC = $('#log-source');

        const onChange = debounce(() => {
            f.q = (Q.value || '').trim();
            f.action = A.value || '';
            f.operator = (OP.value || '').trim();
            f.from = FROM.value || '';
            f.to = TO.value || '';
            f.source = SRC.value || '';
            applyFilters();
        }, 250);

        [Q, OP, FROM, TO].forEach(el => {
            el.addEventListener('input', onChange);
        });
        [A, SRC].forEach(el => {
            el.addEventListener('change', onChange);
        });

        $('#log-reset').addEventListener('click', () => {
            Q.value = '';
            A.value = '';
            OP.value = '';
            FROM.value = '';
            TO.value = '';
            SRC.value = '';

            Object.assign(f, {
                q: '',
                action: '',
                operator: '',
                from: '',
                to: '',
                source: '',
            });
            applyFilters();
        });

        $('#log-view-table').addEventListener('click', () => {
            state.view = 'table';
            renderLogs();
        });

        $('#log-view-timeline').addEventListener('click', () => {
            state.view = 'timeline';
            renderLogs();
        });

        $('#log-prev').addEventListener('click', () => {
            if (state.page > 1) {
                state.page--;
                renderLogs();
            }
        });

        $('#log-next').addEventListener('click', () => {
            const lastPage = Math.max(1, Math.ceil(state.filtered.length / state.perPage));
            if (state.page < lastPage) {
                state.page++;
                renderLogs();
            }
        });

        $('#log-export').addEventListener('click', exportLogsCSV);
    }

    function boot() {
        bindToolbar();
        applyFilters();
    }

    boot();
</script>
