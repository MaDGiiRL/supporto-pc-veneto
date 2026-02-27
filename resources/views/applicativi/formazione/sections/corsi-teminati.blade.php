@php $canManageCourses = $canManageCourses ?? false; @endphp

<section class="sec shadow-card">
    <div class="flex items-center justify-between gap-3 mb-3">
        <div>
            <h3 class="text-sm font-semibold">Corsi terminati</h3>
            <p class="text-xs opacity-70 mt-1">
                Export promossi: deve includere una sola associazione (quella dell’iscrizione al corso) ed escludere chi non risulta più iscritto.
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
                            <button class="btn-xs btn-ghost" data-open-modal="#modal-corso" {{ $canManageCourses ? '' : 'disabled' }}>✏️</button>
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