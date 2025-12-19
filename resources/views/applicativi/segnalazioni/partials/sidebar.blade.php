@php
// Raggruppa per categoria preservando gli slug come chiavi
$groups = collect($pages)->groupBy('category', true);

// Slug corrente (può arrivare come $currentKey oppure come $current)
$currentSlug = $currentKey ?? ($current ?? '');
@endphp

<nav class="rounded-2xl border border-slate-200/70 bg-white shadow-sm ring-1 ring-black/5">
    {{-- Header --}}
    <div class="flex items-start justify-between gap-3 p-4 border-b border-slate-100">
        <div>
            <p class="text-sm font-semibold text-slate-900">Sezioni</p>
            <p class="mt-0.5 text-xs text-slate-500">Navigazione rapida delle segnalazioni</p>
        </div>
    </div>

    <div class="p-3">
        @foreach ($groups as $cat => $items)
        <section class="mb-4 last:mb-0">
            {{-- Categoria --}}
            <div class="flex items-center gap-2 px-2">
                <span class="inline-flex h-6 items-center rounded-full bg-slate-50 px-2 text-[11px] font-semibold uppercase tracking-wide text-slate-600 ring-1 ring-slate-200/70">
                    {{ $cat }}
                </span>
                <div class="h-px flex-1 bg-gradient-to-r from-slate-200/70 to-transparent"></div>
            </div>

            <ul class="mt-2 space-y-1">
                @foreach ($items as $slug => $cfg)
                @php
                $active = ($currentSlug === $slug);
                $icon = 'heroicon-o-' . ($cfg['icon'] ?? 'document-text');
                $badge = $cfg['badge'] ?? null; // opzionale: string|int
                @endphp

                <li>
                    <a
                        href="{{ route('segnalazioni.section', ['page' => $slug]) }}"
                        @class([ 'group relative flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition-all' , 'bg-gradient-to-r from-slate-100 to-white font-semibold text-slate-900 ring-1 ring-slate-200 shadow-[0_1px_0_0_rgba(15,23,42,0.04)]'=> $active,
                        'text-slate-700 hover:bg-slate-50 hover:ring-1 hover:ring-slate-200/80 hover:shadow-sm' => ! $active,
                        ])
                        aria-current="{{ $active ? 'page' : 'false' }}"
                        >
                        {{-- Accent bar --}}
                        <span
                            @class([ 'absolute left-0 top-1/2 h-8 w-1 -translate-y-1/2 rounded-r-full transition' , 'bg-slate-900'=> $active,
                            'bg-transparent group-hover:bg-slate-300' => ! $active,
                            ])
                            ></span>

                        {{-- Icon --}}
                        <span
                            @class([ 'grid h-9 w-9 place-items-center rounded-xl ring-1 transition' , 'bg-white ring-slate-200 text-slate-900'=> $active,
                            'bg-slate-50 ring-slate-200/70 text-slate-600 group-hover:bg-white group-hover:text-slate-900' => ! $active,
                            ])
                            >
                            <x-dynamic-component :component="$icon" class="h-5 w-5" />
                        </span>

                        {{-- Label --}}
                        <span class="min-w-0 flex-1">
                            <span class="block truncate">{{ $cfg['label'] }}</span>
                            @if (!empty($cfg['desc']))
                            <span class="mt-0.5 block truncate text-xs font-normal text-slate-500">
                                {{ $cfg['desc'] }}
                            </span>
                            @endif
                        </span>

                        {{-- Badge opzionale --}}
                        @if ($badge !== null && $badge !== '')
                        <span
                            @class([ 'ml-auto inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-semibold ring-1' ,
                            $active
                            ? 'bg-slate-900 text-white ring-slate-900'
                            : 'bg-slate-100 text-slate-700 ring-slate-200 group-hover:bg-slate-200/70' ,
                            ])>
                            {{ $badge }}
                        </span>
                        @endif

                        {{-- Chevron decorativo --}}
                        <svg
                            class="ml-1 h-4 w-4 shrink-0 text-slate-400 transition group-hover:translate-x-0.5 group-hover:text-slate-600"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 0 1 .02-1.06L10.94 10 7.23 6.29a.75.75 0 1 1 1.06-1.06l4.24 4.24a.75.75 0 0 1 0 1.06l-4.24 4.24a.75.75 0 0 1-1.08 0Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </li>
                @endforeach
            </ul>
        </section>
        @endforeach
    </div>

    {{-- Footer (opzionale) --}}
    <div class="border-t border-slate-100 p-3">
        <div class="rounded-xl bg-slate-50 px-3 py-2 text-xs text-slate-600 ring-1 ring-slate-200/70">
            Suggerimento: usa la ricerca o scorri per categoria.
        </div>
    </div>
</nav>