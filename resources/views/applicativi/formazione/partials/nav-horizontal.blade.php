{{-- resources/views/applicativi/formazione/partials/nav-horizontal.blade.php --}}
@php
use Illuminate\Support\Str;

$pages = $pages ?? [];
$currentKey = $currentKey ?? 'corsi';

/**
* Raggruppo per category in modo robusto.
* $grouped = ['Corsi' => ['corsi'=>cfg, ...], ...]
*/
$grouped = [];
foreach ($pages as $slug => $cfg) {
$cat = $cfg['category'] ?? 'Altro';
if (!isset($grouped[$cat])) $grouped[$cat] = [];
$grouped[$cat][$slug] = $cfg;
}

// categoria che contiene lo slug corrente
$currentCategory = null;
foreach ($grouped as $cat => $items) {
if (array_key_exists($currentKey, $items)) { $currentCategory = $cat; break; }
}
// fallback: prima categoria disponibile
if (!$currentCategory) $currentCategory = array_key_first($grouped);

// id html per categoria
$catId = fn($cat) => Str::slug($cat);
@endphp

<nav class="sor-hnav" data-sor-hnav>
    <div class="sor-hnav__top">
        <div class="sor-hnav__title">Categorie</div>

        @if(empty($grouped))
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-3 text-sm">
            ⚠️ Nessuna pagina in <code>$pages</code>. Controlla FormazioneController → show().
        </div>
        @else
        <div class="sor-hnav__cats" role="tablist" aria-label="Categorie">
            @foreach($grouped as $cat => $items)
            @php $active = ($cat === $currentCategory); @endphp
            <button
                type="button"
                class="sor-cat-tab {{ $active ? 'is-active' : '' }}"
                data-sor-cat-tab="{{ $catId($cat) }}"
                role="tab"
                aria-selected="{{ $active ? 'true' : 'false' }}">
                {{ $cat }}
                <span class="sor-cat-tab__count">{{ count($items) }}</span>
            </button>
            @endforeach
        </div>
        @endif
    </div>

    @if(!empty($grouped))
    <div class="sor-hnav__rail" data-sor-hnav-rail tabindex="0" aria-label="Pagine (scroll orizzontale)">
        @foreach($grouped as $cat => $items)
        @php
        $panelId = $catId($cat);
        $active = ($cat === $currentCategory);
        @endphp

        <div
            class="sor-hnav__group {{ $active ? 'is-active' : '' }}"
            data-sor-cat-panel="{{ $panelId }}"
            role="tabpanel">
            @foreach($items as $slug => $cfg)
            @php
            $isActive = ($currentKey === $slug);
            $icon = 'heroicon-o-' . ($cfg['icon'] ?? 'document-text');
            @endphp

            <a
                href="{{ route('formazione.section', ['page' => $slug]) }}"
                class="sor-pill {{ $isActive ? 'is-active' : '' }}"
                aria-current="{{ $isActive ? 'page' : 'false' }}"
                title="{{ $cfg['label'] ?? $slug }}">
                <x-dynamic-component :component="$icon" class="sor-pill__ico" />
                <span class="sor-pill__txt">{{ $cfg['label'] ?? $slug }}</span>
            </a>
            @endforeach
        </div>
        @endforeach
    </div>
    @endif
</nav>