@php
use Illuminate\Support\Str;
@endphp

<x-layout title="Gestione utenti">
    <div class="max-w-6xl mx-auto py-8 px-4 space-y-6">

        @if(session('status'))
        <div class="rounded-md bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800">
            {{ session('status') }}
        </div>
        @endif

        {{-- Header pagina --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Pannello amministratore</h1>
                <p class="text-sm text-slate-600">
                    Gestione account utenti, ruoli, abilitazioni e log di attività.
                </p>
            </div>
        </div>

        {{-- PANORAMICA / STATISTICHE --}}
        <section class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm px-4 py-3">
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Utenti totali</p>
                <p class="mt-1 text-2xl font-semibold text-slate-900">
                    {{ $totalUsers }}
                </p>
                <p class="mt-1 text-xs text-slate-500">
                    Tutti gli account registrati sulla piattaforma.
                </p>
            </div>

            <div class="rounded-2xl border border-emerald-200 bg-emerald-50/60 shadow-sm px-4 py-3">
                <p class="text-xs font-medium uppercase tracking-wide text-emerald-700">Utenti abilitati</p>
                <p class="mt-1 text-2xl font-semibold text-emerald-900">
                    {{ $totalActive }}
                </p>
                <p class="mt-1 text-xs text-emerald-800/80">
                    Possono accedere ai servizi dopo login.
                </p>
            </div>

            <div class="rounded-2xl border border-amber-200 bg-amber-50/60 shadow-sm px-4 py-3">
                <p class="text-xs font-medium uppercase tracking-wide text-amber-700">In attesa di abilitazione</p>
                <p class="mt-1 text-2xl font-semibold text-amber-900">
                    {{ $totalPending }}
                </p>
                <p class="mt-1 text-xs text-amber-800/80">
                    Utenti registrati ma non ancora attivati.
                </p>
            </div>

            <div class="rounded-2xl border border-sky-200 bg-sky-50/60 shadow-sm px-4 py-3">
                <p class="text-xs font-medium uppercase tracking-wide text-sky-700">Log attività</p>
                <p class="mt-1 text-2xl font-semibold text-sky-900">
                    {{ $totalLogs ?? 0 }}
                </p>
                <p class="mt-1 text-xs text-sky-800/80">
                    Operazioni registrate sul sistema.
                </p>
            </div>
        </section>

        {{-- PANNELLO UNICO CON TAB --}}
        <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            {{-- Tabs --}}
            <div class="border-b border-slate-200 px-4 pt-3">
                <div class="flex flex-wrap gap-2">
                    {{-- TAB: Utenti da abilitare --}}
                    <a href="{{ route('admin.users.index', ['tab' => 'pending']) }}"
                        class="inline-flex items-center gap-2 px-3 py-2 text-sm rounded-t-xl border-b-2
                              {{ $tab === 'pending'
                                    ? 'border-amber-500 text-amber-700 bg-amber-50/60'
                                    : 'border-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                        <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                        <span>Utenti da abilitare</span>
                        <span class="text-xs rounded-full bg-amber-100 px-2 py-0.5 text-amber-800 border border-amber-200">
                            {{ $totalPending }}
                        </span>
                    </a>

                    {{-- TAB: Tutti gli utenti --}}
                    <a href="{{ route('admin.users.index', ['tab' => 'all']) }}"
                        class="inline-flex items-center gap-2 px-3 py-2 text-sm rounded-t-xl border-b-2
                              {{ $tab === 'all'
                                    ? 'border-sky-500 text-sky-700 bg-sky-50/60'
                                    : 'border-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                        <x-heroicon-o-users class="h-4 w-4" />
                        <span>Tutti gli utenti</span>
                        <span class="text-xs rounded-full bg-sky-100 px-2 py-0.5 text-sky-800 border border-sky-200">
                            {{ $totalUsers }}
                        </span>
                    </a>

                    {{-- TAB: Log attività --}}
                    <a href="{{ route('admin.users.index', ['tab' => 'logs']) }}"
                        class="inline-flex items-center gap-2 px-3 py-2 text-sm rounded-t-xl border-b-2
                              {{ $tab === 'logs'
                                    ? 'border-indigo-500 text-indigo-700 bg-indigo-50/60'
                                    : 'border-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                        <x-heroicon-o-clipboard-document-list class="h-4 w-4" />
                        <span>Log attività</span>
                        <span class="text-xs rounded-full bg-indigo-100 px-2 py-0.5 text-indigo-800 border border-indigo-200">
                            {{ $totalLogs ?? 0 }}
                        </span>
                    </a>
                </div>
            </div>

            {{-- Contenuto tab --}}
            <div class="p-4">

                {{-- TAB LOG ATTIVITÀ --}}
                @if($tab === 'logs')

                <p class="mb-3 text-xs text-slate-500">
                    Elenco di tutte le operazioni registrate nel sistema (creazioni, modifiche, cancellazioni, aggiornamenti DB, ecc.).
                </p>

                @if(empty($logs) || $logs->isEmpty())
                <p class="text-sm text-slate-500">Nessun log disponibile.</p>
                @else
                <section class="log-sec">
                    {{-- Head --}}
                    <div class="log-head">
                        <h2 class="log-title">Log attività</h2>
                        <div class="log-meta">
                            Mostro {{ $logs->firstItem() }}–{{ $logs->lastItem() }} di {{ $logs->total() }} record
                        </div>
                    </div>

                    {{-- TOOLBAR FILTRI --}}
                    <form method="GET" action="{{ route('admin.users.index') }}" class="log-toolbar">
                        {{-- mantengo la tab attiva --}}
                        <input type="hidden" name="tab" value="logs">

                        {{-- Azione --}}
                        <div class="log-field">
                            <div class="lbl">Azione</div>
                            <select name="log_action" class="log-select">
                                <option value="all" {{ ($filterAction ?? 'all') === 'all' ? 'selected' : '' }}>Tutte</option>
                                <option value="create" {{ ($filterAction ?? '') === 'create' ? 'selected' : '' }}>Create</option>
                                <option value="update" {{ ($filterAction ?? '') === 'update' ? 'selected' : '' }}>Update</option>
                                <option value="delete" {{ ($filterAction ?? '') === 'delete' ? 'selected' : '' }}>Delete</option>
                                <option value="approve" {{ ($filterAction ?? '') === 'approve' ? 'selected' : '' }}>Approve</option>
                                <option value="deactivate" {{ ($filterAction ?? '') === 'deactivate' ? 'selected' : '' }}>Deactivate</option>
                                <option value="assign" {{ ($filterAction ?? '') === 'assign' ? 'selected' : '' }}>Assign</option>
                                <option value="close" {{ ($filterAction ?? '') === 'close' ? 'selected' : '' }}>Close</option>
                                <option value="other" {{ ($filterAction ?? '') === 'other' ? 'selected' : '' }}>Altro</option>
                            </select>
                        </div>

                        {{-- Utente --}}
                        <div class="log-field">
                            <div class="lbl">Utente (nome o email)</div>
                            <input
                                type="text"
                                name="log_user"
                                class="log-input"
                                placeholder="Es. Rossi o nome@email.it"
                                value="{{ $filterUser ?? '' }}">
                        </div>

                        {{-- Testo / descrizione --}}
                        <div class="log-field">
                            <div class="lbl">Testo descrizione</div>
                            <input
                                type="text"
                                name="log_q"
                                class="log-input"
                                placeholder="Cerca nel dettaglio…"
                                value="{{ $filterText ?? '' }}">
                        </div>

                        {{-- Da --}}
                        <div class="log-field">
                            <div class="lbl">Da (data)</div>
                            <input
                                type="date"
                                name="log_from"
                                class="log-input"
                                value="{{ $filterFrom ?? '' }}">
                        </div>

                        {{-- A --}}
                        <div class="log-field">
                            <div class="lbl">A (data)</div>
                            <input
                                type="date"
                                name="log_to"
                                class="log-input"
                                value="{{ $filterTo ?? '' }}">
                        </div>

                        {{-- Pulsanti --}}
                        <div class="flex items-end gap-2">
                            <button type="submit" class="log-btn log-btn--primary">
                                Applica filtri
                            </button>

                            <a href="{{ route('admin.users.index', ['tab' => 'logs']) }}"
                                class="log-btn">
                                Pulisci
                            </a>
                        </div>
                    </form>

                    {{-- Tabella log --}}
                    <div class="log-wrap">
                        <table class="log-table">
                            <thead>
                                <tr>
                                    <th>Data / ora</th>
                                    <th>Utente</th>
                                    <th>Azione</th>
                                    <th>Tabella / soggetto</th>
                                    <th>Dettaglio</th>
                                    <th>IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                @php
                                $action = $log->action ?? 'other';

                                $badgeClass = 'badge-act--other';
                                $label = strtoupper($action);

                                if (str_starts_with($action, 'db.insert') || $action === 'create' || str_starts_with($action, 'user.create')) {
                                $badgeClass = 'badge-act--create';
                                $label = 'CREATE';
                                } elseif (str_starts_with($action, 'db.update') || $action === 'update' || str_starts_with($action, 'user.update')) {
                                $badgeClass = 'badge-act--update';
                                $label = 'UPDATE';
                                } elseif (str_starts_with($action, 'db.delete') || $action === 'delete') {
                                $badgeClass = 'badge-act--delete';
                                $label = 'DELETE';
                                } elseif (str_contains($action, 'approve') || str_contains($action, 'deactivate') || str_contains($action, 'assign') || str_contains($action, 'close')) {
                                $badgeClass = 'badge-act--assign';
                                $label = strtoupper(str_replace('user.', '', $action));
                                }
                                @endphp

                                <tr class="log-row" data-action="{{ $action }}">
                                    <td class="log-muted whitespace-nowrap">
                                        {{ $log->created_at?->format('d/m/Y H:i:s') ?? '—' }}
                                    </td>
                                    <td class="whitespace-nowrap">
                                        @if($log->user)
                                        {{ $log->user->name }}<br>
                                        <span class="log-muted text-xs">{{ $log->user->email }}</span>
                                        @else
                                        <span class="log-muted text-xs">Sistema / anonimo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge-act {{ $badgeClass }}">
                                            {{ $label }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($log->subject_type)
                                        <div class="text-xs font-mono text-slate-700">
                                            {{ class_basename($log->subject_type) }}
                                            @if($log->subject_id)
                                            #{{ $log->subject_id }}
                                            @endif
                                        </div>
                                        @else
                                        <span class="log-muted text-xs">Query generica</span>
                                        @endif
                                    </td>
                                    <td style="max-width: 420px; text-align: center;">
                                        {{-- Pulsante "i" per aprire i dettagli --}}
                                        <button
                                            type="button"
                                            class="inline-flex items-center justify-center h-7 w-7 rounded-full border border-slate-300 text-[11px] font-semibold text-slate-600 hover:bg-slate-100 hover:border-slate-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-500"
                                            data-log-target="log-detail-{{ $log->id }}"
                                            title="Vedi dettagli">
                                            i
                                        </button>

                                        {{-- Testo completo nascosto, letto dal modal --}}
                                        <div id="log-detail-{{ $log->id }}" class="hidden">
                                            {{ $log->description }}
                                        </div>
                                    </td>
                                    <td class="log-muted text-xs whitespace-nowrap">
                                        {{ $log->ip_address ?? '—' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginatore log --}}
                    <div class="log-pager">
                        {{ $logs->onEachSide(1)->links() }}
                    </div>
                </section>
                @endif

                {{-- TAB UTENTI (PENDING / ALL) --}}
                @else
                {{-- Testo descrittivo tab --}}
                @if($tab === 'pending')
                <p class="mb-3 text-xs text-slate-500">
                    Elenco degli utenti che hanno completato la registrazione ma non sono ancora stati abilitati.
                    Puoi modificare i loro dati e assegnare ruoli prima di abilitarli.
                </p>
                @else
                <p class="mb-3 text-xs text-slate-500">
                    Elenco completo di tutti gli utenti registrati. Puoi modificare dati, ruoli e abilitare/disabilitare gli account.
                </p>
                @endif

                @if(empty($users) || $users->isEmpty())
                <p class="text-sm text-slate-500">Nessun utente trovato.</p>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-3 py-2 text-left">Nome</th>
                                <th class="px-3 py-2 text-left">Email</th>
                                <th class="px-3 py-2 text-left">Ente</th>
                                <th class="px-3 py-2 text-left">Ruoli</th>
                                <th class="px-3 py-2 text-left">Stato</th>
                                <th class="px-3 py-2 text-right">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="border-t border-slate-200">
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $user->email }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $user->organization }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $user->roles->pluck('label')->join(', ') ?: '—' }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    @if($user->is_active)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-800 border border-emerald-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Attivo
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-800 border border-amber-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        Da abilitare
                                    </span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-right space-x-2 whitespace-nowrap">
                                    {{-- Bottone modifica --}}
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="inline-flex items-center rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                        Modifica
                                    </a>

                                    {{-- Abilita / Disabilita --}}
                                    @if(!$user->is_active)
                                    <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="inline-block">
                                        @csrf
                                        <button
                                            class="inline-flex items-center rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700">
                                            Abilita
                                        </button>
                                    </form>
                                    @else
                                    <form method="POST" action="{{ route('admin.users.deactivate', $user) }}" class="inline-block">
                                        @csrf
                                        <button
                                            class="inline-flex items-center rounded-lg bg-rose-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-rose-700">
                                            Disabilita
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Paginazione utenti --}}
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
                @endif
                @endif

            </div>
        </section>

    </div>

    {{-- MODAL DETTAGLI LOG --}}
    <div id="log-detail-modal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 backdrop-blur-sm">
        <div class="mx-4 max-w-xl rounded-2xl bg-white shadow-xl border border-slate-200">
            <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200">
                <h3 class="text-sm font-semibold text-slate-900">
                    Dettaglio log
                </h3>
                <button type="button"
                    class="inline-flex h-7 w-7 items-center justify-center rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-100"
                    data-close-log-modal>
                    ✕
                </button>
            </div>
            <div class="px-4 py-3">
                <pre class="text-[13px] leading-relaxed text-slate-800 whitespace-pre-wrap font-mono"
                    data-log-body></pre>
            </div>
            <div class="flex justify-end px-4 py-3 border-t border-slate-200">
                <button type="button"
                    class="inline-flex items-center rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50"
                    data-close-log-modal>
                    Chiudi
                </button>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const modal = document.getElementById('log-detail-modal');
            if (!modal) return;

            const bodyEl = modal.querySelector('[data-log-body]');
            const closeBtns = modal.querySelectorAll('[data-close-log-modal]');
            const buttons = document.querySelectorAll('[data-log-target]');

            function openModal(text) {
                if (!bodyEl) return;
                bodyEl.textContent = text || '';
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            }

            buttons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetId = btn.getAttribute('data-log-target');
                    if (!targetId) return;
                    const source = document.getElementById(targetId);
                    if (!source) return;
                    const text = source.textContent || source.innerText || '';
                    openModal(text.trim());
                });
            });

            closeBtns.forEach(btn => {
                btn.addEventListener('click', closeModal);
            });

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        })();
    </script>
</x-layout>