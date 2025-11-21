<div class="p-6">
    <header class="mb-4">
        <h2 class="text-xl font-semibold">Sinottico</h2>
        <p class="text-sm opacity-75 mt-1">Quadro sintetico regionale: COC, VVF, eventi, volontari.</p>
    </header>

    @php
    $province = ['BL','PD','RO','TV','VE','VI','VR'];

    $salaOpHead = array_merge(['Stato'],
    collect($province)->map(fn($p,$i)=>'<a href="stato_sala_op.php?provincia='.($i+1).'"
        class="text-brand-700 hover:text-brand-800 hover:underline">'.$p.'</a>')->toArray()
    );
    $salaOpRows = [
    [
    '<a href="stato_sala_op.php?stato=chiusa&provincia=0" class="text-brand-700 hover:text-brand-800 hover:underline">chiusa</a>',
    '<a href="stato_sala_op.php?stato=chiusa&provincia=1">54</a>',
    '<a href="stato_sala_op.php?stato=chiusa&provincia=2">96</a>',
    '<a href="stato_sala_op.php?stato=chiusa&provincia=3">46</a>',
    '<a href="stato_sala_op.php?stato=chiusa&provincia=4">72</a>',
    '<a href="stato_sala_op.php?stato=chiusa&provincia=5">28</a>',
    '<a href="stato_sala_op.php?stato=chiusa&provincia=6">108</a>',
    '<a href="stato_sala_op.php?stato=chiusa&provincia=7">98</a>',
    ],
    [
    '<a href="stato_sala_op.php?stato=aperta orario diurno&provincia=0" class="text-brand-700 hover:text-brand-800 hover:underline">aperta orario diurno</a>',
    '<a href="stato_sala_op.php?stato=aperta orario diurno&provincia=1">2</a>',
    '<a href="stato_sala_op.php?stato=aperta orario diurno&provincia=2">2</a>',
    '<a href="stato_sala_op.php?stato=aperta orario diurno&provincia=3">2</a>',
    '<a href="stato_sala_op.php?stato=aperta orario diurno&provincia=4">5</a>',
    '<a href="stato_sala_op.php?stato=aperta orario diurno&provincia=5">1</a>',
    '<a href="stato_sala_op.php?stato=aperta orario diurno&provincia=6">3</a>',
    '<a href="stato_sala_op.php?stato=aperta orario diurno&provincia=7"></a>',
    ],
    [
    '<a href="stato_sala_op.php?stato=aperta h24&provincia=0" class="text-brand-700 hover:text-brand-800 hover:underline">aperta h24</a>',
    '<a href="stato_sala_op.php?stato=aperta h24&provincia=1">4</a>',
    '<a href="stato_sala_op.php?stato=aperta h24&provincia=2">3</a>',
    '<a href="stato_sala_op.php?stato=aperta h24&provincia=3">2</a>',
    '<a href="stato_sala_op.php?stato=aperta h24&provincia=4">17</a>',
    '<a href="stato_sala_op.php?stato=aperta h24&provincia=5">15</a>',
    '<a href="stato_sala_op.php?stato=aperta h24&provincia=6">2</a>',
    '<a href="stato_sala_op.php?stato=aperta h24&provincia=7"></a>',
    ],
    ];

    $vvfHead = array_merge(['Interventi'], $province);
    $vvfRows = [ array_merge(['numero interventi'], array_fill(0, count($province), '')) ];

    $eventiHead = array_merge(['Stato'],
    collect($province)->map(fn($p,$i)=>'<a href="eventi.php?provincia='.($i+1).'"
        class="text-brand-700 hover:text-brand-800 hover:underline">'.$p.'</a>')->toArray()
    );
    $eventiRows = [[
    '<a href="eventi.php?evento_segnalato=Allagamento&provincia=0" class="text-brand-700 hover:text-brand-800 hover:underline">Allagamento</a>',
    '',
    '<a href="eventi.php?evento_segnalato=Allagamento&provincia=2">1</a>',
    '<a href="eventi.php?evento_segnalato=Allagamento&provincia=3">3</a>',
    '',
    '<a href="eventi.php?evento_segnalato=Allagamento&provincia=5">3</a>',
    '',
    '',
    ]];

    $volontHead = array_merge(['Stato'],
    collect($province)->map(fn($p,$i)=>'<a href="volontari_provincia.php?provincia='.($i+1).'"
        class="text-brand-700 hover:text-brand-800 hover:underline">'.$p.'</a>')->toArray()
    );
    $volontRows = [[
    '<a href="volontari_provincia.php?stato=Attivate&provincia=0" class="text-brand-700 hover:text-brand-800 hover:underline">Attivate</a>',
    '<a href="volontari_provincia.php?stato=Attivate&provincia=1">2</a>',
    '<a href="volontari_provincia.php?stato=Attivate&provincia=2">3</a>',
    '<a href="volontari_provincia.php?stato=Attivate&provincia=3">16</a>',
    '<a href="volontari_provincia.php?stato=Attivate&provincia=4">11</a>',
    '<a href="volontari_provincia.php?stato=Attivate&provincia=5">7</a>',
    '<a href="volontari_provincia.php?stato=Attivate&provincia=6">12</a>',
    '<a href="volontari_provincia.php?stato=Attivate&provincia=7">2</a>',
    ]];

    $capHead = array_merge(['Stato'],
    collect($province)->map(fn($p,$i)=>'<a href="stato_sala_op.php?provincia='.($i+1).'"
        class="text-brand-700 hover:text-brand-800 hover:underline">'.$p.'</a>')->toArray()
    );
    $capRows = [ array_fill(0, count($capHead), '') ];
    @endphp

    {{-- RIGA 1 --}}
    <div class="grid gap-6 lg:grid-cols-2">
        {{-- Situazione COC + mappa --}}
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
                                @foreach ($salaOpHead as $th)
                                <th class="px-3 py-2 text-left font-medium text-slate-700">{!! $th !!}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salaOpRows as $row)
                            <tr class="border-t border-slate-200">
                                @foreach ($row as $c)
                                <td class="px-3 py-2 align-top">{!! $c !!}</td>
                                @endforeach
                            </tr>
                            @endforeach
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
                                @foreach ($vvfHead as $th)
                                <th class="px-3 py-2 text-left font-medium text-slate-700">{{ $th }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vvfRows as $row)
                            <tr class="border-t border-slate-200">
                                @foreach ($row as $c)
                                <td class="px-3 py-2 align-top">{{ $c }}</td>
                                @endforeach
                            </tr>
                            @endforeach
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
                                @foreach ($eventiHead as $th)
                                <th class="px-3 py-2 text-left font-medium text-slate-700">{!! $th !!}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($eventiRows as $row)
                            <tr class="border-t border-slate-200">
                                @foreach ($row as $c)
                                <td class="px-3 py-2 align-top">{!! $c !!}</td>
                                @endforeach
                            </tr>
                            @endforeach
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
                                @foreach ($volontHead as $th)
                                <th class="px-3 py-2 text-left font-medium text-slate-700">{!! $th !!}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($volontRows as $row)
                            <tr class="border-t border-slate-200">
                                @foreach ($row as $c)
                                <td class="px-3 py-2 align-top">{!! $c !!}</td>
                                @endforeach
                            </tr>
                            @endforeach
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
                                @foreach ($capHead as $th)
                                <th class="px-3 py-2 text-left font-medium text-slate-700">{!! $th !!}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($capRows as $row)
                            <tr class="border-t border-slate-200">
                                @foreach ($row as $c)
                                <td class="px-3 py-2 align-top">{!! $c !!}</td>
                                @endforeach
                            </tr>
                            @endforeach
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