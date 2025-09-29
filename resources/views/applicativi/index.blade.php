@php
use Illuminate\Support\Str;
@endphp

<x-layout title="Applicativi informatici">
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold">Procedure informatiche disponibili</h1>
        <p class="text-slate-600 mt-1">Seleziona una procedura per accedere.</p>

        <div class="grid gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($apps as $item)
            @php
            // Title Case pulito
            $title = Str::of($item['title'] ?? 'Applicativo')->lower()->title();

            // Destinazione: "segnalazioni" entra nel modulo con sidebar
            $href = ($item['slug'] ?? '') === 'segnalazioni'
            ? route('segnalazioni.index')
            : route('applicativi.show', $item['slug']);

            // Icona heroicons outline (fallback document-text)
            $iconName = 'heroicon-o-' . ($item['icon'] ?? 'document-text');

            // id per aria-describedby
            $descId = 'desc-' . ($item['slug'] ?? Str::random(6));
            @endphp

            <a href="{{ $href }}"
                aria-label="Apri {{ $title }}"
                aria-describedby="{{ $descId }}"
                class="group block rounded-2xl border border-slate-200 bg-white shadow-card
                          hover:shadow-md hover:-translate-y-0.5 transition
                          focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-300">
                <div class="p-5 flex flex-col h-full">
                    {{-- Header: Icon chip + Title --}}
                    <div class="flex items-center gap-3">
                        <div class="size-11 flex items-center justify-center rounded-xl
                                        border border-slate-200 bg-slate-50">
                            <x-dynamic-component :component="$iconName" class="h-6 w-6 text-slate-700" />
                        </div>

                        <h2 class="text-lg font-semibold leading-tight">
                            {{ $title }}
                        </h2>
                    </div>

                    {{-- Description --}}
                    <p id="{{ $descId }}" class="mt-3 text-slate-700">
                        {{ $item['desc'] ?? '' }}
                    </p>

                    {{-- CTA (solo stile, tutta la card è il link) --}}
                    <div class="mt-5">
                        <span class="inline-flex items-center gap-2 rounded-lg bg-slate-900 text-white
                                         px-4 py-2 font-medium transition
                                         group-hover:bg-slate-800">
                            Apri
                            <x-heroicon-o-chevron-right class="h-4 w-4" />
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</x-layout>