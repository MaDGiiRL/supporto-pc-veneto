<section class="sec shadow-card">
    <div class="flex items-center justify-between gap-3 mb-3">
        <div>
            <h3 class="text-sm font-semibold">Libretto formativo</h3>
            <p class="text-xs opacity-70 mt-1">
                Predisposto: download attestato digitale (quando definito il formato di produzione nel portale).
            </p>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-3">
        <div class="grid md:grid-cols-3 gap-3">
            <label class="grid gap-1">
                <span class="label">Studente</span>
                <input class="input" placeholder="Cerca studente..." />
            </label>
            <label class="grid gap-1">
                <span class="label">Corso</span>
                <input class="input" placeholder="Filtra corso..." />
            </label>
            <div class="flex items-end gap-2">
                <button class="btn">⬇️ Scarica libretto</button>
                <button class="btn btn-primary" disabled title="Attivo quando l'attestato digitale è definito">
                    🎓 Scarica attestato
                </button>
            </div>
        </div>
    </div>

    <div class="mt-4 text-sm opacity-70">
        Nota: quando attivate l’attestato digitale, qui si aggancia l’endpoint “/attestati/{id}/download”.
    </div>
</section>