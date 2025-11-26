@php
    use Carbon\Carbon;

    $statoMap = [
        0 => 'CHIUSA',
        1 => 'APERTA (diurno)',
        2 => 'APERTA (h24)',
    ];

    $faseMap = [
        0 => 'Nessuna allerta',
        1 => 'Attenzione',
        2 => 'Preallarme',
        3 => 'Allarme',
    ];

    $currentStatoLabel = $statoMap[$statoCoc->stato_coc] ?? 'N/D';
    $currentFaseLabel  = $faseMap[$statoCoc->fase_operativa] ?? 'N/D';
@endphp

<div class="p-6 space-y-6">
    <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-xs font-medium uppercase tracking-[0.2em] text-slate-400">
                Centro Operativo Comunale
            </p>
            <h2 class="mt-1 text-2xl font-semibold text-slate-900">
                Apertura/Chiusura COC
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Gestisci lo stato del COC per il tuo comune e consulta le segnalazioni/gli eventi in corso.
            </p>
        </div>

        <div class="flex flex-col items-end gap-2 text-xs">
            <span
                class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1
                       @if($statoCoc->stato_coc === 0)
                           border-slate-200 bg-slate-50 text-slate-700
                       @else
                           border-emerald-200 bg-emerald-50 text-emerald-800
                       @endif">
                <span class="h-2 w-2 rounded-full
                    @if($statoCoc->stato_coc === 0)
                        bg-slate-400
                    @else
                        bg-emerald-500
                    @endif"></span>
                Stato COC: <span class="ml-1 font-semibold">{{ $currentStatoLabel }}</span>
            </span>

            <span
                class="inline-flex items-center gap-1.5 rounded-full border border-sky-200 bg-sky-50 px-3 py-1 text-sky-800">
                <x-heroicon-o-bolt class="h-3.5 w-3.5" />
                Fase operativa: <span class="ml-1 font-semibold">{{ $currentFaseLabel }}</span>
            </span>

            <span class="inline-flex items-center gap-1.5 rounded-full bg-white px-3 py-1 text-slate-500 border border-slate-200 shadow-sm">
                <x-heroicon-o-clock class="h-3.5 w-3.5" />
                Ultimo aggiornamento:
                <span class="ml-1 font-medium">
                    {{ $statoCoc->data_ora ? Carbon::parse($statoCoc->data_ora)->format('d/m/Y H:i') : 'N/D' }}
                </span>
            </span>
        </div>
    </header>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,2fr)_minmax(0,3fr)]">
        {{-- COLONNA SINISTRA: form stato COC --}}
        <section class="space-y-4">
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <header class="flex items-center gap-2 rounded-t-2xl bg-slate-50 px-4 py-3 text-sm font-medium text-slate-800">
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                        <x-heroicon-o-building-office-2 class="h-4 w-4" />
                    </span>
                    <div>
                        <h3 class="text-sm font-semibold">Aggiornamento COC</h3>
                        <p class="text-xs text-slate-500">
                            Imposta stato COC, fase operativa e motivazioni.
                        </p>
                    </div>
                </header>

                <form method="POST" action="{{ route('coc.update') }}" class="p-4 sm:p-6 space-y-4">
                    @csrf

                    <input type="hidden" name="codistat" value="{{ $codistat }}"/>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="flex flex-col gap-1.5 text-sm">
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase text-slate-600">
                                <x-heroicon-o-power class="h-4 w-4 text-slate-500" />
                                Stato COC
                            </span>
                            <select name="stato_id"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                       focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                                @foreach($statoMap as $id => $label)
                                    <option value="{{ $id }}" @selected($statoCoc->stato_coc == $id)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="flex flex-col gap-1.5 text-sm">
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase text-slate-600">
                                <x-heroicon-o-exclamation-triangle class="h-4 w-4 text-amber-500" />
                                Fase operativa
                            </span>
                            <select name="fase_id"
                                class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                       focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                                @foreach($faseMap as $id => $label)
                                    <option value="{{ $id }}" @selected($statoCoc->fase_operativa == $id)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <label class="flex flex-col gap-1.5 text-sm">
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase text-slate-600">
                            <x-heroicon-o-calendar-days class="h-4 w-4 text-slate-500" />
                            Decorrenza
                        </span>
                        <input
                            type="date"
                            name="decorrenza"
                            value="{{ now()->format('Y-m-d') }}"
                            class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm
                                   focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                        <span class="mt-1 text-[11px] text-slate-400">
                            Lascia la data odierna per l’aggiornamento corrente, oppure imposta una data diversa.
                        </span>
                    </label>

                    <label class="flex flex-col gap-1.5 text-sm">
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase text-slate-600">
                            <x-heroicon-o-document-text class="h-4 w-4 text-slate-500" />
                            Motivazione apertura/chiusura COC
                        </span>
                        <textarea name="nota_stato" rows="3"
                            class="w-full rounded-xl border border-slate-300 bg-white p-3 text-sm
                                   placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                            placeholder="Es. apertura COC per verifica danni da maltempo...">{{ old('nota_stato', $statoCoc->nota_stato) }}</textarea>
                    </label>

                    <label class="flex flex-col gap-1.5 text-sm">
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase text-slate-600">
                            <x-heroicon-o-chat-bubble-left-right class="h-4 w-4 text-slate-500" />
                            Motivazione cambio fase operativa
                        </span>
                        <textarea name="nota_fase" rows="3"
                            class="w-full rounded-xl border border-slate-300 bg-white p-3 text-sm
                                   placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                            placeholder="Es. passaggio in fase di attenzione per frane diffuse...">{{ old('nota_fase', $statoCoc->nota_fase) }}</textarea>
                    </label>

                    <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                        <p class="text-[11px] text-slate-500 flex items-center gap-1.5">
                            <x-heroicon-o-information-circle class="h-4 w-4 text-slate-400" />
                            L’aggiornamento verrà registrato anche nel monitoraggio COC.
                        </p>

                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-blue-500">
                            <x-heroicon-o-check-circle class="h-4 w-4" />
                            Salva
                        </button>
                    </div>
                </form>
            </div>
        </section>

        {{-- COLONNA DESTRA: segnalazioni + eventi --}}
        <section class="space-y-4">
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <header class="flex items-center justify-between gap-2 rounded-t-2xl bg-sky-50 px-4 py-3 text-sm font-medium text-sky-900">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-xl bg-sky-100 text-sky-700">
                            <x-heroicon-o-clipboard-document-list class="h-4 w-4" />
                        </span>
                        <div>
                            <h3 class="text-sm font-semibold">Eventi attivi sul territorio</h3>
                            <p class="text-xs text-sky-800/80">
                                Lista sintetica degli eventi ancora aperti nel comune (fonte SOR).
                            </p>
                        </div>
                    </div>
                </header>

                <div class="p-4 sm:p-6 max-h-72 overflow-y-auto">
                    @if($eventi->isEmpty())
                        <p class="text-xs text-slate-500">
                            Nessun evento attivo registrato per il comune.
                        </p>
                    @else
                        <ul class="space-y-2 text-xs">
                            @foreach($eventi as $ev)
                                <li class="rounded-xl border border-slate-100 bg-slate-50 px-3 py-2">
                                    <p class="font-semibold text-slate-800">
                                        {{-- adatta i campi ai nomi reali --}}
                                        {{ $ev->tipo_evento ?? 'Evento' }}
                                    </p>
                                    <p class="text-[11px] text-slate-500">
                                        {{ $ev->nota_evento ?? '' }}
                                    </p>
                                    <p class="mt-1 text-[11px] text-slate-400">
                                        Inizio:
                                        {{ isset($ev->data_inizio) ? \Carbon\Carbon::parse($ev->data_inizio)->format('d/m/Y H:i') : 'N/D' }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <header class="flex items-center justify-between gap-2 rounded-t-2xl bg-amber-50 px-4 py-3 text-sm font-medium text-amber-900">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                            <x-heroicon-o-document-text class="h-4 w-4" />
                        </span>
                        <div>
                            <h3 class="text-sm font-semibold">Segnalazioni recenti</h3>
                            <p class="text-xs text-amber-800/80">
                                Ultime segnalazioni registrate per il comune.
                            </p>
                        </div>
                    </div>
                </header>

                <div class="p-4 sm:p-6 max-h-72 overflow-y-auto">
                    @if($segnalazioni->isEmpty())
                        <p class="text-xs text-slate-500">
                            Nessuna segnalazione recente per il comune.
                        </p>
                    @else
                        <table class="w-full text-[11px]">
                            <thead class="bg-slate-50 text-slate-500">
                                <tr>
                                    <th class="px-2 py-1 text-left">Data/Ora</th>
                                    <th class="px-2 py-1 text-left">Tipologia</th>
                                    <th class="px-2 py-1 text-left">Sintesi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($segnalazioni as $s)
                                    <tr class="border-t border-slate-100">
                                        <td class="px-2 py-1 whitespace-nowrap">
                                            {{ isset($s->data_ins) ? \Carbon\Carbon::parse($s->data_ins)->format('d/m/Y H:i') : 'N/D' }}
                                        </td>
                                        <td class="px-2 py-1 whitespace-nowrap">
                                            {{ $s->tipologia ?? 'N/D' }}
                                        </td>
                                        <td class="px-2 py-1">
                                            {{ \Illuminate\Support\Str::limit($s->titolo ?? $s->nota ?? '', 80) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>
