<x-layout :title="$app['title'] ?? 'Procedura'">
    <div class="container mx-auto px-4 py-10">
        <div class="mb-6">
            <a href="{{ route('applicativi.index') }}" class="text-sm underline">← Torna all'elenco</a>
        </div>

        <h1 class="text-2xl font-bold">{{ $app['title'] }}</h1>
        <p class="mt-2 text-slate-700">{{ $app['desc'] }}</p>

        <div class="mt-6 p-6 rounded-xl border border-slate-200 bg-white">
            [Contenuto o integrazione della procedura: <strong>{{ $app['slug'] }}</strong>]
        </div>
    </div>
</x-layout>