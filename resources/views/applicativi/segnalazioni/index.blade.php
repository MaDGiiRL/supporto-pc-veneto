<x-layout title="Segnalazioni">
    <div class="w-full min-h-screen bg-white">
        <header class="px-8 pt-8 mb-4">
            <h1 class="text-2xl font-bold">Segnalazioni</h1>
        </header>

        <div class="px-8 pb-10 space-y-4">

            {{-- NAV ORIZZONTALE --}}
            @include('applicativi.segnalazioni.partials.nav-horizontal', [
            'pages' => $pages,
            'currentKey' => $currentKey ?? null,
            'current' => $current ?? null,
            ])

            {{-- CONTENUTO --}}
            <section class="sor-content-panel">
                @php($viewName = 'applicativi.segnalazioni.sections.' . ($current['view'] ?? 'placeholder'))
                @includeFirst([$viewName, 'applicativi.segnalazioni.sections.placeholder'], ['page' => $current])
            </section>

        </div>
    </div>

    @push('scripts')
    <script type="module">
        // NAV ORIZZONTALE: drag-to-scroll + wheel->horizontal + keyboard
        (() => {
            const root = document.querySelector('[data-sor-hnav]');
            if (!root) return;

            const rail = root.querySelector('[data-sor-hnav-rail]');
            if (!rail) return;

            // ---------- wheel: vertical wheel -> horizontal scroll ----------
            rail.addEventListener('wheel', (e) => {
                // se l'utente sta facendo shift+wheel, lasciamo nativo
                if (e.shiftKey) return;

                // se non c'è overflow, non blocchiamo
                const canScroll = rail.scrollWidth > rail.clientWidth + 2;
                if (!canScroll) return;

                // evita scroll verticale pagina mentre passi sulla nav
                e.preventDefault();
                rail.scrollLeft += (e.deltaY || e.deltaX);
            }, {
                passive: false
            });

            // ---------- drag-to-scroll ----------
            let isDown = false;
            let startX = 0;
            let startLeft = 0;

            const down = (clientX) => {
                isDown = true;
                startX = clientX;
                startLeft = rail.scrollLeft;
                rail.classList.add('is-dragging');
            };

            const move = (clientX) => {
                if (!isDown) return;
                const dx = clientX - startX;
                rail.scrollLeft = startLeft - dx;
            };

            const up = () => {
                isDown = false;
                rail.classList.remove('is-dragging');
            };

            rail.addEventListener('mousedown', (e) => {
                // evita selezione testo mentre trascini
                e.preventDefault();
                down(e.clientX);
            });

            window.addEventListener('mousemove', (e) => move(e.clientX));
            window.addEventListener('mouseup', up);

            // touch
            rail.addEventListener('touchstart', (e) => {
                if (!e.touches?.length) return;
                down(e.touches[0].clientX);
            }, {
                passive: true
            });

            rail.addEventListener('touchmove', (e) => {
                if (!e.touches?.length) return;
                move(e.touches[0].clientX);
            }, {
                passive: true
            });

            rail.addEventListener('touchend', up, {
                passive: true
            });

            // ---------- keyboard (accessibilità) ----------
            rail.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowRight') rail.scrollLeft += 80;
                if (e.key === 'ArrowLeft') rail.scrollLeft -= 80;
            });

            // ---------- auto-scroll: porta il tab attivo in vista ----------
            const active = rail.querySelector('[aria-current="page"]');
            if (active) {
                const r = active.getBoundingClientRect();
                const rr = rail.getBoundingClientRect();
                if (r.left < rr.left || r.right > rr.right) {
                    active.scrollIntoView({
                        behavior: 'smooth',
                        inline: 'center',
                        block: 'nearest'
                    });
                }
            }
        })();
    </script>
    @endpush
</x-layout>