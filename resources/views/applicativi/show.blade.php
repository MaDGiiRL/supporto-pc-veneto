<x-layout :title="$app['title'] ?? 'Procedura'">
    <div class="container mx-auto px-4">

        @php($slug = $app['slug'] ?? null)

        {{-- ROUTING VIEW: se esiste una view dedicata, caricala --}}
        @if($slug === 'gestione-formazione')
        @include('applicativi.formazione.index')
        @else
        <h1 class="text-2xl font-bold">{{ $app['title'] }}</h1>
        <p class="mt-2 text-slate-700">{{ $app['desc'] }}</p>

        <div class="mt-6 p-6 rounded-xl border border-slate-200 bg-white">
            [Contenuto o integrazione della procedura: <strong>{{ $slug }}</strong>]
        </div>
        @endif
    </div>
</x-layout>