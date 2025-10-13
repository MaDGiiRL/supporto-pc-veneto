<x-layout title="Segnalazioni">
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold mb-4">Segnalazioni</h1>

        <div class="grid grid-cols-1 lg:grid-cols-[280px_minmax(0,1fr)] gap-6">
            {{-- Sidebar --}}
            <aside class="lg:sticky lg:top-6 h-max">
                @include('applicativi.segnalazioni.partials.sidebar', ['pages' => $pages])
            </aside>

            {{-- Pannello contenuti --}}
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm min-h-[60vh] overflow-hidden">
                @php($viewName = 'applicativi.segnalazioni.sections.' . ($current['view'] ?? 'placeholder'))
                @includeFirst([$viewName, 'applicativi.segnalazioni.sections.placeholder'], ['page' => $current])
            </section>
        </div>
    </div>
</x-layout>