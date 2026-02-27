<section class="sec shadow-card">
    <div class="flex items-center justify-between gap-3 mb-3">
        <div>
            <h3 class="text-sm font-semibold">Export</h3>
            <p class="text-xs opacity-70 mt-1">
                Export promossi: dedup per studente (una sola associazione = quella dell’iscrizione al corso).
            </p>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-3">
        <div class="grid md:grid-cols-3 gap-3">
            <label class="grid gap-1">
                <span class="label">Corso</span>
                <select class="input">
                    <option value="">Seleziona corso...</option>
                </select>
            </label>
            <div class="flex items-end gap-2">
                <button class="btn btn-primary">⬇️ Export promossi</button>
                <button class="btn">⬇️ Export presenze</button>
            </div>
            <div class="text-xs opacity-70 flex items-end">
                Default: escludi discenti non più iscritti ad associazione (se richiesto dalla regola).
            </div>
        </div>
    </div>
</section>