<section class="sec shadow-card">
    <div class="flex items-center justify-between gap-3 mb-3">
        <div>
            <h3 class="text-sm font-semibold">Distanze</h3>
            <p class="text-xs opacity-70 mt-1">
                Menu dedicato per verificare distanze tra sede associazione (discente/formatore) e sede corso.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <button class="btn-xs">🧭 Calcola</button>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-3">
        <div class="grid md:grid-cols-2 gap-3">
            <label class="grid gap-1">
                <span class="label">Corso</span>
                <select class="input">
                    <option value="">Seleziona corso...</option>
                </select>
            </label>
            <label class="grid gap-1">
                <span class="label">Modalità</span>
                <select class="input">
                    <option value="iscritti">Iscritti → sede corso</option>
                    <option value="formatori">Formatori → sede corso</option>
                </select>
            </label>
        </div>

        <div class="mt-3 text-xs opacity-70">
            Back: calcolo km (Google/OSRM/altro). In lista iscritti visualizza “Distanza (km)” automaticamente.
        </div>
    </div>

    <div class="overflow-x-auto mt-4">
        <table class="table">
            <thead class="text-left">
                <tr>
                    <th>Persona</th>
                    <th>Associazione (sede)</th>
                    <th>Corso (sede)</th>
                    <th>Distanza (km)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Mario Rossi</td>
                    <td>ODV X (Venezia)</td>
                    <td>Corso Base PC (Padova)</td>
                    <td class="font-semibold">—</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-sm opacity-70">Collega al back: GET /api/formazione/distanze?corso_id=...</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>