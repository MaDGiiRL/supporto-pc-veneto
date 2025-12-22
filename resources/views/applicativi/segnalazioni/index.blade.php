<x-layout title="Segnalazioni" :hideNavbar="true">
    <div class="w-full min-h-screen bg-white">
        <div class="p-4 space-y-4">

            {{-- TOP NAV --}}
            @include('applicativi.segnalazioni.partials.sidebar', [
            'pages' => $pages
            ])

            {{-- Pannello contenuti --}}
            <section class="min-h-[calc(100vh-8rem)] overflow-hidden">
                @php($viewName = 'applicativi.segnalazioni.sections.' . ($current['view'] ?? 'placeholder'))

                @includeFirst(
                [$viewName, 'applicativi.segnalazioni.sections.placeholder'],
                ['page' => $current]
                )
            </section>

        </div>
    </div>
</x-layout>