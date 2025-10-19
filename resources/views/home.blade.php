<x-layout title="Home">
    <header class="relative overflow-hidden bg-gradient-to-b from-sky-50 via-white to-white">
        <div aria-hidden="true" class="pointer-events-none absolute -top-24 -left-24 h-80 w-80 rounded-full bg-sky-200/30 blur-3xl"></div>
        <div aria-hidden="true" class="pointer-events-none absolute -top-52 -right-20 h-96 w-96 rounded-full bg-cyan-200/30 blur-3xl"></div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-24">
            <div class="mx-auto max-w-6xl grid lg:grid-cols-[1.1fr_0.9fr] gap-12 items-center">
                <div>
                    <img src="{{ asset('images/regione.png') }}" alt="Regione del Veneto"
                        class="w-36 sm:w-44 md:w-52 h-auto object-contain drop-shadow-sm" />

                    <h1 class="mt-8 text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900">
                        Portale di supporto alla
                        <span class="inline-block bg-gradient-to-r from-sky-700 to-cyan-600 bg-clip-text text-transparent">
                            Protezione Civile del Veneto
                        </span>
                    </h1>

                    <p class="mt-4 text-base sm:text-lg text-slate-600 max-w-2xl">
                        Strumenti operativi e risorse digitali per gli operatori del Sistema Regionale di Protezione Civile.
                    </p>

                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        <a href="{{ route('cartografie.index') }}"
                            class="inline-flex items-center gap-2 rounded-xl border border-sky-200 bg-white px-4 py-2 text-sm font-medium text-sky-700 shadow-sm hover:shadow-md hover:bg-sky-50 transition">
                            <x-heroicon-o-map class="h-5 w-5" /> Cartografie
                        </a>
                        <a href="{{ route('applicativi.index') }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700 transition">
                            <x-heroicon-o-computer-desktop class="h-5 w-5" /> Applicativi
                        </a>
                    </div>

                    <p class="mt-6 text-xs sm:text-sm text-slate-500 max-w-3xl">
                        I dati non sostituiscono quelli ufficiali né i piani comunali approvati, ma costituiscono uno strumento di supporto per gli Enti del sistema regionale.
                    </p>
                </div>

                {{-- Pannello di contesto (immagine) --}}
                <div class="relative">
                    <div class="rounded-3xl border border-slate-200 bg-white/70 backdrop-blur p-3 shadow-sm">
                        <div class="aspect-[3/3] w-full overflow-hidden rounded-2xl ring-1 ring-slate-200">
                            <img src="{{ asset('images/header.png') }}" alt="Panoramica"
                                class="h-full w-full object-cover object-center" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- SEZIONI colorate con immagine sfumata di sfondo --}}
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 pb-20 mt-10">
        <div class="mx-auto max-w-7xl grid gap-10 md:grid-cols-2 lg:gap-12">

            {{-- Cartografie --}}
            <a href="{{ route('cartografie.index') }}"
                class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-sky-500 to-cyan-600 shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 min-h-[340px]">
                {{-- immagine di sfondo con trasparenza --}}
                <div class="absolute inset-0 opacity-20">
                    <img src="{{ asset('images/cartografie.png') }}" class="w-full h-full object-cover object-center" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
                </div>

                <div class="relative z-10 p-8 flex flex-col justify-between h-full">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="rounded-xl bg-white/20 border border-white/25 p-3">
                            <x-heroicon-o-map class="h-6 w-6 text-white" />
                        </div>
                        <h2 class="text-white text-2xl font-bold leading-tight">Cartografie</h2>
                    </div>

                    <p class="text-white/90 text-sm leading-relaxed mb-6">
                        Mappe e layer tematici dei piani comunali di Protezione Civile e dataset elaborati dalla Direzione Protezione Civile e Polizia Locale.
                    </p>

                    <div class="inline-flex items-center gap-2 rounded-lg bg-white/20 px-3 py-1.5 text-sm font-medium text-white group-hover:bg-white/25 transition self-start">
                        Vai alla sezione <x-heroicon-o-chevron-right class="h-4 w-4" />
                    </div>
                </div>
            </a>

            {{-- Applicativi --}}
            <a href="{{ route('applicativi.index') }}"
                class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-500 to-violet-600 shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 min-h-[340px]">
                <div class="absolute inset-0 opacity-20">
                    <img src="{{ asset('images/applicativi.png') }}" class="w-full h-full object-cover object-center" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/25 via-transparent to-transparent"></div>
                </div>

                <div class="relative z-10 p-8 flex flex-col justify-between h-full">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="rounded-xl bg-white/20 border border-white/25 p-3">
                            <x-heroicon-o-computer-desktop class="h-6 w-6 text-white" />
                        </div>
                        <h2 class="text-white text-2xl font-bold leading-tight">Applicativi informatici</h2>
                    </div>

                    <p class="text-white/90 text-sm leading-relaxed mb-6">
                        Accesso a procedure per la gestione delle risorse umane e strumentali, riservato a utenti accreditati e volontari formati.
                    </p>

                    <div class="inline-flex items-center gap-2 rounded-lg bg-white/20 px-3 py-1.5 text-sm font-medium text-white group-hover:bg-white/25 transition self-start">
                        Vai alla sezione <x-heroicon-o-chevron-right class="h-4 w-4" />
                    </div>
                </div>
            </a>
        </div>

        {{-- Assistenza --}}
        <section id="assistenza" class="max-w-7xl mx-auto mt-14 sm:mt-16">
            <div class="relative overflow-hidden rounded-3xl border border-slate-200 bg-white/80 backdrop-blur px-6 py-6 sm:px-8 sm:py-8 shadow-sm">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <div class="flex items-center gap-3">
                        <span class="inline-grid place-items-center rounded-xl bg-sky-50 border border-sky-200 p-2">
                            <x-heroicon-o-lifebuoy class="h-6 w-6 text-sky-700" />
                        </span>
                        <h3 class="text-base font-semibold text-slate-800">Assistenza e supporto</h3>
                    </div>
                    <p class="text-sm text-slate-600 flex-1">
                        Hai bisogno di aiuto o non riesci ad accedere agli applicativi? Contatta il referente di Protezione Civile della tua struttura.
                    </p>
                </div>
            </div>
        </section>
    </main>
</x-layout>