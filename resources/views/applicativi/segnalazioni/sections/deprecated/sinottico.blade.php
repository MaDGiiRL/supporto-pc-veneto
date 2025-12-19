<div class="p-6">
    <header class="mb-4">
        <h2 class="text-xl font-semibold">Sinottico</h2>
        <p class="text-sm opacity-75 mt-1">
            Quadro sintetico regionale: COC, VVF, eventi, volontari.
        </p>
    </header>

    {{-- RIGA 1 --}}
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card">
            <div class="border-b border-slate-200 px-4 py-3 bg-brand-50">
                <h3 class="text-base font-semibold text-slate-800">
                    <a href="tab_riassuntiva.php" class="text-brand-700 hover:text-brand-800 hover:underline">
                        Situazione Centri Operativi Comunali
                    </a>
                </h3>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-3 py-2 text-left font-medium text-slate-700">Stato</th>
                                @foreach ($province as $sigla)
                                <th class="px-3 py-2 text-left font-medium text-slate-700">
                                    <a href="stato_sala_op.php?provincia={{ $provinceIndex[$sigla] }}"
                                        class="text-brand-700 hover:text-brand-800 hover:underline">
                                        {{ $sigla }}
                                    </a>
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cocMatrix as $row)
                            <tr class="border-t border-slate-200">
                                {{-- Label stato (chiusa / aperta orario diurno / aperta h24 …) --}}
                                <td class="px-3 py-2 align-top">
                                    <a href="stato_sala_op.php?stato={{ urlencode($row['label']) }}&provincia=0"
                                        class="text-brand-700 hover:text-brand-800 hover:underline">
                                        {{ $row['label'] }}
                                    </a>
                                </td>

                                {{-- Celle per provincia --}}
                                @foreach ($province as $sigla)
                                @php
                                $val = $row['values'][$sigla] ?? 0;
                                $provIndex = $provinceIndex[$sigla] ?? null;
                                @endphp
                                <td class="px-3 py-2 align-top">
                                    @if ($val > 0 && $provIndex)
                                    <a href="stato_sala_op.php?stato={{ urlencode($row['label']) }}&provincia={{ $provIndex }}">
                                        {{ $val }}
                                    </a>
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ 1 + count($province) }}" class="px-3 py-2 text-sm text-slate-500">
                                    Nessun dato disponibile.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <iframe src="https://gestionale.supportopcveneto.it/segnalazioni/mappa_sale_operative.php"
                    width="100%" height="280" scrolling="no" title="Mappa stato COC"
                    class="mt-3 rounded-lg border border-brand-200"></iframe>
            </div>
        </div>

        {{-- Interventi VVF + mappa --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card">
            <div class="border-b border-slate-200 px-4 py-3 bg-brand-50">
                <h3 class="text-base font-semibold text-slate-800">
                    <a href="tab_riassuntiva.php" class="text-brand-700 hover:text-brand-800 hover:underline">
                        Interventi VVF di interesse
                    </a>
                </h3>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-3 py-2 text-left font-medium text-slate-700">Interventi</th>
                                @foreach ($province as $sigla)
                                <th class="px-3 py-2 text-left font-medium text-slate-700">
                                    {{ $sigla }}
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($vvfMatrix ?? [] as $row)
                            <tr class="border-t border-slate-200">
                                <td class="px-3 py-2 align-top">
                                    {{ $row['label'] ?? 'Interventi' }}
                                </td>
                                @foreach ($province as $sigla)
                                @php $val = $row['values'][$sigla] ?? 0; @endphp
                                <td class="px-3 py-2 align-top">
                                    {{ $val ?: '' }}
                                </td>
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ 1 + count($province) }}" class="px-3 py-2 text-sm text-slate-500">
                                    Nessun dato disponibile.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <iframe src="https://gestionale.supportopcveneto.it/segnalazioni/mappa_interventi_vvf.php"
                    width="100%" height="280" scrolling="no" title="Mappa Interventi VVF"
                    class="mt-3 rounded-lg border border-brand-200"></iframe>
            </div>
        </div>
    </div>

    {{-- RIGA 2 --}}
    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        {{-- Eventi segnalati + mappa --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card">
            <div class="border-b border-slate-200 px-4 py-3 bg-brand-50">
                <h3 class="text-base font-semibold text-slate-800">
                    <a href="eventi.php?" class="text-brand-700 hover:text-brand-800 hover:underline">
                        Eventi segnalati
                    </a>
                </h3>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-3 py-2 text-left font-medium text-slate-700">Evento</th>
                                @foreach ($province as $sigla)
                                <th class="px-3 py-2 text-left font-medium text-slate-700">
                                    <a href="eventi.php?provincia={{ $provinceIndex[$sigla] }}"
                                        class="text-brand-700 hover:text-brand-800 hover:underline">
                                        {{ $sigla }}
                                    </a>
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($eventiMatrix ?? [] as $row)
                            <tr class="border-t border-slate-200">
                                {{-- Nome evento (Allagamento, Frana, …) --}}
                                <td class="px-3 py-2 align-top">
                                    <a href="eventi.php?evento_segnalato={{ urlencode($row['label']) }}&provincia=0"
                                        class="text-brand-700 hover:text-brand-800 hover:underline">
                                        {{ $row['label'] }}
                                    </a>
                                </td>

                                @foreach ($province as $sigla)
                                @php
                                $val = $row['values'][$sigla] ?? 0;
                                $provIndex = $provinceIndex[$sigla] ?? null;
                                @endphp
                                <td class="px-3 py-2 align-top">
                                    @if ($val > 0 && $provIndex)
                                    <a href="eventi.php?evento_segnalato={{ urlencode($row['label']) }}&provincia={{ $provIndex }}">
                                        {{ $val }}
                                    </a>
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ 1 + count($province) }}" class="px-3 py-2 text-sm text-slate-500">
                                    Nessun dato disponibile.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <iframe src="https://gestionale.supportopcveneto.it/segnalazioni/mappa_eventi.php"
                    width="100%" height="280" scrolling="no" title="Mappa Eventi"
                    class="mt-3 rounded-lg border border-brand-200"></iframe>
            </div>
        </div>

        {{-- Squadre volontariato + mappa --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card">
            <div class="border-b border-slate-200 px-4 py-3 bg-brand-50">
                <h3 class="text-base font-semibold text-slate-800">
                    <a href="volontari_provincia.php" class="text-brand-700 hover:text-brand-800 hover:underline">
                        Squadre volontariato attivate
                    </a>
                </h3>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-3 py-2 text-left font-medium text-slate-700">Stato</th>
                                @foreach ($province as $sigla)
                                <th class="px-3 py-2 text-left font-medium text-slate-700">
                                    <a href="volontari_provincia.php?provincia={{ $provinceIndex[$sigla] }}"
                                        class="text-brand-700 hover:text-brand-800 hover:underline">
                                        {{ $sigla }}
                                    </a>
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($volontMatrix ?? [] as $row)
                            <tr class="border-t border-slate-200">
                                <td class="px-3 py-2 align-top">
                                    <a href="volontari_provincia.php?stato={{ urlencode($row['label']) }}&provincia=0"
                                        class="text-brand-700 hover:text-brand-800 hover:underline">
                                        {{ $row['label'] }}
                                    </a>
                                </td>

                                @foreach ($province as $sigla)
                                @php
                                $val = $row['values'][$sigla] ?? 0;
                                $provIndex = $provinceIndex[$sigla] ?? null;
                                @endphp
                                <td class="px-3 py-2 align-top">
                                    @if ($val > 0 && $provIndex)
                                    <a href="volontari_provincia.php?stato={{ urlencode($row['label']) }}&provincia={{ $provIndex }}">
                                        {{ $val }}
                                    </a>
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ 1 + count($province) }}" class="px-3 py-2 text-sm text-slate-500">
                                    Nessun dato disponibile.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <iframe src="https://gestionale.supportopcveneto.it/segnalazioni/mappa_zone_attivita.php"
                    width="100%" height="280" scrolling="no" title="Mappa attività organizzazioni"
                    class="mt-3 rounded-lg border border-brand-200"></iframe>
            </div>
        </div>
    </div>

    {{-- RIGA 3 --}}
    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        {{-- Cluster CAP VVF + mappa --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card">
            <div class="border-b border-slate-200 px-4 py-3 bg-brand-50">
                <h3 class="text-base font-semibold text-slate-800">
                    <a href="tab_riassuntiva.php" class="text-brand-700 hover:text-brand-800 hover:underline">
                        Cluster CAP VVF
                    </a>
                </h3>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-3 py-2 text-left font-medium text-slate-700">Cluster</th>
                                @foreach ($province as $sigla)
                                <th class="px-3 py-2 text-left font-medium text-slate-700">
                                    <a href="stato_sala_op.php?provincia={{ $provinceIndex[$sigla] }}"
                                        class="text-brand-700 hover:text-brand-800 hover:underline">
                                        {{ $sigla }}
                                    </a>
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($capMatrix ?? [] as $row)
                            <tr class="border-t border-slate-200">
                                <td class="px-3 py-2 align-top">
                                    {{ $row['label'] ?? '' }}
                                </td>
                                @foreach ($province as $sigla)
                                @php $val = $row['values'][$sigla] ?? 0; @endphp
                                <td class="px-3 py-2 align-top">
                                    {{ $val ?: '' }}
                                </td>
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ 1 + count($province) }}" class="px-3 py-2 text-sm text-slate-500">
                                    Nessun dato disponibile.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <iframe src="https://gestionale.supportopcveneto.it/segnalazioni/mappa_cap_vvf.php"
                    width="100%" height="280" scrolling="no" title="Mappa cluster CAP VVF"
                    class="mt-3 rounded-lg border border-brand-200"></iframe>
            </div>
        </div>

        {{-- Presenza volontari --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card">
            <div class="border-b border-slate-200 px-4 py-3 bg-brand-50">
                <h3 class="text-base font-semibold text-slate-800">
                    <a href="tab_riassuntiva.php" class="text-brand-700 hover:text-brand-800 hover:underline">
                        Presenza volontari (giallo &lt; 10 vol, verde ≥ 10 vol)
                    </a>
                </h3>
            </div>
            <div class="p-4">
                <iframe src="https://gestionale.supportopcveneto.it/segnalazioni/mappa_zone_accreditamento.php"
                    width="100%" height="280" scrolling="no" title="Mappa presenza volontari"
                    class="rounded-lg border border-brand-200"></iframe>
            </div>
        </div>
    </div>
</div>