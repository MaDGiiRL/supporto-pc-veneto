<x-layout title="Applicativi informatici">
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold">Procedure informatiche disponibili</h1>
        <p class="text-gray-600 mt-1">Seleziona una procedura per accedere.</p>

        <div class="grid gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($apps as $item)
            <a href="{{ route('applicativi.show', $item['slug']) }}"
                class="bg-white rounded-2xl border border-slate-200 shadow-card p-5 hover:shadow-md transition flex flex-col">
                <h2 class="text-lg font-semibold">{{ $item['title'] }}</h2>
                <p class="mt-2 text-slate-700">{{ $item['desc'] }}</p>
                <span class="mt-auto inline-flex items-center justify-start text-sm font-medium underline">Apri</span>
            </a>
            @endforeach
        </div>
    </div>
</x-layout>