@php
// Raggruppa per categoria **preservando gli slug come chiavi**
$groups = collect($pages)->groupBy('category', true);

// Slug corrente (può arrivare come $currentKey oppure come $current)
$currentSlug = $currentKey ?? ($current ?? '');
@endphp

<nav class="rounded-2xl border border-slate-200 bg-white shadow-sm p-3">
    @foreach ($groups as $cat => $items)
    <div class="mb-3">
        <p class="px-2 pb-1 text-xs font-semibold uppercase tracking-wide text-slate-500">
            {{ $cat }}
        </p>

        <ul class="space-y-1">
            @foreach ($items as $slug => $cfg)
            @php
            $active = ($currentSlug === $slug);
            $icon = 'heroicon-o-' . ($cfg['icon'] ?? 'document-text');
            @endphp

            <li>
                <a href="{{ route('segnalazioni.section', ['page' => $slug]) }}"
                    @class([ 'flex items-center gap-2 rounded-lg px-2 py-2 text-sm' , 'bg-slate-100 font-semibold text-slate-900'=> $active,
                    'text-slate-700 hover:bg-slate-50' => ! $active,
                    ])
                    aria-current="{{ $active ? 'page' : 'false' }}">
                    <x-dynamic-component :component="$icon" class="h-5 w-5 shrink-0" />
                    <span class="truncate">{{ $cfg['label'] }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    @endforeach
</nav>