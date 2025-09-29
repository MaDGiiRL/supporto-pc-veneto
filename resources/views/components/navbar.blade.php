<header class="sticky top-0 z-30 backdrop-blur">
    <div class="container mx-auto flex items-center justify-between py-3 px-4">
        <a href="{{ url('/') }}" class="flex items-center gap-2 font-semibold">
            <x-heroicon-o-shield-check class="h-6 w-6" />
            <span>Supporto PC Veneto</span>
        </a>

        <div class="hidden md:flex items-center gap-4">
            <nav class="flex items-center gap-4 text-sm">
                <a href="{{ url('/') }}" class="hover:underline">Home</a>
                <a href="{{ route('cartografie.index') }}" class="hover:underline">Cartografie</a>
                <a href="{{ route('applicativi.index') }}" class="hover:underline">Applicativi</a>
                <a href="{{ route('percezione.index') }}" class="hover:underline">Percezione</a>
            </nav>

            {{-- RIMOSSO: toggle tema --}}
            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm underline">Logout</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="text-sm underline">Accedi</a>
            <a href="{{ route('register') }}" class="text-sm underline">Registrati</a>
            @endauth
        </div>

        <button id="nav-toggle"
            class="md:hidden p-2 rounded-md transition-colors duration-150 hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-300/70"
            aria-label="Apri menu">
            <x-heroicon-o-bars-3 class="h-6 w-6" />
        </button>
    </div>

    <div id="mobile-menu" class="md:hidden hidden px-4 pb-3">
        <nav class="flex flex-col gap-2 text-sm">
            <a href="{{ url('/') }}" class="px-2 py-2 rounded hover:bg-slate-100">Home</a>
            <a href="{{ route('cartografie.index') }}" class="px-2 py-2 rounded hover:bg-slate-100">Cartografie</a>
            <a href="{{ route('applicativi.index') }}" class="px-2 py-2 rounded hover:bg-slate-100">Applicativi</a>
            <a href="{{ route('percezione.index') }}" class="px-2 py-2 rounded hover:bg-slate-100">Percezione</a>

            {{-- RIMOSSO: toggle tema mobile --}}
            @auth
            <form method="POST" action="{{ route('logout') }}" class="px-2">
                @csrf
                <button type="submit" class="w-full text-left py-2 rounded hover:bg-slate-100">Logout</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="px-2 py-2 rounded hover:bg-slate-100">Accedi</a>
            <a href="{{ route('register') }}" class="px-2 py-2 rounded hover:bg-slate-100">Registrati</a>
            @endauth
        </nav>
    </div>
</header>