<section class="w-full h-full" id="coord-app">
    <style>
        /* opzionale: solo se non lo hai già nel CSS globale */
        .btn.btn-xs {
            padding: .18rem .45rem;
            font-size: .78rem;
            border-radius: .55rem;
            line-height: 1.1;
        }
    </style>

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
            <code>POST /sor/segnalazioni/{id}/notes</code>, <code>GET /sor/logs</code>,
            <code>GET /sor/segnalazioni/{id}</code>.
            <br />Il client prova anche <code>/api/sor/*</code> in fallback.
        </div>
    </div>

    <section class="legend" id="ev-legend" aria-label="Legenda eventi"></section>
    <nav class="tabbar" id="coord-tabs" role="tablist" aria-label="Stati segnalazioni"></nav>
    <div id="coord-root" class="coord-root"></div>

    <!-- LOG admin -->
    <section id="coord-log" class="log-sec" style="margin-top:1rem;display:none">
        <div class="log-head">
            <h3 class="log-title">Registro attività (Admin)</h3>
            <div class="log-meta"><span id="log-total">0</span> eventi</div>
        </div>

        <div class="log-toolbar" id="log-toolbar">
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
                    <option value="close">Chiusura</option>
                </select>
            </div>
            <div class="log-field">
                <label class="lbl">Operatore</label>
                <input id="log-operator" class="log-input" placeholder="Nome / email…" />
            </div>
            <div class="log-field">
                <label class="lbl">ID Segnalazione</label>
                <input id="log-sid" class="log-input" inputmode="numeric" placeholder="es. 123" />
            </div>
            <div class="log-field">
                <label class="lbl">Dal</label>
                <input id="log-from" type="date" class="log-input" />
            </div>
            <div class="log-field">
                <label class="lbl">Al</label>
                <input id="log-to" type="date" class="log-input" />
            </div>

            <div class="log-field" style="grid-column: 1 / -1; display:flex; gap:.6rem; align-items:center">
                <button id="log-reset" class="log-btn" type="button">Reset</button>
                <button id="log-export" class="log-btn" type="button">⬇️ Export CSV</button>
                <span class="log-muted" style="margin-left:auto">Vista:</span>
                <button id="log-view-table" class="log-btn log-btn--primary" type="button">Tabella</button>
                <button id="log-view-timeline" class="log-btn" type="button">Timeline</button>
            </div>
        </div>

        <div class="log-wrap" id="log-table-wrap">
            <table class="log-table">
                <thead>
                    <tr>
                        <th style="width:160px">Data/Ora</th>
                        <th style="width:140px">Azione</th>
                        <th style="width:120px">Segnalazione</th>
                        <th>Da → A</th>
                        <th style="width:200px">Operatore</th>
                        <th>Nota</th>
                    </tr>
                </thead>
                <tbody id="log-body">
                    <tr>
                        <td colspan="6" class="px-3 py-3 log-muted">Nessun log.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="timeline" id="log-timeline" style="display:none"></div>

        <div class="log-pager">
            <button class="log-btn" id="log-prev">«</button>
            <span class="pager__label" id="log-page">Pagina 1 di 1</span>
            <button class="log-btn" id="log-next">»</button>
        </div>
    </section>
</section>

<!-- ======= MODALE STILE DASHBOARD: Dettagli Segnalazione ======= -->
<div class="c-modal hidden" id="modal-gen-info" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true" style="max-width:48rem">
        <button type="button" class="c-modal__close" data-close-modal>✕</button>
        <h3 class="mb-2 text-lg font-semibold">Dettagli segnalazione</h3>
        <div id="gen-info-body" class="grid gap-3"></div>
        <div class="flex justify-end mt-3 gap-2">
            <button type="button" class="btn" data-close-modal>Chiudi</button>
            <button type="button" class="btn btn-primary" id="gen-info-copy">Copia JSON</button>
        </div>
    </div>
</div>

<script type="module">
    /* ===== Helpers & Icons ===== */
    const $ = s => document.querySelector(s);
    const $$ = s => Array.from(document.querySelectorAll(s));

    function icon(name, cls = 'hi') {
        const m = {
            clock: '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 0 0118 0z"/>',
            inbox: '<path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0h-3.586a1 1 0 00-.707.293l-1.414 1.414a2 2 0 01-1.414.586h-2a2 2 0 01-1.414-.586L7.293 13.293A1 1 0 006.586 13H3m17 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5"/>',
            check: '<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>',
            tag: '<path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M3 10l7.586-7.586a2 2 0 012.828 0L21 10l-7 7-8-7z"/>',
            chat: '<path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5m7 1a2 2 0 01-2 2H8l-4 4V6a2 2 0 012-2h12a2 2 0 012 2v9z"/>',
            docArrow: '<path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5V3m0 0l-3 3m3-3l3 3M6 13.5a3 3 0 013-3h6a3 3 0 013 3V18a3 3 0 01-3 3H9a3 3 0 01-3-3v-4.5z"/>',
            information: '<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25h1.5v5.25h-1.5zM12 7.5h.008v.008H12V7.5z"/>'
        };
        return `<svg class="${cls}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">${m[name]||''}</svg>`;
    }

    const PAGE_SIZE = 10;
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

    /* ===== STATI (mappa UI ↔ Backend) ===== */
    const BACKEND_STATUS = {
        open: 'aperta',
        work: 'in_lavorazione',
        closed: 'chiusa'
    };

    function normStatus(s) {
        const v = (s || '').toLowerCase();
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
        segnalazione(id) {
            return this._req(`/segnalazioni/${id}`);
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
        async getNotes(id, page = 1, per_page = 50) {
            const res = await this._req(`/segnalazioni/${id}/notes?page=${page}&per_page=${per_page}`);
            return normalizeNotesResponse(res);
        },
        logs(params) {
            const sp = new URLSearchParams(Object.entries(params || {}).filter(([, v]) => v != null && v !== ''));
            return this._req(`/logs?${sp.toString()}`);
        },
    };

    function normalizeNotesResponse(res) {
        let items = [],
            meta = {};
        if (Array.isArray(res)) items = res;
        else if (res && typeof res === 'object') {
            if (Array.isArray(res.data)) items = res.data;
            else if (Array.isArray(res.notes)) items = res.notes;
            else if (Array.isArray(res.items)) items = res.items;
            else if (res.note) items = [res.note];
            meta = res.meta || {};
        }
        items = items.map(n => ({
            text: n.text ?? n.body ?? n.content ?? '',
            by: n.by ?? n.user ?? n.author ?? '—',
            at: n.at ?? n.created_at ?? n.createdAt ?? null
        }));
        return {
            data: items,
            meta
        };
    }

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
        },
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
            queue: {
                rows: [],
                meta: {
                    current_page: 1,
                    last_page: 1,
                    total: 0
                }
            },
            work: {
                rows: [],
                meta: {
                    current_page: 1,
                    last_page: 1,
                    total: 0
                }
            },
            closed: {
                rows: [],
                meta: {
                    current_page: 1,
                    last_page: 1,
                    total: 0
                }
            },
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
            },
            view: 'table',
            filters: {
                q: '',
                action: '',
                operator: '',
                segnalazione_id: '',
                from: '',
                to: ''
            }
        },
        ui: {
            genInfoJson: null
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
    <span class="legend__item" data-type="${t}"><i class="legend__dot" aria-hidden="true"></i>${TYPE_LABELS[t]}</span>`).join('');
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
            <span class="legend__item tip-badge">
              <i class="legend__dot" aria-hidden="true"></i>${TYPE_LABELS[g.tipologia]||g.tipologia||'Altro'}
            </span>
            ${g.operatore?`<span class="muted">• Operatore: ${g.operatore}</span>`:''}
          </div>
          ${g.instructions?`<div class="instructions" style="margin-top:.75rem">${icon('information')} <strong>Indicazioni operative:</strong> ${g.instructions}</div>`:''}
          ${g.sintesi?`<div class="note" style="margin-top:.75rem">${icon('chat')} ${g.sintesi}</div>`:''}
          ${lastNote?`<div class="note" style="margin-top:.55rem" data-last-note="${g.id}">
              ${icon('chat')} <strong>Ultima nota:</strong> <span data-last-note-text>${lastNote.text}</span>
              <span class="muted">(<span data-last-note-by>${lastNote.by}</span>, <span data-last-note-at>${FMT(lastNote.at)}</span>)</span>
          </div>`:`<div class="note" style="margin-top:.55rem; display:none" data-last-note="${g.id}"></div>`}

          <div class="note" style="margin-top:.75rem; display:none" data-note-panel="${g.id}">
            <div class="muted" style="margin-bottom:.35rem">${icon('chat')} Tutte le note</div>
            <div data-note-list="${g.id}"><span class="muted">Carico…</span></div>
          </div>
        </div>
        <div>
          <div class="muted" style="margin-bottom:.3rem">${icon('information','hi')} Aree interessate</div>
          <div>${areas!=='—'?areas.split(',').map(a=>`<span class="tag">${a.trim()}</span>`).join(' '):'—'}</div>
        </div>
      </div>
    </div>
    <div class="card__footer" data-id="${g.id}">
      <span class="muted" style="margin-right:auto">${icon('information')} Azioni</span>
      <!-- (qui i bottoni card non sono richiesti per la richiesta attuale) -->
      <button class="btn" data-act="note" data-id="${g.id}">📝 Aggiungi nota…</button>
      ${footerActions(state.role, g.status, g.id, g.assigned_to)}
    </div>`;
        el.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('text/id', g.id);
            e.dataTransfer.setData('text/status', g.status);
        });
        return el;
    }

    function footerActions(role, status, id, assignedTo) {
        const noteButtons = ``; // nella card lasciamo solo "Aggiungi nota…"
        if (status === 'queue') {
            if (!canAssign(role)) return `<span class="muted">In attesa di smistamento…</span>${noteButtons}`;
            return assignableRoles().map(rr => `
      <button class="btn" data-act="assign" data-to="${rr.slug}" data-id="${id}">${icon('docArrow')} ${rr.label}</button>
    `).join('') + noteButtons;
        }
        if (status === 'assigned') {
            const canManage = (role === assignedTo) || canClose(role) || role === 'coordinamento';
            return `${noteButtons}<span class="k-sep"></span>${canManage?`<button class="btn btn-primary" data-act="close" data-id="${id}">${icon('check')} Chiudi</button>`:''}`;
        }
        return noteButtons;
    }

    /* ===== Section & Render ===== */
    function section(title, kind, payload) {
        const rows = payload.rows || [];
        const meta = payload.meta || {
            current_page: 1,
            last_page: 1,
            total: rows.length
        };
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
      <div class="sec__meta">${meta.total??rows.length} elementi totali</div>
    </div>
    <div class="list" data-kind="${kind}">
      ${rows.length?'':`<div class="empty">Nessuna voce.</div>`}
    </div>
    <div class="pager" data-kind="${kind}">
      <button class="btn" data-pg="prev" ${meta.current_page<=1?'disabled':''}>«</button>
      <span class="pager__label">Pagina ${meta.current_page} di ${meta.last_page}</span>
      <button class="btn" data-pg="next" ${meta.current_page>=meta.last_page?'disabled':''}>»</button>
    </div>`;
        const list = sec.querySelector('.list');
        rows.forEach(r => list.appendChild(card(r)));

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
                btn.addEventListener('click', async () => {
                    const meta = state.lists[kind]?.meta || {
                        current_page: 1,
                        last_page: 1
                    };
                    if (btn.dataset.pg === 'prev') state.pages[kind] = Math.max(1, (meta.current_page || 1) - 1);
                    if (btn.dataset.pg === 'next') state.pages[kind] = Math.min(meta.last_page || 1, (meta.current_page || 1) + 1);
                    await reloadData(kind);
                });
            });
        });
    }

    function render() {
        renderLegend();
        state.counts = {
            queue: state.lists.queue.meta?.total ?? state.lists.queue.rows.length,
            work: state.lists.work.meta?.total ?? state.lists.work.rows.length,
            closed: state.lists.closed.meta?.total ?? state.lists.closed.rows.length,
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

    /* ===== Toast & Confirms ===== */
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

    /* ===== NOTE modal con SweetAlert ===== */
    async function openNoteSwal(id) {
        if (!window.Swal) {
            alert('SweetAlert non trovato');
            return;
        }
        const {
            value,
            isConfirmed
        } = await Swal.fire({
            title: 'Aggiungi nota',
            input: 'textarea',
            inputLabel: 'Nota',
            inputPlaceholder: 'Scrivi qui…',
            inputAttributes: {
                'aria-label': 'Nota',
                maxlength: '5000'
            },
            showCancelButton: true,
            confirmButtonText: 'Salva',
            cancelButtonText: 'Annulla',
            confirmButtonColor: '#2563eb',
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: (val) => {
                if (!val || !val.trim()) {
                    Swal.showValidationMessage('La nota è obbligatoria.');
                    return false
                }
                return val.trim();
            }
        });
        if (!isConfirmed) return;
        await API.addNote(id, value.trim());
        toastOK('Nota aggiunta');
        // refresh liste coerenti
        const cardEl = document.querySelector(`.card[data-id="${CSS.escape(String(id))}"]`);
        const status = cardEl?.dataset.status || 'assigned';
        const listKey = (status === 'queue') ? 'queue' : (status === 'assigned' ? 'work' : 'closed');
        await reloadData(listKey);
    }

    /* ===== MODALE: tutte le note (per bottone nella tabella log) ===== */
    async function loadAllNotesFor(id) {
        const out = [];
        let page = 1,
            per_page = 100,
            last = 1;
        do {
            const {
                data,
                meta
            } = await API.getNotes(id, page, per_page);
            out.push(...(data || []));
            last = meta?.last_page ?? page;
            page++;
        } while (page <= last);
        return out;
    }

    function htmlNotesList(notes) {
        if (!notes.length) return `<div class="log-muted">Nessuna nota.</div>`;
        return notes.map(n => `
    <div style="border:1px solid var(--line); border-radius:.6rem; padding:.55rem .65rem; margin:.5rem 0; background:#fff">
      <div style="display:flex; gap:.5rem; align-items:center; margin-bottom:.25rem">
        ${icon('chat','hi')}
        <strong>${n.by || '—'}</strong>
        <span class="log-muted">• ${n.at?FMT(n.at):''}</span>
      </div>
      <div class="log-note">${(n.text||'').replace(/\n/g,'<br>')}</div>
    </div>`).join('');
    }
    async function openNotesModal(id) {
        if (!window.Swal) {
            alert('SweetAlert non trovato');
            return;
        }
        const content = document.createElement('div');
        content.innerHTML = `<div class="log-muted" style="padding:.25rem 0">Carico le note…</div>`;
        Swal.fire({
            title: `Note segnalazione GEN-${id}`,
            html: content,
            showConfirmButton: true,
            confirmButtonText: 'Chiudi',
            width: 800,
            focusConfirm: false,
        });
        try {
            const notes = await loadAllNotesFor(id);
            content.innerHTML = `<div style="max-height:58vh; overflow:auto; text-align:left">${htmlNotesList(notes)}</div>`;
        } catch (e) {
            content.innerHTML = `<div class="log-muted">Impossibile caricare le note.</div>`;
        }
    }

    /* ===== Drag&Drop, handler vari ===== */
    async function handleDropAction(id, srcStatus, target) {
        try {
            if (srcStatus === 'queue' && assignableRoles().some(r => r.slug === target)) {
                const {
                    confirmed,
                    text
                } = await promptInstructions();
                if (!confirmed) return;
                await API.assign(id, target, text || null);
                toastOK('Segnalazione smistata', `Assegnata a ${labelRole(target)}`);
                await Promise.all([reloadData('queue'), reloadData('work')]);
                return;
            }
            if (srcStatus === 'assigned' && target === 'close' && canClose(state.role)) {
                await API.close(id);
                toastOK('Segnalazione chiusa');
                await Promise.all([reloadData('work'), reloadData('closed')]);
                return;
            }
            toastInfo('Operazione non permessa');
        } catch (e) {
            console.error(e);
            toastInfo('Errore backend');
        }
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
                toastOK('Segnalazione smistata', `Assegnata a ${labelRole(to)}`);
                await Promise.all([reloadData('queue'), reloadData('work')]);
            });
        });
        root.querySelectorAll('[data-act="note"]').forEach(b => {
            b.addEventListener('click', () => openNoteSwal(b.dataset.id));
        });
        root.querySelectorAll('[data-act="close"]').forEach(b => {
            b.addEventListener('click', async () => {
                const id = +b.dataset.id;
                const c = await askConfirm('Chiudere la segnalazione?', 'Potrai comunque aggiungere note.');
                if (!c.isConfirmed) return;
                await API.close(id);
                toastOK('Segnalazione chiusa');
                await Promise.all([reloadData('work'), reloadData('closed')]);
            });
        });
    }

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
            state.pages.queue = state.pages.work = state.pages.closed = 1;
            await loadData();
            render();
            if (state.role === 'coordinamento') {
                $('#coord-log').style.display = '';
                await loadLogs();
                startLogsLive();
            } else {
                $('#coord-log').style.display = 'none';
                stopLogsLive();
            }
        });
    }
    async function loadList(kind) {
        const params = {
            page: state.pages[kind] || 1,
            per_page: PAGE_SIZE
        };
        if (kind === 'queue') params.status = toBackendStatus('queue');
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
        const meta = res.meta || {
            current_page: params.page,
            last_page: 1,
            total: rows.length
        };
        return {
            rows: rows.map(mapSeg),
            meta
        };
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
                queue: {
                    rows: [],
                    meta: {
                        current_page: 1,
                        last_page: 1,
                        total: 0
                    }
                },
                work: {
                    rows: [],
                    meta: {
                        current_page: 1,
                        last_page: 1,
                        total: 0
                    }
                },
                closed: {
                    rows: [],
                    meta: {
                        current_page: 1,
                        last_page: 1,
                        total: 0
                    }
                }
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

    /* ===== LOGS ===== */
    const LOG_PAGE_SIZE = 12;
    const LOG_VIEW = {
        TABLE: 'table',
        TIMELINE: 'timeline'
    };

    /* ——— Helpers per “Da → A” e per NOTE ——— */
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

    function formatTransition(fromStatus, toStatus, fromAssignee, toAssignee, action) {
        const a = (action || '').toLowerCase();
        if (a === 'note') {
            return `<em class="log-muted">Inserita una nuova nota</em>`;
        }
        const fromHTML = `
    <span class="chip chip--from">
      <strong>da</strong>
      <span class="${statusClass(fromStatus)}">${labelStatus(fromStatus)}</span>
      ${fromAssignee?`<span class="log-muted">• ${fromAssignee}</span>`:''}
    </span>`;
        const toHTML = `
    <span class="chip chip--to">
      <strong>a</strong>
      <span class="${statusClass(toStatus)}">${labelStatus(toStatus)}</span>
      ${toAssignee?`<span class="log-muted">• ${toAssignee}</span>`:''}
    </span>`;
        return `<div class="flow">${fromHTML}<span class="arrow">→</span>${toHTML}</div>`;
    }

    /* Badge azione */
    function actBadge(a) {
        const t = (a || '').toLowerCase();
        const tag = (txt, cls = '') => `<span class="badge ${cls}">${txt}</span>`;
        if (t === 'assign') return tag('Assegnazione', 'badge-assign');
        if (t === 'close') return tag('Chiusura', 'badge-close');
        if (t === 'note') return tag('Nota', 'badge-note');
        return tag(a || '—');
    }
    const FMT_LOG = (iso) => new Intl.DateTimeFormat('it-IT', {
        dateStyle: 'short',
        timeStyle: 'short'
    }).format(new Date(iso || Date.now()));

    /* Tabella log */
    function renderLogsTable() {
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
            tr.innerHTML = `<td colspan="6" class="px-3 py-3 log-muted">Nessun log.</td>`;
            tbody.appendChild(tr);
            return;
        }
        rows.forEach(l => {
            const tr = document.createElement('tr');
            tr.className = 'log-row';
            tr.setAttribute('data-action', (l.action || l.type || '').toLowerCase());

            const when = FMT_LOG(l.created_at || l.at);
            const action = l.action || l.type || '—';
            const segId = l.segnalazione_id ? String(l.segnalazione_id) : '';
            const segBtn = segId ? `<button class="btn btn-xs" data-open-seg="${segId}" title="Apri dettaglio">GEN-${segId}</button>` : '—';
            const chainHTML = formatTransition(l.from_status || l.from, l.to_status || l.to, l.from_assignee, l.to_assignee, action);
            const operator = l.performed_by || l.operator || l.by || l.user || '—';
            const notaTxt = l.details || l.note || '';

            /* ——— NUOVO: pulsante "i" nella colonna Nota che apre la modale con TUTTE le note della segnalazione ——— */
            const notesBtn = segId ? `<button class="btn btn-icon" data-notes-for="${segId}" title="Tutte le note">${icon('information','hi')}</button>` : '';

            tr.innerHTML = `
      <td>${when}</td>
      <td>${actBadge(action)}</td>
      <td>${segBtn}</td>
      <td>${chainHTML}</td>
      <td>${operator}</td>
      <td class="log-note">${notesBtn}${notaTxt?` <span>${(notaTxt||'').replace(/\n/g,'<br>')}</span>`:''}</td>`;
            tbody.appendChild(tr);
        });
    }

    /* Timeline log */
    function renderLogsTimeline() {
        const wrap = $('#log-timeline');
        wrap.replaceChildren();
        const rows = state.logs.data;
        if (!rows.length) {
            const empty = document.createElement('div');
            empty.className = 'log-muted';
            empty.textContent = 'Nessun log.';
            wrap.appendChild(empty);
            return;
        }
        rows.forEach(l => {
            const it = document.createElement('div');
            it.className = 't-item';
            it.setAttribute('data-action', (l.action || l.type || '').toLowerCase());
            const when = FMT_LOG(l.created_at || l.at);
            const action = l.action || l.type || '—';
            const segId = l.segnalazione_id ? `GEN-${l.segnalazione_id}` : '—';
            const operator = l.performed_by || l.operator || l.by || l.user || '—';
            const chainHTML = formatTransition(l.from_status || l.from, l.to_status || l.to, l.from_assignee, l.to_assignee, action);
            const nota = l.details || l.note || '';
            it.innerHTML = `
      <span class="t-dot" aria-hidden="true"></span>
      <div class="t-meta">
        <strong>${when}</strong>
        <span>${actBadge(action)}</span>
        <span class="log-muted">${segId}</span>
        <span class="log-muted">${operator}</span>
      </div>
      <div class="t-note">
        <div style="margin-bottom:.35rem">${chainHTML}</div>
        <div class="log-note">${(nota||'').replace(/\n/g,'<br>')}</div>
      </div>`;
            wrap.appendChild(it);
        });
    }

    /* Render & load logs */
    function renderLogs() {
        const isTable = state.logs.view === LOG_VIEW.TABLE;
        $('#log-table-wrap').style.display = isTable ? '' : 'none';
        $('#log-timeline').style.display = isTable ? 'none' : '';
        $('#log-view-table').classList.toggle('log-btn--primary', isTable);
        $('#log-view-timeline').classList.toggle('log-btn--primary', !isTable);
        if (isTable) renderLogsTable();
        else renderLogsTimeline();
    }
    async function loadLogs() {
        try {
            const f = state.logs.filters;
            const params = {
                page: state.pages.log || 1,
                per_page: LOG_PAGE_SIZE,
                q: f.q || undefined,
                action: f.action || undefined,
                operator: f.operator || undefined,
                segnalazione_id: f.segnalazione_id || undefined,
                from: f.from || undefined,
                to: f.to || undefined
            };
            const res = await API.logs(params);
            const data = Array.isArray(res) ? res : (res.data || []);
            state.logs.data = data;
            state.logs.meta = res.meta || {
                current_page: params.page,
                last_page: 1,
                total: data.length
            };
            renderLogs();
        } catch (e) {
            console.error('logs', e);
            state.logs.data = [];
            state.logs.meta = {
                current_page: 1,
                last_page: 1,
                total: 0
            };
            renderLogs();
        }
    }

    function debounce(fn, ms = 350) {
        let t;
        return (...a) => {
            clearTimeout(t);
            t = setTimeout(() => fn(...a), ms);
        };
    }

    function bindLogToolbar() {
        const f = state.logs.filters;
        const Q = $('#log-q'),
            A = $('#log-action'),
            OP = $('#log-operator'),
            SID = $('#log-sid'),
            F = $('#log-from'),
            T = $('#log-to');
        const onChange = debounce(async () => {
            f.q = (Q.value || '').trim();
            f.action = A.value || '';
            f.operator = (OP.value || '').trim();
            f.segnalazione_id = (SID.value || '').trim();
            f.from = F.value || '';
            f.to = T.value || '';
            state.pages.log = 1;
            await loadLogs();
        }, 250);
        [Q, A, OP, SID, F, T].forEach(el => el.addEventListener('input', onChange));
        $('#log-reset').addEventListener('click', async () => {
            Q.value = A.value = OP.value = SID.value = F.value = T.value = '';
            Object.assign(f, {
                q: '',
                action: '',
                operator: '',
                segnalazione_id: '',
                from: '',
                to: ''
            });
            state.pages.log = 1;
            await loadLogs();
        });
        $('#log-view-table').addEventListener('click', () => {
            state.logs.view = LOG_VIEW.TABLE;
            renderLogs();
        });
        $('#log-view-timeline').addEventListener('click', () => {
            state.logs.view = LOG_VIEW.TIMELINE;
            renderLogs();
        });
        $('#log-export').addEventListener('click', () => exportLogsCSV());
        $('#log-prev')?.addEventListener('click', async () => {
            state.pages.log = Math.max(1, (state.pages.log || 1) - 1);
            await loadLogs();
        });
        $('#log-next')?.addEventListener('click', async () => {
            state.pages.log = (state.pages.log || 1) + 1;
            await loadLogs();
        });
    }

    /* --- Delegated handlers per LOG TABLE --- */
    document.getElementById('coord-log')?.addEventListener('click', async (e) => {
        // Apri dettaglio segnalazione
        const b1 = e.target.closest('[data-open-seg]');
        if (b1) {
            const id = b1.getAttribute('data-open-seg');
            try {
                const rec = await fetchSegnalazioneWithFallback(id);
                renderGenInfoModal(rec);
            } catch (err) {
                console.error(err);
                toastInfo('Dettaglio non disponibile', 'Impossibile caricare la segnalazione.');
            }
            return;
        }
        // NUOVO: bottone "i" nella colonna NOTE
        const b2 = e.target.closest('[data-notes-for]');
        if (b2) {
            const segId = b2.getAttribute('data-notes-for');
            openNotesModal(segId);
        }
    });

    /* ===== CSV Export ===== */
    function exportLogsCSV() {
        const rows = state.logs.data;
        const hdr = ['data_ora', 'azione', 'segnalazione', 'from_status', 'to_status', 'from_assignee', 'to_assignee', 'operatore', 'nota'];
        const esc = s => `"${String(s??'').replace(/"/g,'""')}"`;
        const csv = [hdr.join(';')]
            .concat(rows.map(l => [
                FMT_LOG(l.created_at || l.at),
                (l.action || l.type || ''),
                l.segnalazione_id ? `GEN-${l.segnalazione_id}` : '',
                (l.from_status || ''),
                (l.to_status || ''),
                (l.from_assignee || ''),
                (l.to_assignee || ''),
                (l.performed_by || l.operator || l.by || l.user || ''),
                (l.details || l.note || '')
            ].map(esc).join(';'))).join('\r\n');
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

    /* ===== Logs LIVE (polling) ===== */
    let _logTimer = null;
    const LOG_POLL_MS = 3000;

    function startLogsLive() {
        stopLogsLive();
        loadLogs().catch(console.error);
        _logTimer = setInterval(() => {
            if (state.role === 'coordinamento') loadLogs().catch(console.error);
        }, LOG_POLL_MS);
    }

    function stopLogsLive() {
        if (_logTimer) {
            clearInterval(_logTimer);
            _logTimer = null;
        }
    }
    window.addEventListener('beforeunload', stopLogsLive);

    /* ===== MODALE GEN INFO (stile Dashboard) ===== */
    function makePrioBadge(p = 'Nessuna') {
        const s = document.createElement('span');
        s.className = 'prio-badge ' + (p.toLowerCase() === 'alta' ? 'prio--alta' : p.toLowerCase() === 'media' ? 'prio--media' : p.toLowerCase() === 'bassa' ? 'prio--bassa' : 'prio--nessuna');
        s.textContent = p || 'Nessuna';
        return s;
    }

    function makeDirBadge(val) {
        const v = (val || 'E').toString().trim().toUpperCase();
        const isIn = v === 'E' || v.startsWith('E');
        const s = document.createElement('span');
        s.className = 'badge ' + (isIn ? 'badge--in' : 'badge--out');
        s.textContent = isIn ? 'E' : 'U';
        s.title = isIn ? 'Entrata' : 'Uscita';
        return s;
    }

    function openModal(sel) {
        const m = document.querySelector(sel);
        if (!m) return;
        m.classList.remove('hidden');
        m.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(el) {
        if (!el) return;
        el.classList.remove('is-open');
        el.classList.add('hidden');
        if (!document.querySelector('.c-modal.is-open')) document.body.style.overflow = '';
    }
    document.addEventListener('click', (e) => {
        if (e.target.closest('[data-close-modal]') || e.target.classList.contains('c-modal__backdrop')) closeModal(e.target.closest('.c-modal'));
    });

    function genInfoRows(rec) {
        const typeLabel = TYPE_LABELS[rec.tipologia] || rec.tipologia || '—';
        const when = FMT(rec.created_at);
        const evText = rec.event_id ? `Evento #${rec.event_id}` : '—';
        return [
            ['ID', `GEN-${rec.id}`],
            ['Data/Ora', when],
            ['Direzione', rec.direzione === 'U' ? 'Uscita (U)' : 'Entrata (E)'],
            ['Tipologia', typeLabel],
            ['Aree interessate', (rec.aree || []).join(', ') || '—'],
            ['Operatore', rec.operatore || '—'],
            ['Priorità', rec.priorita || 'Nessuna'],
            ['Evento associato', evText],
            ['Sintesi', rec.sintesi || '—'],
        ];
    }

    function renderGenInfoModal(rec) {
        const body = document.querySelector('#gen-info-body');
        if (!body) return;
        const rows = genInfoRows(rec);
        const tbl = document.createElement('table');
        tbl.className = 'w-full text-sm';
        tbl.innerHTML = `<tbody>${rows.map(([k,v])=>`<tr class="border-t" style="border-color:var(--line)"><td class="px-3 py-2 font-semibold w-44">${k}</td><td class="px-3 py-2">${v}</td></tr>`).join('')}</tbody>`;
        body.replaceChildren(tbl);
        const tds = body.querySelectorAll('tbody tr td:nth-child(2)');
        if (tds[2]) {
            tds[2].textContent = '';
            tds[2].appendChild(makeDirBadge(rec.direzione));
        }
        if (tds[6]) {
            tds[6].textContent = '';
            tds[6].appendChild(makePrioBadge(rec.priorita || 'Nessuna'));
        }
        state.ui.genInfoJson = {
            id: rec.id,
            created_at: rec.created_at,
            direzione: rec.direzione,
            tipologia: rec.tipologia,
            tipologia_label: TYPE_LABELS[rec.tipologia] || rec.tipologia || null,
            aree: rec.aree || [],
            operatore: rec.operatore || null,
            priorita: rec.priorita || 'Nessuna',
            event_id: rec.event_id || null,
            sintesi: rec.sintesi || ''
        };
        openModal('#modal-gen-info');
    }
    document.addEventListener('click', (e) => {
        if (e.target.id === 'gen-info-copy' || e.target.closest('#gen-info-copy')) {
            const data = state.ui.genInfoJson ?? {};
            const text = JSON.stringify(data, null, 2);
            if (navigator.clipboard?.writeText) {
                navigator.clipboard.writeText(text).catch(() => fallbackCopy(text));
            } else fallbackCopy(text);
        }
    });

    function fallbackCopy(text) {
        try {
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.style.position = 'fixed';
            ta.style.left = '-9999px';
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
        } catch {}
    }
    async function fetchSegnalazioneWithFallback(id) {
        try {
            const res = await API.segnalazione(id);
            if (res) {
                const s = Array.isArray(res?.data) ? res.data[0] : (res?.data || res);
                return {
                    id: s.id,
                    created_at: s.creata_il || s.created_at || s.createdAt || new Date().toISOString(),
                    tipologia: s.tipologia || s.tipo || 'altro',
                    aree: s.aree || [],
                    sintesi: s.sintesi || s.note || s.descrizione || s.oggetto || '',
                    operatore: s.operatore || s.user || '',
                    direzione: ((s.direzione || s.verso || 'E') + '').toUpperCase().startsWith('U') ? 'U' : 'E',
                    priorita: s.priorita || 'Nessuna',
                    event_id: s.event_id ?? s.evento_id ?? null
                };
            }
        } catch (e) {}
        const hit = ['queue', 'work', 'closed'].flatMap(k => state.lists[k]?.rows || []).find(r => String(r.id) === String(id));
        if (hit) {
            return {
                id: hit.id,
                created_at: hit.created_at,
                tipologia: hit.tipologia,
                aree: hit.aree,
                sintesi: hit.sintesi,
                operatore: hit.operatore,
                direzione: 'E',
                priorita: 'Nessuna',
                event_id: hit.event_id ?? null
            };
        }
        throw new Error('Segnalazione non trovata');
    }

    /* ===== Boot ===== */
    function renderLegendInit() {
        renderLegend();
    }
    async function boot() {
        renderLegendInit();
        await loadRoles();
        await loadData();
        render();
        if (state.role === 'coordinamento') {
            $('#coord-log').style.display = '';
            bindLogToolbar();
            await loadLogs();
            startLogsLive();
        }
    }
    $('#debug-retry').addEventListener('click', boot);
    boot();
</script>