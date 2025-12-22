{{-- resources/views/applicativi/segnalazioni/partials/sidebar.blade.php --}}

@php
$pages = $pages ?? [];

$currentKey = request()->route('page') ?? 'dashboard';
if (!array_key_exists($currentKey, $pages)) {
$currentKey = 'dashboard';
}

$currentPage = $pages[$currentKey] ?? [];
$currentLabel = $currentPage['label'] ?? $currentPage['title'] ?? 'Dashboard';

$currentIcon = $currentPage['icon'] ?? 'document-text';
$currentIconComponent = 'heroicon-o-' . $currentIcon;
@endphp

<div class="rounded-2xl border border-slate-200 bg-white shadow-card overflow-hidden">

    {{-- Header compatto + CTA a destra --}}
    <div class="px-4 py-3 bg-slate-50 border-b border-slate-200 flex items-center justify-between gap-3">
        <div class="min-w-0 flex items-center gap-3">
            <span class="grid place-items-center w-10 h-10 rounded-xl border border-slate-200 bg-white">
                <x-dynamic-component :component="$currentIconComponent" class="w-5 h-5 text-brand-600" />
            </span>

            <div class="min-w-0">
                <div class="text-[11px] uppercase tracking-wide text-slate-500">Segnalazioni</div>
                <div class="text-sm font-semibold text-slate-900 truncate">{{ $currentLabel }}</div>
            </div>
        </div>

        {{-- Pulsante a destra --}}
        <a
            href="{{ route('applicativi.index') }}"
            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700
                   hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-400">
            <x-heroicon-o-arrow-left class="w-4 h-4 text-slate-500" />
        </a>
    </div>

    {{-- Tabs/pill scroll orizzontale --}}
    <div class="relative">
        {{-- gradient left --}}
        <div id="seg-grad-left"
            class="pointer-events-none absolute left-0 top-0 h-full w-10 opacity-0 transition-opacity duration-200
                    bg-gradient-to-r from-white to-transparent">
        </div>

        {{-- gradient right --}}
        <div id="seg-grad-right"
            class="pointer-events-none absolute right-0 top-0 h-full w-10 opacity-0 transition-opacity duration-200
                    bg-gradient-to-l from-white to-transparent">
        </div>

        <div id="seg-tabs"
            class="px-2 py-2 overflow-x-auto scroll-smooth"
            style="-ms-overflow-style:none; scrollbar-width:none;">
            <style>
                #seg-tabs::-webkit-scrollbar {
                    display: none;
                }
            </style>

            <div class="flex items-center gap-2 min-w-max">
                @foreach($pages as $k => $p)
                @php
                $href = $p['href'] ?? route('segnalazioni.section', ['page' => $k]);
                $isActive = ($k === $currentKey);

                $icon = $p['icon'] ?? 'document-text';
                $iconComponent = 'heroicon-o-' . $icon;

                $label = $p['label'] ?? $p['title'] ?? $k;
                @endphp

                <a
                    href="{{ $href }}"
                    data-seg-tab="{{ $isActive ? 'active' : '0' }}"
                    aria-current="{{ $isActive ? 'page' : 'false' }}"
                    class="
                            inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold border transition
                            whitespace-nowrap
                            focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-400
                            {{ $isActive
                                ? 'bg-brand-500 border-brand-500 text-white'
                                : 'bg-white border-slate-200 text-slate-700 hover:bg-slate-50'
                            }}
                        ">
                    <x-dynamic-component
                        :component="$iconComponent"
                        class="w-4 h-4 {{ $isActive ? 'text-white' : 'text-brand-600' }}" />
                    <span class="truncate max-w-[14rem]">{{ $label }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>

</div>

<script>
    (function() {
        const scroller = document.getElementById('seg-tabs');
        const gradL = document.getElementById('seg-grad-left');
        const gradR = document.getElementById('seg-grad-right');
        if (!scroller || !gradL || !gradR) return;

        function updateGradients() {
            const maxScroll = scroller.scrollWidth - scroller.clientWidth;

            if (maxScroll <= 1) {
                gradL.classList.add('opacity-0');
                gradR.classList.add('opacity-0');
                return;
            }

            if (scroller.scrollLeft > 4) gradL.classList.remove('opacity-0');
            else gradL.classList.add('opacity-0');

            if (scroller.scrollLeft < maxScroll - 4) gradR.classList.remove('opacity-0');
            else gradR.classList.add('opacity-0');
        }

        function scrollToActive() {
            const active = scroller.querySelector('[data-seg-tab="active"]');
            if (!active) return;

            const left = active.offsetLeft - (scroller.clientWidth / 2) + (active.clientWidth / 2);
            scroller.scrollTo({
                left: Math.max(0, left),
                behavior: 'instant'
            });
        }

        scrollToActive();
        updateGradients();

        scroller.addEventListener('scroll', updateGradients, {
            passive: true
        });
        window.addEventListener('resize', () => {
            scrollToActive();
            updateGradients();
        });

        setTimeout(() => {
            scrollToActive();
            updateGradients();
        }, 80);
    })();
</script>