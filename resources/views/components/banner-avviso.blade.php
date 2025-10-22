@props([
'dataLimite' => '01/01/2026', // data predefinita modificabile
])

<div id="banner-avviso"
    class="fixed top-0 inset-x-0 z-50 border-b border-sky-200 bg-gradient-to-r from-sky-50 via-cyan-50 to-white/90 backdrop-blur supports-[backdrop-filter]:bg-white/60 shadow-sm transition-all duration-500 ease-in-out">
    <div class="container mx-auto px-4 py-2 sm:py-2.5 flex flex-col sm:flex-row items-center justify-center sm:justify-between gap-2 text-xs sm:text-sm text-slate-700">
        <div class="flex items-center gap-2 text-center sm:text-left">
            <span class="inline-flex items-center justify-center rounded-full bg-sky-500/10 p-1.5 ring-1 ring-sky-400/30">
                <x-heroicon-o-information-circle class="h-4 w-4 text-sky-600" />
            </span>
            <p>
                Per i documenti e le comunicazioni <strong>precedenti al {{ $dataLimite }}</strong>, consultare il gestionale precedente:
                <a href="https://gestionale.supportopcveneto.it/index.php"
                    target="_blank" rel="noreferrer"
                    class="font-medium underline decoration-sky-400/60 underline-offset-2 hover:text-sky-700">
                    gestionale.supportopcveneto.it
                </a>
            </p>
        </div>

        <button type="button"
            class="inline-flex items-center gap-1 rounded-md border border-transparent px-2 py-1 text-[11px] text-slate-500 hover:text-slate-700 transition"
            onclick="chiudiBannerAvviso()"
            aria-label="Chiudi banner">
            <x-heroicon-o-x-mark class="h-3.5 w-3.5" />
            Chiudi
        </button>
    </div>
</div>

{{-- Spazio compensativo, rimosso automaticamente al close --}}
<div id="banner-spacer" class="h-[46px] sm:h-[48px] transition-all duration-500 ease-in-out"></div>

<script>
    function chiudiBannerAvviso() {
        const banner = document.getElementById('banner-avviso');
        const spacer = document.getElementById('banner-spacer');

        if (banner) {
            banner.classList.add('opacity-0', '-translate-y-full');
            setTimeout(() => banner.remove(), 400);
        }

        if (spacer) {
            spacer.classList.add('opacity-0', 'h-0');
            setTimeout(() => spacer.remove(), 400);
        }
    }
</script>