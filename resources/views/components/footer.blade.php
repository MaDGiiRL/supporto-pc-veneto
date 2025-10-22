<footer class="mt-16 border-t border-slate-200/70 bg-white/70 backdrop-blur supports-[backdrop-filter]:bg-white/60">
    <div class="container mx-auto px-4">
        {{-- Riga principale --}}
        <div class="py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            {{-- Brand coerente con la navbar --}}
            <div class="flex items-center gap-2 text-slate-900">
                <span class="inline-grid place-items-center rounded-xl bg-gradient-to-br from-sky-500 to-cyan-600 text-white p-1.5 shadow-sm ring-1 ring-sky-500/30">
                    <x-heroicon-o-shield-check class="h-5 w-5" />
                </span>
                <span class="text-sm font-semibold tracking-tight">Supporto PC Veneto</span>
            </div>

            {{-- Azioni: privacy + credits --}}
            <div class="flex items-center flex-wrap gap-4">
                {{-- Bottone Privacy --}}
                <button type="button"
                    data-privacy-open="privacy-modal"
                    class="inline-flex items-center gap-2 underline decoration-sky-400/60 underline-offset-2 hover:text-sky-600 transition text-sm"
                    aria-controls="privacy-modal">
                    <x-heroicon-o-document-text class="h-4 w-4 text-slate-400" />
                    <span>Informativa Privacy</span>
                </button>

                {{-- Credits --}}
                <p class="text-xs sm:text-sm text-slate-600 text-center sm:text-right">
                    Developed with <span aria-hidden="true">🤍</span> by
                    <strong>
                        <a href="https://www.linkedin.com/in/sofia-vidotto-junior-developer/" target="_blank" rel="noreferrer"
                            class="inline-flex items-center gap-1 underline decoration-sky-400/60 underline-offset-2 hover:text-sky-600">
                            Sofia Vidotto
                            <x-heroicon-o-arrow-top-right-on-square class="h-3.5 w-3.5 text-slate-400" />
                        </a>
                    </strong>
                </p>
            </div>
        </div>

        {{-- Riga legale --}}
        <div class="pb-6 pt-0">
            <p class="text-center sm:text-left text-[11px] sm:text-xs text-slate-500">
                © {{ now()->year }} Regione del Veneto — Direzione Protezione Civile e Polizia Locale · Ufficio Pianificazione. Tutti i diritti riservati.
            </p>
        </div>
    </div>
</footer>

{{-- Modale Privacy (fuori dal footer per compatibilità con blur/z-index) --}}
<x-privacy-modal modalId="privacy-modal" />

{{-- JS per apertura/chiusura modale --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Apri
        document.querySelectorAll('[data-privacy-open]').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-privacy-open');
                const modal = document.getElementById(id);
                if (!modal) return;
                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
                document.documentElement.style.overflow = 'hidden';
            });
        });

        // Chiudi (click overlay o pulsante)
        document.addEventListener('click', (e) => {
            const closeBtn = e.target.closest('[data-privacy-close]');
            const overlay = e.target.matches('[data-privacy-overlay]');
            if (!closeBtn && !overlay) return;

            const modal = (closeBtn ? closeBtn.closest('[role="dialog"]') : e.target.closest('[role="dialog"]'));
            if (!modal) return;
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
            document.documentElement.style.overflow = '';
        });

        // Chiudi con ESC
        document.addEventListener('keydown', (e) => {
            if (e.key !== 'Escape') return;
            const openModal = document.querySelector('[role="dialog"]:not(.hidden)');
            if (!openModal) return;
            openModal.classList.add('hidden');
            openModal.setAttribute('aria-hidden', 'true');
            document.documentElement.style.overflow = '';
        });
    });
</script>