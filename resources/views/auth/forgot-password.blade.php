<x-layout title="Password smarrita" :hide-footer="true">
    <div class="relative min-h-[100vh] overflow-hidden bg-gradient-to-br from-sky-50 via-white to-cyan-50">
        <div class="pointer-events-none absolute -top-24 -left-24 h-72 w-72 rounded-full bg-sky-200/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-cyan-200/40 blur-3xl"></div>

        <div class="container mx-auto px-4 py-12 lg:pt-[12.5rem]">
            <div class="mx-auto max-w-md">
                <div class="mb-3 flex items-center gap-3">
                    <div class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-sky-500 to-cyan-500 text-white shadow-lg">
                        {{-- lifebuoy --}}
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 1.5a10.5 10.5 0 1 0 0 21 10.5 10.5 0 0 0 0-21Zm7.5 10.5a7.46 7.46 0 0 1-1.2 4.05l-3.3-3.3a3.75 3.75 0 0 0-5.99 0l-3.3 3.3A7.5 7.5 0 1 1 19.5 12Z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Password smarrita</h1>
                        <p class="text-sm text-slate-600">Inserisci l’email per ricevere il link di ripristino</p>
                    </div>
                </div>

                @if(session('status'))
                <div class="mb-4 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.25a9.75 9.75 0 1 0 0 19.5 9.75 9.75 0 0 0 0-19.5Zm-.75 13.5a.75.75 0 0 1 1.5 0v.75a.75.75 0 0 1-1.5 0v-.75Zm0-7.5a.75.75 0 0 1 1.5 0v6a.75.75 0 0 1-1.5 0v-6Z" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
                @endif

                <div class="rounded-2xl border border-white/60 bg-white/70 p-6 shadow-xl backdrop-blur-md ring-1 ring-slate-200">
                    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                        @csrf
                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Indirizzo di posta elettronica</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex w-9 items-center justify-center">
                                    <svg class="h-5 w-5 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M1.5 7.5A2.25 2.25 0 0 1 3.75 5.25h16.5A2.25 2.25 0 0 1 22.5 7.5V16.5A2.25 2.25 0 0 1 20.25 18.75H3.75A2.25 2.25 0 0 1 1.5 16.5V7.5Zm2.4-.75 7.17 5.38c.56.42 1.3.42 1.86 0l7.17-5.38H3.9Z" />
                                    </svg>
                                </span>
                                <input id="email" name="email" type="email" required value="{{ old('email') }}"
                                    class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 pl-10 shadow-sm placeholder:text-slate-400 focus:border-sky-400 focus:ring-4 focus:ring-sky-200">
                            </div>
                            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <button
                            class="w-full rounded-xl bg-gradient-to-r from-sky-600 to-cyan-600 px-4 py-2.5 font-semibold text-white shadow-lg transition hover:from-sky-700 hover:to-cyan-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-sky-300">
                            Invia link di reset
                        </button>
                    </form>
                </div>

                {{-- Informativa Privacy (trigger + modale) --}}
                <p class="mx-auto mt-6 max-w-md text-center text-xs text-slate-500">
                    Per maggiori dettagli consulta l’<button type="button" data-privacy-open="privacy-forgot" class="underline text-sky-700 hover:text-sky-800">Informativa Privacy</button>.
                </p>
                <x-privacy-modal modalId="privacy-forgot" />
            </div>
        </div>
    </div>
</x-layout>