@php
// Raggruppa per categoria preservando gli slug
$groups = collect($pages)->groupBy('category', true);

// slug corrente
$currentSlug = $currentKey ?? ($current['slug'] ?? ($current ?? ''));

// categoria corrente (se esiste)
$currentCategory = null;
foreach ($groups as $cat => $items) {
if ($items->has($currentSlug)) { $currentCategory = $cat; break; }
}

// fallback
if (!$currentCategory) $currentCategory = $groups->keys()->first();
@endphp

<nav class="sor-hnav" data-sor-hnav>
    <div class="sor-hnav__top">
        <div class="sor-hnav__title">Categorie</div>

        {{-- Tabs categoria --}}
        <div class="sor-hnav__cats" role="tablist" aria-label="Categorie">
            @foreach($groups as $cat => $items)
            @php $activeCat = ($cat === $currentCategory); @endphp
            <button
                type="button"
                class="sor-cat-tab {{ $activeCat ? 'is-active' : '' }}"
                data-sor-cat-tab="{{ \Illuminate\Support\Str::slug($cat) }}"
                role="tab"
                aria-selected="{{ $activeCat ? 'true' : 'false' }}">
                {{ $cat }}
                <span class="sor-cat-tab__count">{{ $items->count() }}</span>
            </button>
            @endforeach
        </div>
    </div>

    {{-- rail scrollabile (una riga) --}}
    <div class="sor-hnav__rail" data-sor-hnav-rail tabindex="0" aria-label="Pagine (scroll orizzontale)">
        @foreach($groups as $cat => $items)
        @php
        $catId = \Illuminate\Support\Str::slug($cat);
        $activeCat = ($cat === $currentCategory);
        @endphp

        <div class="sor-hnav__group {{ $activeCat ? 'is-active' : '' }}" data-sor-cat-panel="{{ $catId }}" role="tabpanel">
            @foreach($items as $slug => $cfg)
            @php
            $active = ($currentSlug === $slug);
            $icon = 'heroicon-o-' . ($cfg['icon'] ?? 'document-text');
            @endphp

            <a
                href="{{ route('segnalazioni.section', ['page' => $slug]) }}"
                class="sor-pill {{ $active ? 'is-active' : '' }}"
                aria-current="{{ $active ? 'page' : 'false' }}"
                title="{{ $cfg['label'] }}">
                <x-dynamic-component :component="$icon" class="sor-pill__ico" />
                <span class="sor-pill__txt">{{ $cfg['label'] }}</span>
            </a>
            @endforeach
        </div>
        @endforeach
    </div>

    {{-- JS tabs categorie (mostra/occulta gruppi senza rifare pagina) --}}
    <script type="module">
        (() => {
            const nav = document.querySelector('[data-sor-hnav]');
            if (!nav) return;

            const tabs = Array.from(nav.querySelectorAll('[data-sor-cat-tab]'));
            const panels = Array.from(nav.querySelectorAll('[data-sor-cat-panel]'));
            const rail = nav.querySelector('[data-sor-hnav-rail]');

            const setActive = (catId) => {
                tabs.forEach(t => {
                    const on = t.dataset.sorCatTab === catId;
                    t.classList.toggle('is-active', on);
                    t.setAttribute('aria-selected', on ? 'true' : 'false');
                });

                panels.forEach(p => {
                    const on = p.dataset.sorCatPanel === catId;
                    p.classList.toggle('is-active', on);
                    // quando cambi categoria, rimetti lo scroll all'inizio (poi puoi cambiare in "center")
                    if (on && rail) rail.scrollLeft = 0;
                });
            };

            tabs.forEach(t => {
                t.addEventListener('click', () => setActive(t.dataset.sorCatTab));
            });

            // init: attiva quello già marcato in blade, altrimenti primo
            const init = tabs.find(t => t.classList.contains('is-active'))?.dataset.sorCatTab ||
                tabs[0]?.dataset.sorCatTab;
            if (init) setActive(init);
        })();
    </script>
</nav>