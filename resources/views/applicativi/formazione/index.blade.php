{{-- resources/views/applicativi/formazione/index.blade.php --}}
@php
use Illuminate\Support\Str;

$currentKey = $currentKey ?? (request()->route('page') ?? 'corsi');
$pages = $pages ?? [];
$current = $current ?? ($pages[$currentKey] ?? null);

$canManageCourses = true;
$canEditPresenze = true;

$backUrl = url()->previous();
if (!$backUrl || Str::contains($backUrl, '/login')) {
$backUrl = route('applicativi.index');
}
@endphp

{{-- SE USI IL LAYOUT A SLOT: avvolgi tutto così --}}
<x-layout title="Gestione formazione" :hideFooter="false">

    <div class="w-full min-h-screen bg-white">
        <header class="px-8 pt-8 mb-4">
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div>
                    <h1 class="text-2xl font-bold">Gestione formazione</h1>
                    <p class="mt-1 text-sm text-slate-600">
                        Corsi, iscrizioni, presenze, distanze, export e controlli.
                    </p>

                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="badge badge-ok">
                            <x-heroicon-o-check-badge class="h-4 w-4" />
                            Coordinatore: gestione corsi
                        </span>
                        <span class="badge badge-ok">
                            <x-heroicon-o-clock class="h-4 w-4" />
                            Modifica presenze abilitata
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ $backUrl }}" class="btn btn-light">
                        <x-heroicon-o-arrow-left class="h-4 w-4" />
                        Indietro
                    </a>
                    <a href="{{ route('applicativi.index') }}" class="btn btn-light">
                        <x-heroicon-o-squares-2x2 class="h-4 w-4" />
                        Applicativi
                    </a>
                </div>
            </div>
        </header>

        <div class="px-8 pb-10 space-y-4">

            {{-- NAV ORIZZONTALE --}}
            @include('applicativi.formazione.partials.nav-horizontal', [
            'pages' => $pages,
            'currentKey' => $currentKey,
            'current' => $current,
            ])

            {{-- CONTENUTO --}}
            <section class="sor-content-panel">
                @php($viewName = 'applicativi.formazione.sections.' . ($currentKey ?? 'corsi'))
                @includeFirst([$viewName, 'applicativi.formazione.sections.corsi'], [
                'page' => $current,
                'canManageCourses' => $canManageCourses,
                'canEditPresenze' => $canEditPresenze,
                ])
            </section>

            {{-- MODALS --}}
            @include('applicativi.formazione.partials.modals')
        </div>
    </div>

    {{-- STILI: se vuoi inline anche questi, includi qui --}}
    @include('applicativi.formazione.partials.styles')

    {{-- SCRIPT INLINE (NO PUSH) --}}
    <script>
        (function() {
            console.log('✅ Formazione index scripts loaded');

            // ====== NAV: wheel->horizontal + drag + keyboard + autoscroll active ======
            const root = document.querySelector('[data-sor-hnav]');
            if (root) {
                const rail = root.querySelector('[data-sor-hnav-rail]');
                if (rail) {
                    rail.addEventListener('wheel', (e) => {
                        if (e.shiftKey) return;
                        const canScroll = rail.scrollWidth > rail.clientWidth + 2;
                        if (!canScroll) return;
                        e.preventDefault();
                        rail.scrollLeft += (e.deltaY || e.deltaX);
                    }, {
                        passive: false
                    });

                    let isDown = false,
                        startX = 0,
                        startLeft = 0;
                    const down = (x) => {
                        isDown = true;
                        startX = x;
                        startLeft = rail.scrollLeft;
                        rail.classList.add('is-dragging');
                    };
                    const move = (x) => {
                        if (!isDown) return;
                        rail.scrollLeft = startLeft - (x - startX);
                    };
                    const up = () => {
                        isDown = false;
                        rail.classList.remove('is-dragging');
                    };

                    rail.addEventListener('mousedown', (e) => {
                        e.preventDefault();
                        down(e.clientX);
                    });
                    window.addEventListener('mousemove', (e) => move(e.clientX));
                    window.addEventListener('mouseup', up);

                    rail.addEventListener('touchstart', (e) => {
                        if (e.touches?.length) down(e.touches[0].clientX);
                    }, {
                        passive: true
                    });
                    rail.addEventListener('touchmove', (e) => {
                        if (e.touches?.length) move(e.touches[0].clientX);
                    }, {
                        passive: true
                    });
                    rail.addEventListener('touchend', up, {
                        passive: true
                    });

                    rail.addEventListener('keydown', (e) => {
                        if (e.key === 'ArrowRight') rail.scrollLeft += 80;
                        if (e.key === 'ArrowLeft') rail.scrollLeft -= 80;
                    });

                    const active = rail.querySelector('[aria-current="page"]');
                    if (active) active.scrollIntoView({
                        behavior: 'smooth',
                        inline: 'center',
                        block: 'nearest'
                    });
                }

                // ====== CATEGORIE: switch pannello pill ======
                const catTabs = Array.from(root.querySelectorAll('[data-sor-cat-tab]'));
                const catPanels = Array.from(root.querySelectorAll('[data-sor-cat-panel]'));
                const setActive = (catId) => {
                    catTabs.forEach(t => {
                        const on = t.dataset.sorCatTab === catId;
                        t.classList.toggle('is-active', on);
                        t.setAttribute('aria-selected', on ? 'true' : 'false');
                    });
                    catPanels.forEach(p => {
                        const on = p.dataset.sorCatPanel === catId;
                        p.classList.toggle('is-active', on);
                        if (on && rail) rail.scrollLeft = 0;
                    });
                };

                if (catTabs.length && catPanels.length) {
                    catTabs.forEach(t => t.addEventListener('click', () => setActive(t.dataset.sorCatTab)));
                    const init = catTabs.find(t => t.classList.contains('is-active'))?.dataset.sorCatTab || catTabs[0].dataset.sorCatTab;
                    setActive(init);
                }
            }

            // ====== MODALI: open/close + ESC ======
            const openModal = (sel) => {
                const m = document.querySelector(sel);
                if (!m) return;
                m.classList.remove('hidden');
                m.setAttribute('aria-hidden', 'false');
                document.documentElement.classList.add('overflow-hidden');
            };

            const closeModal = (m) => {
                if (!m) return;
                m.classList.add('hidden');
                m.setAttribute('aria-hidden', 'true');
                document.documentElement.classList.remove('overflow-hidden');
            };

            document.addEventListener('click', (e) => {
                const btn = e.target.closest('[data-open-modal]');
                if (!btn) return;
                e.preventDefault();
                openModal(btn.getAttribute('data-open-modal'));
            });

            document.addEventListener('click', (e) => {
                const closeBtn = e.target.closest('[data-close-modal]');
                if (!closeBtn) return;
                const modal = e.target.closest('.c-modal');
                closeModal(modal);
            });

            document.addEventListener('keydown', (e) => {
                if (e.key !== 'Escape') return;
                const open = document.querySelector('.c-modal:not(.hidden)');
                if (open) closeModal(open);
            });

        })();
    </script>

</x-layout>