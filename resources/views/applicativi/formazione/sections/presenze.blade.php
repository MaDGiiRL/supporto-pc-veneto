@php $canEditPresenze = $canEditPresenze ?? false; @endphp

<section class="sec shadow-card">
    <div class="flex items-center justify-between gap-3 mb-3">
        <div>
            <h3 class="text-sm font-semibold">Registro presenze</h3>
            <p class="text-xs opacity-70 mt-1">
                Correzione ore fino a conclusione corso. Permesso attuale: <strong>{{ $canEditPresenze ? 'Sì' : 'No' }}</strong>.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <button class="btn-xs" data-open-modal="#modal-presenze" {{ $canEditPresenze ? '' : 'disabled' }}>🕒 Apri registro</button>
            <button class="btn-xs" {{ $canEditPresenze ? '' : 'disabled' }}>⬇️ Export presenze</button>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-3">
        <div class="grid md:grid-cols-3 gap-3">
            <label class="grid gap-1">
                <span class="label">Seleziona corso</span>
                <select class="input">
                    <option value="">Scegli…</option>
                </select>
            </label>
            <label class="grid gap-1">
                <span class="label">Lezione</span>
                <select class="input">
                    <option value="">Tutte</option>
                </select>
            </label>
            <div class="text-sm opacity-70 flex items-end">
                Suggerimento: apri “Registro” per modificare ore inline (senza PgAdmin).
            </div>
        </div>
    </div>
</section>