<div class="p-6">
    <header class="mb-4">
        <h2 class="text-xl font-semibold">Dashboard</h2>
        <p class="text-sm opacity-75 mt-1">Sintesi rapida delle comunicazioni e KPI.</p>
    </header>

    {{-- KPI cards --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([
        ['label' => 'Segnalazioni oggi', 'value' => '32'],
        ['label' => 'Eventi attivi', 'value' => '7'],
        ['label' => 'Squadre operative', 'value' => '15'],
        ['label' => 'Ultimo aggiornamento', 'value' => '5 min'],
        ] as $kpi)
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-4">
            <p class="text-sm text-slate-500">{{ $kpi['label'] }}</p>
            <div class="text-3xl font-semibold text-slate-900">{{ $kpi['value'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Tabellina placeholder (puoi sostituire con dati reali) --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="px-3 py-2">Data e ora</th>
                    <th class="px-3 py-2">E/U</th>
                    <th class="px-3 py-2">Ente</th>
                    <th class="px-3 py-2">Comune</th>
                    <th class="px-3 py-2">Sintesi</th>
                    <th class="px-3 py-2">Operatore</th>
                </tr>
            </thead>
            <tbody>
                @foreach ([
                ['dt'=>'25/09/2025 12:05','eu'=>'E','ente'=>'SOR','comune'=>'Rovigo','txt'=>'Aggiornamento meteo','op'=>'marta veronesi'],
                ['dt'=>'25/09/2025 11:42','eu'=>'U','ente'=>'COC Adria','comune'=>'Adria','txt'=>'Riepilogo interventi','op'=>'emanuele barone'],
                ] as $r)
                <tr class="border-t border-slate-200 hover:bg-slate-50">
                    <td class="px-3 py-2">{{ $r['dt'] }}</td>
                    <td class="px-3 py-2">{{ $r['eu'] }}</td>
                    <td class="px-3 py-2">{{ $r['ente'] }}</td>
                    <td class="px-3 py-2">{{ $r['comune'] }}</td>
                    <td class="px-3 py-2">{{ $r['txt'] }}</td>
                    <td class="px-3 py-2 capitalize">{{ $r['op'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>