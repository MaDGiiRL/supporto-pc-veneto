<x-layout title="Reimposta password" :hide-footer="true">>
    <div class="relative min-h-[88vh] overflow-hidden bg-gradient-to-br from-sky-50 via-white to-cyan-50">
        <div class="pointer-events-none absolute -top-24 -left-24 h-72 w-72 rounded-full bg-sky-200/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-cyan-200/40 blur-3xl"></div>

        <div class="container mx-auto px-4 py-12 lg:pt-[12.5rem]">
            <div class="mx-auto max-w-md">
                <div class="mb-6 flex items-center gap-3">
                    <div class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-sky-500 to-cyan-500 text-white shadow-lg">
                        {{-- key icon --}}
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M15.75 2.25a6.75 6.75 0 1 0 4.77 11.52l1.23 1.23a.75.75 0 0 0 .53.22h.77a.75.75 0 0 1 .75.75V18a.75.75 0 0 1-.75.75h-.75v.75A.75.75 0 0 1 21.75 20.25H21v.75a.75.75 0 0 1-.75.75H19.5a.75.75 0 0 1-.75-.75V20.25H18a.75.75 0 0 1-.75-.75V18h-.75a.75.75 0 0 1-.75-.75v-.77a.75.75 0 0 0-.22-.53l-1.23-1.23a6.73 6.73 0 0 0 1.95-4.72Z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Reimposta password</h1>
                        <p class="text-sm text-slate-600">Inserisci la tua nuova password</p>
                    </div>
                </div>

                <div class="rounded-2xl border border-white/60 bg-white/70 p-6 shadow-xl backdrop-blur-md ring-1 ring-slate-200">
                    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <input type="hidden" name="email" value="{{ request('email') }}">

                        <div>
                            <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Nuova password</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex w-9 items-center justify-center">
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
                            <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-slate-700">Conferma nuova password</label>
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

                        <button
                            class="w-full rounded-xl bg-gradient-to-r from-sky-600 to-cyan-600 px-4 py-2.5 font-semibold text-white shadow-lg transition hover:from-sky-700 hover:to-cyan-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-sky-300">
                            Aggiorna password
                        </button>
                    </form>
                </div>

                {{-- Informativa Privacy (trigger + modale) --}}
                <p class="mx-auto mt-6 max-w-md text-center text-xs text-slate-500">
                    Informativa: <button type="button" data-privacy-open="privacy-reset" class="underline text-sky-700 hover:text-sky-800">Privacy</button>.
                </p>
                <x-privacy-modal modalId="privacy-reset" />
            </div>
        </div>
    </div>
</x-layout>