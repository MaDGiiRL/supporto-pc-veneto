<x-layout title="Home">
    <div class="container mx-auto px-4 space-y-15 py-15">

        <section class="space-y-4 text-center">
            <div class="flex justify-center">
                <img src="{{ asset('images/regione.png') }}" alt="Regione del Veneto" class="w-1/3 max-w-xs" />
            </div>

            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                Benvenuti nel portale di supporto delle attività <br />
                di Protezione Civile della Regione del Veneto
            </h1>

            <p class="opacity-90">
                Il portale fornisce informazioni ed utilità di supporto per gli operatori del Sistema Regionale di Protezione Civile
            </p>

            <p class="text-sm opacity-70 max-w-4xl mx-auto">
                I dati presentati nel portale non sostituiscono i dati cartografici ufficiali nè i dati presenti nei piani comunali approvati,
                ma intendono essere solo uno strumento di supporto per Enti del sistema regionale di Protezione Civile.
            </p>
        </section>

        <section class="grid md:grid-cols-3 gap-6 max-w-7xl mx-auto">
            <x-section-card
                :href="route('cartografie.index')"
                title="Cartografie"
                subtitle="Vai alla sezione"
                description="Questa sezione raccoglie sotto forma di mappe, informazioni relative ai piani comunali di protezione civile,
                     nonchè ulteriori dati raccolti ed elaborati dalla Direzione Protezione Civile e Polizia Locale della Regione del Veneto."
                img="images/cartografie.png"
                imgAlt="Cartografie">
                <x-slot:icon>
                    <x-heroicon-o-map class="h-6 w-6 text-slate-700" />
                </x-slot:icon>
            </x-section-card>

            <x-section-card
                :href="route('applicativi.index')"
                title="Applicativi informatici"
                subtitle="Vai alla sezione"
                description="Questa sezione consente l'accesso a procedure informatiche per la ricerca e la gestione delle risorse umane
                     e strumentali della Protezione Civile. L'accesso è riservato ai volontari specificatamente formati e agli utenti accreditati."
                img="images/applicativi.png"
                imgAlt="Applicativi informatici">
                <x-slot:icon>
                    <x-heroicon-o-computer-desktop class="h-6 w-6 text-slate-700" />
                </x-slot:icon>
            </x-section-card>

            <x-section-card
                :href="route('percezione.index')"
                title="Percezione sismica"
                subtitle="Vai alla sezione"
                description="Attraverso questa sezione è possibile accedere al portale per la segnalazione della percezione sismica.
                     L'accesso è riservato ai volontari specificatamente formati per la compilazione del questionario di percezione sismica."
                img="images/percezione.png"
                imgAlt="Percezione sismica">
                <x-slot:icon>
                    <x-heroicon-o-presentation-chart-line class="h-6 w-6 text-slate-700" />
                </x-slot:icon>
            </x-section-card>
        </section>
    </div>
</x-layout>