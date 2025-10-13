@props(['id' => ''])
<div id="{{ $id }}" class="c-modal hidden" aria-hidden="true">
    <div class="c-modal__backdrop" data-close-modal></div>
    <div class="c-modal__dialog" role="dialog" aria-modal="true">
        <button class="c-modal__close" data-close-modal aria-label="Chiudi">×</button>
        {{ $slot }}
    </div>
</div>