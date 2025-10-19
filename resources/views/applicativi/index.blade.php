@php
use Illuminate\Support\Str;

$featured = [
'attivazioni-2-0',
'accreditamenti',
'gestione-piani-comunali',
'gestione-odv',
'segnalazioni',
'gestione-mezzi-attrezzature',
'rubrica-telefonica',
];

$categoryColors = [
'Operatività' => 'from-orange-500 to-amber-600 text-white',
'Pianificazione' => 'from-sky-500 to-cyan-600 text-white',
'Anagrafiche' => 'from-fuchsia-500 to-pink-600 text-white',
'Dati & Statistiche'=> 'from-emerald-500 to-teal-600 text-white',
'Utility & Servizi' => 'from-slate-400 to-slate-600 text-white',
'Finanza' => 'from-indigo-500 to-violet-600 text-white',
];

/* ▼▼ NOVITÀ: colori icone per categoria (card NON in evidenza) ▼▼ */
$categoryIconColors = [
'Operatività' => 'text-amber-600',
'Pianificazione' => 'text-cyan-600',
'Anagrafiche' => 'text-pink-600',
'Dati & Statistiche' => 'text-teal-600',
'Utility & Servizi' => 'text-slate-600',
'Finanza' => 'text-violet-600',
];

$categoryBgTints = [
'Operatività' => 'border-amber-200 bg-amber-50 ring-1 ring-amber-100',
'Pianificazione' => 'border-cyan-200 bg-cyan-50 ring-1 ring-cyan-100',
'Anagrafiche' => 'border-pink-200 bg-pink-50 ring-1 ring-pink-100',
'Dati & Statistiche' => 'border-teal-200 bg-teal-50 ring-1 ring-teal-100',
'Utility & Servizi' => 'border-slate-200 bg-slate-50 ring-1 ring-slate-100',
'Finanza' => 'border-violet-200 bg-violet-50 ring-1 ring-violet-100',
];
/* ▲▲ NOVITÀ ▲▲ */

$mapCategory = function(array $item): string {
$slug = Str::of($item['slug'] ?? '')->lower();
return match (true) {
$slug->contains(['attivazioni', 'emergenze', 'aib', 'squadre', 'vvf']) => 'Operatività',
$slug->contains(['piani-comunali', 'rischio', 'punti-di-monitoraggio', 'dighe']) => 'Pianificazione',
$slug->contains(['albo', 'odv', 'anagrafica', 'rubrica']) => 'Anagrafiche',
$slug->contains(['statistiche', 'percezione-sismica', 'schede', 'consultazione']) => 'Dati & Statistiche',
$slug->contains(['manutenzione', 'call', 'scheda-ente', 'formazione', 'prefetture', 'com']) => 'Utility & Servizi',
$slug->contains(['rimborso', 'spese', 'bollo']) => 'Finanza',
default => 'Utility & Servizi',
};
};

$enhanced = collect($apps)
->map(function ($item) use ($featured, $mapCategory) {
$slug = $item['slug'] ?? Str::slug($item['title'] ?? 'app');
$cat = $mapCategory($item);
return array_merge($item, [
'slug' => $slug,
'category' => $cat,
'is_featured' => in_array($slug, $featured, true),
]);
});

$featuredItems = $enhanced->where('is_featured', true)->values();
/* ripetiamo TUTTI (anche i featured) nelle liste per categoria per farli uscire nella ricerca */
$allByCategory = $enhanced->groupBy('category');
$categoryCounts = $allByCategory->map->count();
@endphp

<x-layout title="Applicativi informatici">
    <div x-data="appGrid()" class="container mx-auto px-4 py-10">
        {{-- HERO --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-10 mb-10 shadow-2xl">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
                <div>
                    <h1 class="text-4xl font-extrabold tracking-tight text-white">Procedure informatiche</h1>
                    <p class="mt-2 text-slate-300 max-w-2xl">Cerca rapidamente o esplora per categoria. Le principali sono evidenziate qui sotto.</p>
                    <div class="mt-5 flex flex-wrap gap-2">
                        @foreach($categoryCounts as $cat => $count)
                        @php $grad = $categoryColors[$cat] ?? 'from-slate-500 to-slate-700 text-white'; @endphp
                        <button @click="toggleCategory('{{ $cat }}')"
                            :class="activeCategory === '{{ $cat }}' ? 'ring-2 ring-white/70' : ''"
                            class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r {{ $grad }} px-4 py-2 text-sm font-semibold shadow hover:opacity-95 focus:outline-none">
                            <span>{{ $cat }}</span>
                            <span class="inline-flex items-center justify-center rounded-full bg-white/20 px-1.5 text-[11px]">{{ $count }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>
                <div class="w-full lg:w-[28rem]">
                    <label class="relative block">
                        <input x-model="q" type="search" placeholder="Cerca applicativi…"
                            class="w-full rounded-2xl border-0 bg-white/95 px-6 py-4 pr-14 text-slate-900 text-base shadow focus:outline-none focus:ring-2 focus:ring-cyan-400" />
                        <x-heroicon-o-magnifying-glass class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 h-6 w-6 text-slate-400" />
                    </label>
                </div>
            </div>
        </div>

        {{-- IN EVIDENZA --}}
        @if($featuredItems->isNotEmpty())
        <section aria-labelledby="in-evidenza" class="mb-12" id="featured-section" x-show="q.trim()===''" x-transition>
            <div class="flex items-center justify-between mb-4">
                <h2 id="in-evidenza" class="text-2xl font-bold">In evidenza</h2>
                <p class="text-sm text-slate-500">Accessi rapidi alle procedure critiche.</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
                @foreach($featuredItems as $item)
                @php
                $title = Str::of($item['title'] ?? 'Applicativo')->title();
                $href = ($item['slug'] ?? '') === 'segnalazioni' ? route('segnalazioni.index') : route('applicativi.show', $item['slug']);
                $iconName = 'heroicon-o-' . ($item['icon'] ?? 'document-text');
                $cat = $item['category'] ?? 'Utility & Servizi';
                $grad = $categoryColors[$cat] ?? 'from-slate-500 to-slate-700 text-white';
                @endphp

                <a href="{{ $href }}" class="app-card app-card--featured group relative overflow-hidden rounded-3xl bg-gradient-to-br {{ $grad }} shadow-lg hover:shadow-xl transition will-change-transform">
                    {{-- Badge categoria in alto a destra --}}
                    <span class="absolute top-3 right-3 sm:top-4 sm:right-4 inline-flex items-center rounded-full bg-white/20 px-2.5 py-1 text-[11px] sm:text-xs font-semibold text-white backdrop-blur">
                        {{ $cat }}
                    </span>

                    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(80%_60%_at_20%_20%,white,transparent),radial-gradient(60%_60%_at_80%_80%,white,transparent)]"></div>
                    <div class="relative p-6 pt-10 pr-10 min-h-[164px] flex items-start gap-5">
                        <div class="rounded-2xl bg-white/15 border border-white/20 size-14 grid place-items-center ring-1 ring-white/20 group-hover:scale-105 transition">
                            <x-dynamic-component :component="$iconName" class="h-7 w-7 text-white" />
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-white text-xl sm:text-[1.25rem] font-semibold leading-snug break-words">{{ $title }}</h3>
                            <p class="text-white/85 text-sm mt-1 line-clamp-3">{{ $item['desc'] ?? '' }}</p>
                            <div class="mt-4 inline-flex items-center gap-1.5 rounded-lg bg-white/15 px-3 py-1 text-sm font-medium text-white group-hover:bg-white/20">
                                Apri <x-heroicon-o-chevron-right class="h-4 w-4" />
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        {{-- LISTA PER CATEGORIA --}}
        <section class="space-y-12">
            @foreach($allByCategory as $cat => $items)
            @php $grad = $categoryColors[$cat] ?? 'from-slate-500 to-slate-700 text-white'; @endphp
            <div x-show="shouldShowCategory('{{ $cat }}')" x-transition>
                <header class="mb-5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center rounded-xl bg-gradient-to-r {{ $grad }} px-3 py-1.5 text-sm font-semibold">{{ $cat }}</span>
                        <span class="text-slate-500 text-sm">{{ $items->count() }} elementi</span>
                    </div>
                </header>

                <div class="grid gap-6 md:grid-cols-2 2xl:grid-cols-3" data-category-grid>
                    @foreach($items as $item)
                    @php
                    $title = Str::of($item['title'] ?? 'Applicativo')->title();
                    $href = ($item['slug'] ?? '') === 'segnalazioni' ? route('segnalazioni.index') : route('applicativi.show', $item['slug']);
                    $iconName = 'heroicon-o-' . ($item['icon'] ?? 'document-text');
                    $descId = 'desc-' . ($item['slug'] ?? Str::random(6));
                    $catGrad = $categoryColors[$item['category']] ?? 'from-slate-500 to-slate-700 text-white';
                    /* ▼▼ usa tinta categoria per icona & wrapper ▼▼ */
                    $iconColor = $categoryIconColors[$item['category']] ?? 'text-slate-700';
                    $iconWrap = $categoryBgTints[$item['category']] ?? 'border-slate-200 bg-slate-50 ring-1 ring-slate-100';
                    @endphp

                    <a href="{{ $href }}" aria-label="Apri {{ $title }}" aria-describedby="{{ $descId }}" class="app-card group rounded-3xl border border-slate-200 bg-white shadow-card hover:shadow-lg hover:-translate-y-0.5 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-300">
                        <div class="p-6 flex items-start gap-5">
                            <div class="size-14 flex items-center justify-center rounded-2xl {{ $iconWrap }}">
                                <x-dynamic-component :component="$iconName" class="h-7 w-7 {{ $iconColor }}" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-3 flex-wrap">
                                    <h3 class="text-lg font-semibold leading-snug break-words flex-1">{{ $title }}</h3>
                                    <span class="shrink-0 inline-flex items-center rounded-full bg-gradient-to-r {{ $catGrad }} px-3 py-1 text-[11px] font-semibold">{{ $item['category'] }}</span>
                                </div>
                                <p id="{{ $descId }}" class="mt-2 text-[15px] text-slate-700 leading-relaxed line-clamp-3">{{ $item['desc'] ?? '' }}</p>
                                <div class="mt-4 inline-flex items-center gap-2 text-sm font-medium text-slate-700">
                                    Apri <x-heroicon-o-chevron-right class="h-4 w-4" />
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endforeach
        </section>

        {{-- EMPTY STATE --}}
        <div id="empty-state" class="hidden rounded-2xl border border-slate-200 bg-white p-8 text-center text-slate-600">
            Nessun risultato trovato per la ricerca.
        </div>
    </div>

    <script defer>
        document.addEventListener('alpine:init', () => {
            Alpine.data('appGrid', () => ({
                q: '',
                activeCategory: null,
                toggleCategory(cat) {
                    this.activeCategory = (this.activeCategory === cat ? null : cat);
                    this.focusSearch(false);
                },
                shouldShowCategory(cat) {
                    return !this.activeCategory || this.activeCategory === cat;
                },
                clearFilters() {
                    this.q = '';
                    this.activeCategory = null;
                    this.focusSearch(true);
                },
                focusSearch(focus) {
                    if (!focus) return;
                    const el = document.querySelector('input[type="search"]');
                    el && el.focus();
                },
                init() {
                    window.addEventListener('keydown', (e) => {
                        if (e.key === '/' && !['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName)) {
                            e.preventDefault();
                            this.focusSearch(true);
                        }
                    });
                }
            }))
        })
    </script>

    <script>
        // Filtra risultati e mostra solo la lista (nasconde 'In evidenza' durante la ricerca)
        const filterCards = () => {
            const input = document.querySelector('input[type="search"]');
            const q = (input?.value || '').toLowerCase().trim();
            const featured = document.getElementById('featured-section');
            if (featured) featured.style.display = q === '' ? '' : 'none';

            // Filtra SOLO le card non-featured
            const cards = Array.from(document.querySelectorAll('.app-card:not(.app-card--featured)'));
            let visibleCount = 0;
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                const match = q === '' || text.includes(q);
                card.style.display = match ? '' : 'none';
                if (match) visibleCount++;
            });

            // Nasconde intere sezioni categoria se non hanno match
            document.querySelectorAll('[data-category-grid]').forEach(grid => {
                const anyVisible = Array.from(grid.querySelectorAll('.app-card')).some(el => el.style.display !== 'none');
                grid.parentElement.style.display = anyVisible ? '' : 'none';
            });

            // Empty state
            const empty = document.getElementById('empty-state');
            if (empty) empty.classList.toggle('hidden', !(q !== '' && visibleCount === 0));
        };

        document.addEventListener('input', (e) => {
            if (e.target.matches('input[type="search"]')) filterCards();
        });
        window.addEventListener('DOMContentLoaded', filterCards);
    </script>
</x-layout>