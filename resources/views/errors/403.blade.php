<x-layout title="Accesso non autorizzato">
    <div class="min-h-[100vh] flex flex-col items-center justify-center px-6 text-center">

        <div class="mb-6">
            <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 border border-red-200">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3m0 3h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                </svg>
            </span>
        </div>

        <h1 class="text-2xl font-semibold text-slate-900">
            Accesso non autorizzato
        </h1>

        <p class="mt-2 text-slate-600 max-w-lg">
            Il tuo account è registrato, ma non risulta ancora abilitato all'accesso
            a questa sezione del portale.
        </p>

        <p class="mt-1 text-slate-500 text-sm max-w-md">
            Per procedere, contatta il supporto indicando il tuo nome, cognome ed ente di appartenenza.
        </p>

        <div class="mt-6">
            <a href="mailto:sofia.vidotto@regione.veneto.it"
                class="inline-flex items-center rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
                Contatta il supporto
            </a>
        </div>

        <div class="mt-10">
            <a href="{{ route('home') }}"
                class="text-sm text-slate-500 hover:text-slate-700 underline">
                Torna alla homepage
            </a>
        </div>
    </div>
</x-layout>