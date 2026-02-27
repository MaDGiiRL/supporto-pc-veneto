<section class="sec shadow-card">
    <div class="flex items-center justify-between gap-3 mb-3">
        <div>
            <h3 class="text-sm font-semibold">Studenti</h3>
            <p class="text-xs opacity-70 mt-1">Anagrafica discenti (front pronto a ricerca/filtri).</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="btn-xs">⬇️ Export</button>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-3 mb-3">
        <div class="grid md:grid-cols-4 gap-3">
            <label class="grid gap-1">
                <span class="label">Ricerca</span>
                <input class="input" placeholder="Nome, cognome, CF, email..." />
            </label>
            <label class="grid gap-1">
                <span class="label">Associazione</span>
                <select class="input">
                    <option value="">Tutte</option>
                </select>
            </label>
            <label class="grid gap-1">
                <span class="label">Comune sede associazione</span>
                <input class="input" placeholder="Comune..." />
            </label>
            <label class="grid gap-1">
                <span class="label">Stato iscrizione</span>
                <select class="input">
                    <option value="">Tutti</option>
                    <option>Attivo</option>
                    <option>Non iscritto</option>
                </select>
            </label>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table">
            <thead class="text-left">
                <tr>
                    <th>Studente</th>
                    <th>CF</th>
                    <th>Email</th>
                    <th>Associazione attiva</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-semibold">Mario Rossi</td>
                    <td>RSSMRA...</td>
                    <td>mario@example.it</td>
                    <td><span class="tag">ODV X</span></td>
                    <td>
                        <div class="actions">
                            <button class="btn-xs" data-open-modal="#modal-iscrizione">📌 Iscrivi a corso</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="text-sm opacity-70">Collega al back: GET /api/formazione/studenti</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>