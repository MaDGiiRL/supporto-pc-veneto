<x-layout title="Segnalazioni">
    <div class="w-full min-h-screen bg-white">
        <div class="grid grid-cols-1 lg:grid-cols-[250px_minmax(0,1fr)] gap-6 p-4">
            {{-- Sidebar --}}
            <aside class="lg:sticky lg:top-6 h-max">
                @include('applicativi.segnalazioni.partials.sidebar', ['pages' => $pages])
            </aside>

            {{-- Pannello contenuti --}}
            <section class="min-h-[calc(100vh-8rem)] overflow-hidden">
                @php($viewName = 'applicativi.segnalazioni.sections.' . ($current['view'] ?? 'placeholder'))
                @includeFirst([$viewName, 'applicativi.segnalazioni.sections.placeholder'], ['page' => $current])
            </section>
        </div>
    </div>
</x-layout>
