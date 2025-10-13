<x-layout title="Home">
    {{-- Hero con gradiente chiaro --}}
    <div class="relative bg-gradient-to-b from-sky-100 via-white to-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
            <section class="max-w-4xl mx-auto text-center space-y-6">
                <div class="flex justify-center">
                    <img
                        src="{{ asset('images/regione.png') }}"
                        alt="Regione del Veneto"
                        class="w-40 sm:w-48 md:w-56 h-auto object-contain drop-shadow-sm" />
                </div>

                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900">
                    Portale di supporto alla
                    <span class="inline-block bg-gradient-to-r from-sky-600 to-cyan-500 bg-clip-text text-transparent">
                        Protezione Civile del Veneto
                    </span>
                </h1>

                <p class="text-base sm:text-lg text-slate-600 max-w-3xl mx-auto">
                    Informazioni e utilità operative per gli operatori del Sistema Regionale di Protezione Civile.
                </p>

                <div class="text-xs sm:text-sm text-slate-500 max-w-4xl mx-auto">
                    I dati non sostituiscono i dati cartografici ufficiali né quelli presenti nei piani comunali approvati,
                    ma costituiscono uno strumento di supporto per gli Enti del sistema regionale.
                </div>
            </section>

            {{-- Call to action --}}
            <div class="mt-8 sm:mt-10 flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('cartografie.index') }}"
                    class="inline-flex items-center rounded-xl border border-sky-200 bg-white/70 px-4 py-2 text-sm font-medium text-sky-700 shadow-sm hover:shadow-md transition focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-500">
                    Vai alle Cartografie
                </a>
                <a href="{{ route('applicativi.index') }}"
                    class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-sky-500">
                    Apri gli Applicativi
                </a>
            </div>
        </div>
    </div>

    {{-- Sezioni (preview con le card) --}}
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 pb-16 sm:pb-20 mt-8">
        <section class="mx-auto grid gap-6 sm:gap-8 max-w-7xl md:grid-cols-2 lg:gap-10">

            {{-- Card: Cartografie --}}
            <x-section-card
                :href="route('cartografie.index')"
                title="Cartografie"
                subtitle="Vai alla sezione"
                description="Mappe e layer tematici dei piani comunali di Protezione Civile e dataset elaborati dalla Direzione Protezione Civile e Polizia Locale."
                img="images/cartografie.png"
                imgAlt="Cartografie">
                <x-slot:icon>
                    <x-heroicon-o-map class="h-6 w-6 text-sky-700" />
                </x-slot:icon>
            </x-section-card>

            {{-- Card: Applicativi informatici --}}
            <x-section-card
                :href="route('applicativi.index')"
                title="Applicativi informatici"
                subtitle="Vai alla sezione"
                description="Accesso a procedure per la ricerca e gestione delle risorse umane e strumentali. Riservato a volontari formati e utenti accreditati."
                img="images/applicativi.png"
                imgAlt="Applicativi informatici">
                <x-slot:icon>
                    <x-heroicon-o-computer-desktop class="h-6 w-6 text-indigo-700" />
                </x-slot:icon>
            </x-section-card>

        </section>

        {{-- Nota assistenza --}}
        <section class="max-w-7xl mx-auto mt-10 sm:mt-12">
            <div class="rounded-2xl border border-slate-200 bg-white/70 px-4 py-4 sm:px-6 sm:py-5 shadow-sm">
                <p class="text-sm text-slate-600">
                    Hai bisogno di assistenza o non riesci ad accedere agli applicativi? Contatta il referente di Protezione Civile della tua struttura.
                </p>
            </div>
        </section>
    </div>
</x-layout>