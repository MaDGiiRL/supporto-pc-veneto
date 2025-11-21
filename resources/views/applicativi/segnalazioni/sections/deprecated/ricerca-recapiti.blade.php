{{-- resources/views/ricerca-recapiti.blade.php --}}
@php
use Illuminate\Support\Str;

/* ===========================
* Dizionari MOCK
* =========================== */
$zoneIdrauliche = [
['id' => 'ZA-01', 'label' => 'IF_ZA_CFD 01'],
['id' => 'ZA-02', 'label' => 'IF_ZA_CFD 02'],
['id' => 'ZA-03', 'label' => 'IF_ZA_CFD 03'],
];

$zoneValanghe = [
['id' => 'VAL-A', 'label' => 'Sottozona A'],
['id' => 'VAL-B', 'label' => 'Sottozona B'],
['id' => 'VAL-C', 'label' => 'Sottozona C'],
];

$statiSale = [
['id' => 'S0', 'label' => 'Non attivo'],
['id' => 'S1', 'label' => 'Presidio'],
['id' => 'S2', 'label' => 'Attivo'],
];

$fasi = [
['id' => 'F0', 'label' => 'Ordinaria'],
['id' => 'F1', 'label' => 'Preallarme'],
['id' => 'F2', 'label' => 'Allarme'],
];

$tipiRecapito = [
['id' => 'TEL', 'label' => 'Telefono'],
['id' => 'PEC', 'label' => 'PEC'],
['id' => 'MAIL','label' => 'Email'],
];

/* ===========================
* Dataset ENTI (MOCK)
* (mantengo la chiave 'tipo_ente' solo per l’accento visivo riga)
* =========================== */
$enti = [
[
'nome' => 'Comune di Rivabella',
'tipo_ente' => 'Comune',
'idraulico_id' => 'ZA-01',
'valanghe_id' => 'VAL-A',
'stato_sale_id'=> 'S2',
'fase_id' => 'F1',
'tipi_recapito_ids' => ['TEL','PEC'],
'recapiti' => [
['tipo' => 'TEL', 'valore' => '+39 0123 456789'],
['tipo' => 'PEC', 'valore' => 'protocollo@pec.rivabella.it'],
],
],
[
'nome' => 'Organizzazione Volontari Costa',
'tipo_ente' => 'Org_vol',
'idraulico_id' => 'ZA-02',
'valanghe_id' => 'VAL-B',
'stato_sale_id'=> 'S1',
'fase_id' => 'F0',
'tipi_recapito_ids' => ['MAIL'],
'recapiti' => [
['tipo' => 'MAIL', 'valore' => 'contatti@volcosta.org'],
],
],
[
'nome' => 'ASL Territoriale 7',
'tipo_ente' => 'ASL',
'idraulico_id' => 'ZA-03',
'valanghe_id' => 'VAL-C',
'stato_sale_id'=> 'S0',
'fase_id' => 'F0',
'tipi_recapito_ids' => ['TEL','MAIL'],
'recapiti' => [
['tipo' => 'TEL', 'valore' => '+39 045 998877'],
['tipo' => 'MAIL', 'valore' => 'urp@asl7.example.it'],
],
],
[
'nome' => 'Prefettura di Valleverde',
'tipo_ente' => 'Pref',
'idraulico_id' => 'ZA-01',
'valanghe_id' => 'VAL-B',
'stato_sale_id'=> 'S2',
'fase_id' => 'F2',
'tipi_recapito_ids' => ['PEC','TEL'],
'recapiti' => [
['tipo' => 'PEC', 'valore' => 'pref.valleverde@pec.interno.it'],
['tipo' => 'TEL', 'valore' => '+39 011 223344'],
],
],
];

/* ===========================
* Helpers
* =========================== */
$map = fn($arr, $valKey='id', $labelKey='label')
=> collect($arr)->mapWithKeys(fn($x) => [ (string)($x[$valKey]) => $x[$labelKey] ])->all();

$labels = [
'idraulico' => $map($zoneIdrauliche),
'valanghe' => $map($zoneValanghe),
'stato_sale' => $map($statiSale),
'fase' => $map($fasi),
'recapito' => $map($tipiRecapito),
];

/* ===========================
* Filtri (POST a se stessa) – NIENTE tipo_ente
* =========================== */
$isPost = request()->isMethod('post');
$f_nome = request('nome_ente');
$f_idraulico = (array) request('allertamento_idraulico', []);
$f_valanghe = (array) request('zona_valanghe', []);
$f_statoSale = (array) request('stato_sale', []);
$f_fasi = (array) request('fase', []);
$f_tipiRecapito = (array) request('tipo_recapito', []);
$f_limite = (int) (request('limite', 5) ?: 5);
if ($f_limite < 1) $f_limite=1; if ($f_limite>30) $f_limite=30;

    /* ===========================
    * Filtro Dati
    * =========================== */
    $risultati = collect();
    if ($isPost || request()->query()) {
    $risultati = collect($enti)->filter(function ($r) use ($f_nome,$f_idraulico,$f_valanghe,$f_statoSale,$f_fasi,$f_tipiRecapito) {
    if ($f_nome && !Str::contains(Str::lower($r['nome']), Str::lower($f_nome))) return false;
    if ($f_idraulico && !in_array($r['idraulico_id'], $f_idraulico)) return false;
    if ($f_valanghe && !in_array($r['valanghe_id'], $f_valanghe)) return false;
    if ($f_statoSale && !in_array($r['stato_sale_id'], $f_statoSale)) return false;
    if ($f_fasi && !in_array($r['fase_id'], $f_fasi)) return false;
    if ($f_tipiRecapito && empty(array_intersect($r['tipi_recapito_ids'], $f_tipiRecapito))) return false;
    return true;
    })->values()->take($f_limite);
    }
    @endphp

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10 space-y-10">
        <header class="flex items-start justify-between">
            <div>
                <h2 class="text-3xl font-semibold text-slate-900 tracking-tight">Ricerca recapiti</h2>
                <p class="text-base text-slate-600 mt-2">Interfaccia ampia e leggibile, con categorie colorate e icone.</p>
            </div>
        </header>

        {{-- FILTRI SPAZIOSI: 2 colonne su desktop (sezione "Tipo di Ente" rimossa) --}}
        <form method="POST" action="" class="space-y-10">
            @csrf

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                {{-- Ente (emerald) --}}
                <section class="rounded-2xl border border-emerald-200 bg-emerald-50 shadow-card">
                    <header class="flex items-center gap-3 rounded-t-2xl bg-emerald-100/70 px-6 py-4 text-emerald-900">
                        <x-heroicon-o-building-office-2 class="h-6 w-6" />
                        <h3 class="text-lg font-semibold">Ente</h3>
                    </header>
                    <div class="p-6 space-y-3">
                        <label class="text-sm font-medium text-emerald-900">Nome ente</label>
                        <input type="text" name="nome_ente" value="{{ $f_nome }}"
                            class="h-12 w-full rounded-2xl border border-emerald-300 bg-white px-4 text-base focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Inserisci il nome o una parte">
                        <p class="text-sm text-emerald-800/90">Ricerca parziale per nome.</p>
                    </div>
                </section>

                {{-- ZA Idraulico (sky) --}}
                <section class="rounded-2xl border border-sky-200 bg-sky-50 shadow-card">
                    <header class="flex items-center gap-3 rounded-t-2xl bg-sky-100/70 px-6 py-4 text-sky-900">
                        <x-heroicon-o-arrow-path-rounded-square class="h-6 w-6" />
                        <h3 class="text-lg font-semibold">Zona di allertamento idraulico</h3>
                    </header>
                    <div class="p-6 space-y-3">
                        <label class="block text-sm font-medium text-sky-900">Seleziona zone</label>
                        <select name="allertamento_idraulico[]" multiple size="8"
                            class="min-h-[12rem] w-full rounded-2xl border border-sky-300 bg-white px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-sky-500">
                            @foreach($zoneIdrauliche as $zi)
                            <option value="{{ $zi['id'] }}" @selected(in_array($zi['id'], $f_idraulico))>{{ $zi['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </section>

                {{-- ZA Valanghe (cyan) --}}
                <section class="rounded-2xl border border-cyan-200 bg-cyan-50 shadow-card">
                    <header class="flex items-center gap-3 rounded-t-2xl bg-cyan-100/70 px-6 py-4 text-cyan-900">
                        <x-heroicon-o-sparkles class="h-6 w-6" />
                        <h3 class="text-lg font-semibold">Zona di allertamento valanghe</h3>
                    </header>
                    <div class="p-6 space-y-3">
                        <label class="block text-sm font-medium text-cyan-900">Seleziona zone</label>
                        <select name="zona_valanghe[]" multiple size="8"
                            class="min-h-[12rem] w-full rounded-2xl border border-cyan-300 bg-white px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            @foreach($zoneValanghe as $zv)
                            <option value="{{ $zv['id'] }}" @selected(in_array($zv['id'], $f_valanghe))>{{ $zv['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </section>

                {{-- Stato COC (amber) --}}
                <section class="rounded-2xl border border-amber-200 bg-amber-50 shadow-card">
                    <header class="flex items-center gap-3 rounded-t-2xl bg-amber-100/70 px-6 py-4 text-amber-900">
                        <x-heroicon-o-bell-alert class="h-6 w-6" />
                        <h3 class="text-lg font-semibold">Stato C.O.C.</h3>
                    </header>
                    <div class="p-6">
                        <select name="stato_sale[]" multiple size="8"
                            class="min-h-[12rem] w-full rounded-2xl border border-amber-300 bg-white px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-amber-500">
                            @foreach($statiSale as $ss)
                            <option value="{{ $ss['id'] }}" @selected(in_array($ss['id'], $f_statoSale))>{{ $ss['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </section>

                {{-- Fase operativa (red) --}}
                <section class="rounded-2xl border border-red-200 bg-red-50 shadow-card">
                    <header class="flex items-center gap-3 rounded-t-2xl bg-red-100/70 px-6 py-4 text-red-900">
                        <x-heroicon-o-fire class="h-6 w-6" />
                        <h3 class="text-lg font-semibold">Fase operativa</h3>
                    </header>
                    <div class="p-6">
                        <select name="fase[]" multiple size="8"
                            class="min-h-[12rem] w-full rounded-2xl border border-red-300 bg-white px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-red-500">
                            @foreach($fasi as $f)
                            <option value="{{ $f['id'] }}" @selected(in_array($f['id'], $f_fasi))>{{ $f['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </section>

                {{-- Tipo recapito (green) --}}
                <section class="rounded-2xl border border-green-200 bg-green-50 shadow-card">
                    <header class="flex items-center gap-3 rounded-t-2xl bg-green-100/70 px-6 py-4 text-green-900">
                        <x-heroicon-o-phone class="h-6 w-6" />
                        <h3 class="text-lg font-semibold">Tipo recapito</h3>
                    </header>
                    <div class="p-6">
                        <select name="tipo_recapito[]" multiple size="8"
                            class="min-h-[12rem] w-full rounded-2xl border border-green-300 bg-white px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-green-500">
                            @foreach($tipiRecapito as $tr)
                            <option value="{{ $tr['id'] }}" @selected(in_array($tr['id'], $f_tipiRecapito))>{{ $tr['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </section>

                {{-- Limite + Azioni (slate) --}}
                <section class="rounded-2xl border border-slate-200 bg-white shadow-card">
                    <header class="flex items-center gap-3 rounded-t-2xl bg-slate-50 px-6 py-4 text-slate-900">
                        <x-heroicon-o-cog-8-tooth class="h-6 w-6" />
                        <h3 class="text-lg font-semibold">Opzioni</h3>
                    </header>
                    <div class="p-6 space-y-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Limita risultati</label>
                            <div class="flex flex-wrap items-center gap-4">
                                <span class="text-base text-slate-700">a</span>
                                <input type="number" min="1" max="30" name="limite" value="{{ $f_limite }}"
                                    class="h-12 w-28 rounded-2xl border border-slate-300 bg-white px-4 text-base focus:outline-none focus:ring-2 focus:ring-slate-500">
                                <span class="text-base text-slate-700">risultati</span>
                            </div>
                        </div>
                        <div class="pt-2 flex flex-wrap items-center gap-3">
                            <button type="reset"
                                class="h-12 px-6 rounded-2xl border border-slate-300 text-slate-800 hover:bg-slate-50">Azzera</button>
                            <button type="submit"
                                class="h-12 px-6 rounded-2xl bg-emerald-600 text-white hover:bg-emerald-700">Cerca</button>
                        </div>
                    </div>
                </section>
            </div>
        </form>

        {{-- RISULTATI (colonna Tipo rimossa) --}}
        @if($risultati->count())
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-card">
            <header class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                <div class="flex items-center gap-3">
                    <x-heroicon-o-list-bullet class="h-6 w-6 text-slate-600" />
                    <h3 class="text-xl font-semibold text-slate-900">Risultati</h3>
                </div>
                <div class="text-base text-slate-600">Trovati {{ $risultati->count() }} elementi (limite {{ $f_limite }})</div>
            </header>

            <div class="p-2 sm:p-4">
                <table class="min-w-full text-base">
                    <thead class="bg-slate-50 text-left">
                        <tr>
                            <th class="px-4 py-4">Ente</th>
                            <th class="px-4 py-4">ZA Idraulico</th>
                            <th class="px-4 py-4">ZA Valanghe</th>
                            <th class="px-4 py-4">Stato C.O.C.</th>
                            <th class="px-4 py-4">Fase</th>
                            <th class="px-4 py-4">Recapiti</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($risultati as $r)
                        <tr class="group">
                            <td class="px-4 py-4 font-medium">
                                <div class="flex items-center gap-4">
                                    @switch($r['tipo_ente'])
                                    @case('Comune') <span class="inline-block h-6 w-1.5 rounded-full bg-emerald-50 border border-emerald-200"></span> @break
                                    @case('Org_vol') <span class="inline-block h-6 w-1.5 rounded-full bg-indigo-50  border border-indigo-200"></span> @break
                                    @case('ASL') <span class="inline-block h-6 w-1.5 rounded-full bg-cyan-50    border border-cyan-200"></span> @break
                                    @case('Pref') <span class="inline-block h-6 w-1.5 rounded-full bg-amber-50   border border-amber-200"></span> @break
                                    @default <span class="inline-block h-6 w-1.5 rounded-full bg-slate-50   border border-slate-200"></span>
                                    @endswitch

                                    <div>
                                        <div class="text-slate-900">{{ $r['nome'] }}</div>
                                        <div class="text-sm text-slate-500 mt-0.5">
                                            {{ $labels['idraulico'][$r['idraulico_id']] ?? $r['idraulico_id'] }}
                                            <span class="mx-3 opacity-40">•</span>
                                            {{ $labels['valanghe'][$r['valanghe_id']] ?? $r['valanghe_id'] }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-4">{{ $labels['idraulico'][$r['idraulico_id']] ?? $r['idraulico_id'] }}</td>
                            <td class="px-4 py-4">{{ $labels['valanghe'][$r['valanghe_id']] ?? $r['valanghe_id'] }}</td>

                            <td class="px-4 py-4">
                                @switch($r['stato_sale_id'])
                                @case('S2') <span class="px-2.5 py-1 text-xs rounded-full bg-green-100 text-green-800">Attivo</span> @break
                                @case('S1') <span class="px-2.5 py-1 text-xs rounded-full bg-sky-100   text-sky-800">Presidio</span> @break
                                @default <span class="px-2.5 py-1 text-xs rounded-full bg-slate-100 text-slate-800">Non attivo</span>
                                @endswitch
                            </td>

                            <td class="px-4 py-4">
                                @switch($r['fase_id'])
                                @case('F2') <span class="px-2.5 py-1 text-xs rounded-full bg-red-50      text-red-700">Allarme</span> @break
                                @case('F1') <span class="px-2.5 py-1 text-xs rounded-full bg-amber-50    text-amber-800">Preallarme</span> @break
                                @default <span class="px-2.5 py-1 text-xs rounded-full bg-emerald-50  text-emerald-700">Ordinaria</span>
                                @endswitch
                            </td>

                            <td class="px-4 py-4">
                                <ul class="flex flex-wrap items-center gap-2">
                                    @foreach($r['recapiti'] as $rec)
                                    <li class="inline-flex items-center gap-2 rounded-full bg-slate-100 text-slate-800 px-2.5 py-1">
                                        <span class="text-[10px] uppercase tracking-wide opacity-70">{{ $labels['recapito'][$rec['tipo']] ?? $rec['tipo'] }}</span>
                                        <span class="font-medium">{{ $rec['valore'] }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
        @elseif($isPost)
        <div class="text-base text-slate-600">Nessun risultato. Modifica i filtri e riprova.</div>
        @endif
    </div>

    {{-- Keep-alive di alcune utility --}}
    <div class="hidden">
        <div class="bg-emerald-50 bg-cyan-50 bg-amber-50 bg-sky-50 bg-green-50 bg-red-50 bg-slate-50"></div>
        <div class="border-emerald-200 border-cyan-200 border-amber-200 border-sky-200 border-green-200 border-red-200 border-slate-200"></div>
        <div class="text-emerald-900 text-cyan-900 text-amber-900 text-sky-900 text-green-900 text-red-900"></div>
    </div>