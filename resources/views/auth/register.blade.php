<x-layout title="Registrazione" :hide-footer="true">>
    <div class="relative min-h-[100vh] overflow-hidden bg-gradient-to-br from-sky-50 via-white to-cyan-50">
        <div class="pointer-events-none absolute -top-24 -left-24 h-72 w-72 rounded-full bg-sky-200/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-cyan-200/40 blur-3xl"></div>

        <div class="container mx-auto px-4 py-12 pt-0 lg:pt-[3.5rem]">
            <div class="mx-auto max-w-2xl">
                {{-- Header --}}
                <div class="mb-6 flex items-center gap-3">
                    <div class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-sky-500 to-cyan-500 text-white shadow-lg">
                        {{-- user-plus icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM2.25 20.1a7.5 7.5 0 0 1 14.25 0v.15a.75.75 0 0 1-.75.75H3a.75.75 0 0 1-.75-.75v-.15ZM21 10.5h-2.25V8.25a.75.75 0 0 0-1.5 0V10.5H15a.75.75 0 0 0 0 1.5h2.25V14.25a.75.75 0 0 0 1.5 0V12h2.25a.75.75 0 0 0 0-1.5Z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Nuovo utente</h1>
                        <p class="text-sm text-slate-600">Crea un account per accedere ai servizi</p>
                    </div>
                </div>

                {{-- Info box (resta la tua copia) --}}
                <div class="mb-6 rounded-2xl border border-slate-200 bg-white/80 p-4 shadow-sm backdrop-blur-md">
                    <h2 class="mb-2 font-semibold">Informazioni</h2>
                    <p class="text-sm text-slate-700">
                        L'iscrizione al sito è riservata agli operatori appartenenti al sistema regionale di protezione civile. In particolare:
                    </p>
                    <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-slate-700">
                        <li><strong>Dipendenti pubblici:</strong> NON UTILIZZARE PEC. Usare solo mail istituzionali dell'Ente.</li>
                        <li><strong>Volontari:</strong> Mail personali o dell'associazione. Convalida previa conferma del Presidente/Coordinatore all’indirizzo
                            <a class="underline" href="mailto:protezionecivile.pianificazione@regione.veneto.it">protezionecivile.pianificazione@regione.veneto.it</a>.
                        </li>
                        <li>La stessa mail non può essere utilizzata da più utenti. Tutti i campi sono obbligatori.</li>
                    </ul>
                </div>

                {{-- Card form --}}
                <div class="rounded-2xl border border-white/60 bg-white/70 p-6 shadow-xl backdrop-blur-md ring-1 ring-slate-200">
                    <form method="POST" action="{{ route('register') }}" class="grid gap-5">
                        @csrf

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="first_name" class="mb-1.5 block text-sm font-medium text-slate-700">Nome</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex w-9 items-center justify-center">
                                        <svg class="h-5 w-5 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2.25a5.25 5.25 0 1 0 0 10.5 5.25 5.25 0 0 0 0-10.5ZM3.45 20.55A8.25 8.25 0 0 1 12 14.25a8.25 8.25 0 0 1 8.55 6.3.75.75 0 0 1-.73.95H4.18a.75.75 0 0 1-.73-.95Z" />
                                        </svg>
                                    </span>
                                    <input id="first_name" name="first_name" type="text" required value="{{ old('first_name') }}"
                                        class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 pl-10 shadow-sm placeholder:text-slate-400 focus:border-sky-400 focus:ring-4 focus:ring-sky-200">
                                </div>
                                @error('first_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="last_name" class="mb-1.5 block text-sm font-medium text-slate-700">Cognome</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex w-9 items-center justify-center">
                                        <svg class="h-5 w-5 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2.25a5.25 5.25 0 1 0 0 10.5 5.25 5.25 0 0 0 0-10.5ZM3.45 20.55A8.25 8.25 0 0 1 12 14.25a8.25 8.25 0 0 1 8.55 6.3.75.75 0 0 1-.73.95H4.18a.75.75 0 0 1-.73-.95Z" />
                                        </svg>
                                    </span>
                                    <input id="last_name" name="last_name" type="text" required value="{{ old('last_name') }}"
                                        class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 pl-10 shadow-sm placeholder:text-slate-400 focus:border-sky-400 focus:ring-4 focus:ring-sky-200">
                                </div>
                                @error('last_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label for="organization" class="mb-1.5 block text-sm font-medium text-slate-700">Ente di appartenenza</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex w-9 items-center justify-center">
                                    {{-- building --}}
                                    <svg class="h-5 w-5 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M3.75 3A.75.75 0 0 0 3 3.75v15a.75.75 0 0 0 .75.75h4.5v-3.75h7.5V19.5h4.5a.75.75 0 0 0 .75-.75v-15A.75.75 0 0 0 20.25 3H3.75Zm3 3h3v3h-3V6Zm6 0h3v3h-3V6Zm-6 6h3v3h-3v-3Zm6 0h3v3h-3v-3Z" />
                                    </svg>
                                </span>
                                <select id="organization" name="organization" required
                                    class="w-full appearance-none rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 pl-10 pr-10 shadow-sm focus:border-sky-400 focus:ring-4 focus:ring-sky-200">
                                    <option value="">selezionare Ente di appartenenza</option>
                                    <option {{ old('organization')=='Comune' ? 'selected' : '' }}>Comune</option>
                                    <option {{ old('organization')=='Provincia' ? 'selected' : '' }}>Provincia</option>
                                    <option {{ old('organization')=='Prefettura' ? 'selected' : '' }}>Prefettura</option>
                                    <option {{ old('organization')=='Regione del Veneto' ? 'selected' : '' }}>Regione del Veneto</option>
                                    <option {{ old('organization')=='Organizzazione di Volontariato' ? 'selected' : '' }}>Organizzazione di Volontariato</option>
                                </select>
                            </div>
                            @error('organization')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Indirizzo mail</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex w-9 items-center justify-center">
                                        {{-- mail --}}
                                        <svg class="h-5 w-5 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M1.5 7.5A2.25 2.25 0 0 1 3.75 5.25h16.5A2.25 2.25 0 0 1 22.5 7.5V16.5A2.25 2.25 0 0 1 20.25 18.75H3.75A2.25 2.25 0 0 1 1.5 16.5V7.5Zm2.4-.75 7.17 5.38c.56.42 1.3.42 1.86 0l7.17-5.38H3.9Z" />
                                        </svg>
                                    </span>
                                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                                        class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 pl-10 shadow-sm placeholder:text-slate-400 focus:border-sky-400 focus:ring-4 focus:ring-sky-200">
                                </div>
                                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="phone" class="mb-1.5 block text-sm font-medium text-slate-700">Recapito telefonico</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex w-9 items-center justify-center">
                                        {{-- phone --}}
                                        <svg class="h-5 w-5 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M2.25 4.5A2.25 2.25 0 0 1 4.5 2.25h3A2.25 2.25 0 0 1 9.75 4.5v1.5A2.25 2.25 0 0 1 7.5 8.25h-.75a12.01 12.01 0 0 0 9 9V16.5a2.25 2.25 0 0 1 2.25-2.25h1.5A2.25 2.25 0 0 1 21.75 16.5v3a2.25 2.25 0 0 1-2.25 2.25h-.75c-9.94 0-18-8.06-18-18V4.5Z" />
                                        </svg>
                                    </span>
                                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                                        class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 pl-10 shadow-sm placeholder:text-slate-400 focus:border-sky-400 focus:ring-4 focus:ring-sky-200">
                                </div>
                                @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Password</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex w-9 items-center justify-center">
                                        {{-- lock --}}
                                        <svg class="h-5 w-5 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25V9H5.25A2.25 2.25 0 0 0 3 11.25v6A2.25 2.25 0 0 0 5.25 19.5h13.5A2.25 2.25 0 0 0 21 17.25v-6A2.25 2.25 0 0 0 18.75 9H17.25V6.75A5.25 5.25 0 0 0 12 1.5Z" />
                                        </svg>
                                    </span>
                                    <input id="password" name="password" type="password" required autocomplete="new-password"
                                        class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 pl-10 shadow-sm placeholder:text-slate-400 focus:border-sky-400 focus:ring-4 focus:ring-sky-200">
                                </div>
                                @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-slate-700">Ripeti password</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex w-9 items-center justify-center">
                                        <svg class="h-5 w-5 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25V9H5.25A2.25 2.25 0 0 0 3 11.25v6A2.25 2.25 0 0 0 5.25 19.5h13.5A2.25 2.25 0 0 0 21 17.25v-6A2.25 2.25 0 0 0 18.75 9H17.25V6.75A5.25 5.25 0 0 0 12 1.5Z" />
                                        </svg>
                                    </span>
                                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                                        class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 pl-10 shadow-sm placeholder:text-slate-400 focus:border-sky-400 focus:ring-4 focus:ring-sky-200">
                                </div>
                            </div>
                        </div>

                        <button
                            class="mt-2 w-full rounded-xl bg-gradient-to-r from-sky-600 to-cyan-600 px-4 py-2.5 font-semibold text-white shadow-lg transition hover:from-sky-700 hover:to-cyan-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-sky-300">
                            Crea account
                        </button>
                    </form>
                </div>

                {{-- Informativa Privacy (trigger + modale) --}}
                <p class="mx-auto mt-3 max-w-2xl text-center text-xs text-slate-500">
                    Procedendo dichiari di aver letto l’<button type="button" data-privacy-open="privacy-register" class="underline text-sky-700 hover:text-sky-800">Informativa Privacy</button>.
                </p>
                <x-privacy-modal modalId="privacy-register" />
            </div>
        </div>
    </div>
</x-layout>