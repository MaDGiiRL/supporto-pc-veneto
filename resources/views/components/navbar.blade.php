@php
use Illuminate\Support\Str;
@endphp

<header
    class="sticky z-40 border-b border-slate-200/70 bg-white/70 backdrop-blur supports-[backdrop-filter]:bg-white/60"
    style="top: var(--banner-h, 0px);">
    <div class="container mx-auto flex items-center justify-between py-3 px-4">

        {{-- BRAND --}}
        <a href="{{ url('/') }}" class="group flex items-center gap-2 font-semibold text-slate-900">
            <span class="inline-grid place-items-center rounded-xl bg-gradient-to-br from-sky-500 to-cyan-600 text-white p-1.5 shadow-sm ring-1 ring-sky-500/30">
                <x-heroicon-o-shield-check class="h-5 w-5" />
            </span>
            <span class="tracking-tight flex items-center gap-2">
                Supporto PC Veneto
                <span class="text-[10px] font-semibold uppercase tracking-wide px-2 py-0.5 rounded-md bg-gradient-to-r from-sky-500 to-cyan-600 text-white shadow-sm">
                    Beta
                </span>
            </span>
        </a>

        {{-- DESKTOP NAV (gestita da JS, non dipende da md:) --}}
        <div id="nav-desktop" class="flex items-center gap-5">
            <nav class="flex items-center gap-1 text-sm">
                <a href="{{ url('/') }}"
                    class="inline-flex items-center gap-2 rounded-lg px-3 py-2 hover:bg-slate-100 transition
                          {{ request()->is('/') ? 'bg-slate-100 text-slate-900' : 'text-slate-700' }}">
                    <x-heroicon-o-home class="h-4 w-4" />
                    <span>Home</span>
                </a>

                <a href="{{ route('cartografie.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg px-3 py-2 hover:bg-slate-100 transition
                          {{ request()->routeIs('cartografie.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-700' }}">
                    <x-heroicon-o-map class="h-4 w-4" />
                    <span>Cartografie</span>
                </a>

                <a href="{{ route('applicativi.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg px-3 py-2 hover:bg-slate-100 transition
                          {{ request()->routeIs('applicativi.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-700' }}">
                    <x-heroicon-o-computer-desktop class="h-4 w-4" />
                    <span>Applicativi</span>
                </a>

                @auth
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.users.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg px-3 py-2 hover:bg-slate-100 transition
                                  {{ request()->routeIs('admin.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-700' }}">
                    <x-heroicon-o-shield-exclamation class="h-4 w-4" />
                    <span>Amministrazione</span>
                </a>
                @endif
                @endauth
            </nav>

            {{-- AREA UTENTE (desktop) --}}
            @auth
            <div class="flex items-center gap-3">
                <div class="hidden lg:flex items-center gap-1 text-sm text-slate-700">
                    <span class="text-slate-500">Ciao,</span>
                    <span class="font-semibold">
                        {{ Str::of(auth()->user()->name ?? auth()->user()->email)->words(2, '…') }}
                    </span>
                </div>

                <div class="relative">
                    <button id="user-menu-button"
                        class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white/80 px-3 py-1.5 text-sm text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-500"
                        aria-haspopup="menu" aria-expanded="false" aria-controls="user-menu" type="button">
                        <span class="inline-grid place-items-center rounded-lg bg-gradient-to-br from-indigo-500 to-violet-600 text-white h-7 w-7 ring-1 ring-indigo-500/30">
                            <x-heroicon-o-user class="h-4 w-4" />
                        </span>
                        <x-heroicon-o-chevron-down id="user-menu-caret" class="h-4 w-4 text-slate-400 transition-transform duration-200" />
                    </button>

                    <div id="user-menu"
                        class="hidden absolute right-0 mt-2 w-56 rounded-xl border border-slate-200 bg-white shadow-lg shadow-sky-100/50 overflow-hidden z-50"
                        role="menu">

                        <div class="px-3 py-2 text-xs text-slate-500 bg-slate-50">Account</div>

                        <div class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 border-b border-slate-100">
                            <span class="inline-grid place-items-center rounded-lg bg-gradient-to-br from-indigo-500 to-violet-600 text-white h-7 w-7 ring-1 ring-indigo-500/30">
                                <x-heroicon-o-user class="h-4 w-4" />
                            </span>
                            <span>
                                Ciao,
                                <strong>{{ Str::of(auth()->user()->name ?? auth()->user()->email)->words(2, '…') }}</strong>
                            </span>
                        </div>

                        <div class="py-1 border-t border-slate-100 mt-1">
                            <form method="POST" action="{{ route('logout') }}" id="logout-form-desktop">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2 px-3 py-2 text-left text-sm hover:bg-slate-50" role="menuitem">
                                    <x-heroicon-o-arrow-right-on-rectangle class="h-4 w-4 text-slate-400" />
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            @else
            <div class="flex items-center gap-2">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50">
                    <x-heroicon-o-arrow-left-end-on-rectangle class="h-4 w-4" /> Accedi
                </a>
                <a href="{{ route('register') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-sky-500 to-cyan-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:from-sky-600 hover:to-cyan-700">
                    <x-heroicon-o-user-plus class="h-4 w-4" /> Registrati
                </a>
            </div>
            @endauth
        </div>

        {{-- MOBILE TOGGLE (gestita da JS) --}}
        <button id="nav-toggle"
            class="hidden p-2 rounded-lg transition-colors hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-300/70"
            aria-controls="mobile-menu" aria-expanded="false" type="button">
            <x-heroicon-o-bars-3 class="h-6 w-6 text-slate-700" />
        </button>
    </div>

    {{-- MENU MOBILE --}}
    <div id="mobile-menu" class="hidden px-4 pb-3 border-t border-slate-200/70 bg-white/80 backdrop-blur">
        <nav class="flex flex-col gap-1 text-sm py-2">
            <a href="{{ url('/') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100
                      {{ request()->is('/') ? 'bg-slate-100 text-slate-900' : 'text-slate-700' }}">
                <x-heroicon-o-home class="h-4 w-4" /> Home
            </a>

            <a href="{{ route('cartografie.index') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100
                      {{ request()->routeIs('cartografie.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-700' }}">
                <x-heroicon-o-map class="h-4 w-4" /> Cartografie
            </a>

            <a href="{{ route('applicativi.index') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100
                      {{ request()->routeIs('applicativi.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-700' }}">
                <x-heroicon-o-computer-desktop class="h-4 w-4" /> Applicativi
            </a>
        </nav>
    </div>
</header>

<script>
    (function() {
        // breakpoint manuale (equivalente a md=768)
        const BP = 768;

        const desktop = document.getElementById('nav-desktop');
        const toggle = document.getElementById('nav-toggle');
        const mobile = document.getElementById('mobile-menu');

        const btn = document.getElementById('user-menu-button');
        const menu = document.getElementById('user-menu');
        const caret = document.getElementById('user-menu-caret');

        function setMode() {
            const isMobile = window.innerWidth < BP;
            desktop?.classList.toggle('hidden', isMobile);
            toggle?.classList.toggle('hidden', !isMobile);

            if (!isMobile) {
                mobile?.classList.add('hidden');
                toggle?.setAttribute('aria-expanded', 'false');
            }

            // chiudi user menu su resize
            if (menu) {
                menu.classList.add('hidden');
                btn?.setAttribute('aria-expanded', 'false');
                caret?.classList.remove('rotate-180');
            }
        }

        function toggleMobile() {
            if (!mobile) return;
            const isHidden = mobile.classList.contains('hidden');
            mobile.classList.toggle('hidden');
            toggle?.setAttribute('aria-expanded', String(isHidden));
        }

        setMode();
        window.addEventListener('resize', setMode);

        toggle?.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleMobile();
        });

        document.addEventListener('click', (e) => {
            if (mobile?.classList.contains('hidden')) return;
            const inside = toggle?.contains(e.target) || mobile?.contains(e.target);
            if (!inside) {
                mobile?.classList.add('hidden');
                toggle?.setAttribute('aria-expanded', 'false');
            }
        });

        // user menu
        function closeUserMenu() {
            menu?.classList.add('hidden');
            btn?.setAttribute('aria-expanded', 'false');
            caret?.classList.remove('rotate-180');
        }

        function openUserMenu() {
            menu?.classList.remove('hidden');
            btn?.setAttribute('aria-expanded', 'true');
            caret?.classList.add('rotate-180');
        }

        btn?.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = btn.getAttribute('aria-expanded') === 'true';
            isOpen ? closeUserMenu() : openUserMenu();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                mobile?.classList.add('hidden');
                toggle?.setAttribute('aria-expanded', 'false');
                closeUserMenu();
            }
        });

        document.addEventListener('click', (e) => {
            if (!menu || menu.classList.contains('hidden')) return;
            const inside = btn?.contains(e.target) || menu.contains(e.target);
            if (!inside) closeUserMenu();
        });
    })();
</script>