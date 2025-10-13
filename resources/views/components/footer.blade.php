<footer class="mt-16">
    <div class="container py-6 text-xs sm:text-sm flex flex-col sm:flex-row items-center justify-between gap-3">
        <p class="text-center sm:text-left">
            © All rights reserved. Regione del Veneto Direzione Protezione Civile e Polizia Locale - Ufficio Pianificazione.
        </p>
        <div class="flex items-center gap-4">
            <button type="button" data-privacy-open="privacy-modal" class="underline hover:text-sky-600 transition">
                Informativa Privacy
            </button>
            <p class="text-center sm:text-right">
                Developed with 🤍 by
                <strong><a href="https://www.instagram.com/madgiirl99/" target="_blank" rel="noreferrer">MaDGiiRL</a></strong>
            </p>
        </div>
    </div>

    {{-- istanza della modale nel footer --}}
    <x-privacy-modal modalId="privacy-modal" />
</footer>