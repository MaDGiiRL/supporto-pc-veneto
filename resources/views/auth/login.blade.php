<x-layout title="Accedi" :hide-footer="true">
    {{-- Background con gradiente e blobs decorativi --}}
    <div class="relative min-h-[100vh] overflow-hidden bg-gradient-to-br from-sky-50 via-white to-cyan-50">
        <div class="pointer-events-none absolute -top-24 -left-24 h-72 w-72 rounded-full bg-sky-200/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-cyan-200/40 blur-3xl"></div>

        <div class="container mx-auto px-4 py-12 pt-0 lg:pt-[12.5rem]">
            <div class="mx-auto max-w-md">
                {{-- Header compatto --}}
                <div class="mb-6 flex items-center gap-3">
                    <div class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-sky-500 to-cyan-500 text-white shadow-lg">
                        {{-- icona shield --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.25c.41 0 .82.09 1.2.26l6 2.57a2.25 2.25 0 0 1 1.35 2.06v6.26a8.25 8.25 0 0 1-4.35 7.25l-3.75 2.02a2.25 2.25 0 0 1-2.1 0l-3.75-2.02A8.25 8.25 0 0 1 3.45 13.4V7.14c0-.89.53-1.69 1.35-2.06l6-2.57c.38-.17.79-.26 1.2-.26z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Accedi</h1>
                        <p class="text-sm text-slate-600">Entra nel portale della Protezione Civile</p>
                    </div>
                </div>

                {{-- Card glass --}}
                <div class="rounded-2xl border border-white/60 bg-white/70 p-6 shadow-xl backdrop-blur-md ring-1 ring-slate-200">
                    @if(session('status'))
                    <div class="mb-4 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.25a9.75 9.75 0 1 0 0 19.5 9.75 9.75 0 0 0 0-19.5Zm-.75 13.5a.75.75 0 0 1 1.5 0v.75a.75.75 0 0 1-1.5 0v-.75Zm0-7.5a.75.75 0 0 1 1.5 0v6a.75.75 0 0 1-1.5 0v-6Z" />
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Indirizzo email</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex w-10 items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M1.5 7.5A2.25 2.25 0 0 1 3.75 5.25h16.5A2.25 2.25 0 0 1 22.5 7.5V16.5A2.25 2.25 0 0 1 20.25 18.75H3.75A2.25 2.25 0 0 1 1.5 16.5V7.5Zm2.4-.75 7.17 5.38c.56.42 1.3.42 1.86 0l7.17-5.38H3.9Z" />
                                    </svg>
                                </span>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    value="{{ old('email') }}"
                                    class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 pl-10 text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-sky-400 focus:ring-4 focus:ring-sky-200"
                                    placeholder="nome@esempio.it">
                            </div>
                            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <div class="mb-1.5 flex items-center justify-between">
                                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                                <a class="text-sm text-sky-700 hover:text-sky-800 underline underline-offset-2" href="{{ route('password.request') }}">Password smarrita?</a>
                            </div>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex w-10 items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25V9H5.25A2.25 2.25 0 0 0 3 11.25v6A2.25 2.25 0 0 0 5.25 19.5h13.5A2.25 2.25 0 0 0 21 17.25v-6A2.25 2.25 0 0 0 18.75 9H17.25V6.75A5.25 5.25 0 0 0 12 1.5Z" />
                                    </svg>
                                </span>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    required
                                    autocomplete="current-password"
                                    class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 pl-10 text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-sky-400 focus:ring-4 focus:ring-sky-200"
                                    placeholder="••••••••">
                            </div>
                            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Remember + CTA secondaria --}}
                        <div class="flex items-center justify-between">
                            <label class="inline-flex select-none items-center gap-2 text-sm text-slate-700">
                                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                                Ricordami
                            </label>
                            <p class="text-sm text-slate-600">
                                Non hai un account?
                                <a class="font-medium text-sky-700 underline underline-offset-2 hover:text-sky-800" href="{{ route('register') }}">Registrati</a>
                            </p>
                        </div>

                        {{-- Submit --}}
                        <button
                            class="group relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-sky-600 to-cyan-600 px-4 py-2.5 font-semibold text-white shadow-lg transition hover:from-sky-700 hover:to-cyan-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-sky-300">
                            <span class="inline-flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3 12a.75.75 0 0 1 .75-.75h12.59l-3.22-3.22a.75.75 0 1 1 1.06-1.06l4.5 4.5a.75.75 0 0 1 0 1.06l-4.5 4.5a.75.75 0 1 1-1.06-1.06l3.22-3.22H3.75A.75.75 0 0 1 3 12Z" />
                                </svg>
                                Accedi
                            </span>
                        </button>
                    </form>
                </div>

                {{-- Informativa Privacy (trigger + modale) --}}
                <p class="mx-auto mt-3 max-w-md text-center text-xs text-slate-500">
                    Accedendo accetti l’<button type="button" data-privacy-open="privacy-auth" class="underline text-sky-700 hover:text-sky-800">Informativa Privacy</button>.
                </p>
                <x-privacy-modal modalId="privacy-auth" />
            </div>
        </div>
    </div>
</x-layout>