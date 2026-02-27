{{-- resources/views/applicativi/formazione/sections/corsi.blade.php --}}

<section class="sec shadow-card">
    <div class="flex items-center justify-between gap-3 mb-3">
        <div>
            <h3 class="text-sm font-semibold">Corsi terminati</h3>
            <p class="text-xs opacity-70 mt-1">
                Export promossi: include una sola associazione (quella dell’iscrizione al corso) ed esclude chi non risulta più iscritto.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <button class="btn-xs">⬇️ Export corsi</button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table">
            <thead class="text-left">
                <tr>
                    <th>Corso</th>
                    <th>Date</th>
                    <th>Promossi</th>
                    <th>Export</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-semibold">Corso Base PC</td>
                    <td>10/02/2026 → 12/02/2026</td>
                    <td>—</td>
                    <td>
                        <button class="btn-xs">⬇️ Promossi (xlsx)</button>
                    </td>
                    <td>
                        <div class="actions">
                            <button class="btn-xs" data-open-modal="#modal-presenze">🕒 Presenze</button>
                            <button class="btn-xs btn-ghost" data-open-modal="#modal-corso">✏️</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="text-sm opacity-70">
                        Regola back: export promossi “dedup” su (studente, corso) + associazione = quella scelta in iscrizione; escludi studenti non più associati.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<section class="sec shadow-card">
    <div class="flex items-center justify-between gap-3 mb-3">
        <div>
            <h3 class="text-sm font-semibold">Tutti i corsi</h3>
            <p class="text-xs opacity-70 mt-1">Lista completa. Filtri e paginazione predisposti al back.</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="btn-xs" data-open-modal="#modal-corso" title="Crea corso">
                ➕ Nuovo corso
            </button>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-3 mb-3">
        <div class="grid md:grid-cols-4 gap-3">
            <label class="grid gap-1">
                <span class="label">Parola chiave</span>
                <input class="input" placeholder="Titolo / sede / comune..." />
            </label>
            <label class="grid gap-1">
                <span class="label">Stato</span>
                <select class="input">
                    <option value="">Tutti</option>
                    <option>Bozza</option>
                    <option>Aperto</option>
                    <option>In corso</option>
                    <option>Concluso</option>
                </select>
            </label>
            <label class="grid gap-1">
                <span class="label">Dal</span>
                <input class="input" type="date" />
            </label>
            <label class="grid gap-1">
                <span class="label">Al</span>
                <input class="input" type="date" />
            </label>
        </div>
        <div class="flex justify-end mt-3">
            <button class="btn-xs" type="button">Reset</button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table">
            <thead class="text-left">
                <tr>
                    <th>Titolo</th>
                    <th>Date</th>
                    <th>Sede</th>
                    <th>Stato</th>
                    <th class="w-sintesi">Note</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-semibold">Corso Base PC</td>
                    <td>10/02/2026 → 12/02/2026</td>
                    <td>Venezia</td>
                    <td><span class="tag">In corso</span></td>
                    <td class="line-clamp-2">Descrizione breve del corso…</td>
                    <td>
                        <div class="actions">
                            <button class="btn-xs btn-ghost" data-open-modal="#modal-corso">✏️</button>
                            <button class="btn-xs" data-open-modal="#modal-iscrizione">📌 Iscrivi</button>
                            <button class="btn-xs" data-open-modal="#modal-presenze">🕒 Presenze</button>
                            <button class="btn-xs" data-action="toggle-corso" title="Cambia stato">🔁 Stato</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="text-sm opacity-70">Collega al back: GET /api/formazione/corsi</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="pager">
        <button class="btn-xs" disabled>«</button>
        <span class="pager__label">Pagina 1 di 1</span>
        <button class="btn-xs" disabled>»</button>
    </div>
</section>