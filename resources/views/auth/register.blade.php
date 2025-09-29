<x-layout title="Registrazione">
    <div class="container mx-auto px-4 py-12 max-w-2xl">
        <h1 class="text-2xl font-bold mb-4">Nuovo utente</h1>

        <div class="rounded-xl border border-slate-200 bg-white p-4 mb-6">
            <h2 class="font-semibold mb-2">Informazioni</h2>
            <p class="text-sm text-slate-700">
                L'iscrizione al sito è riservata agli operatori appartenenti al sistema regionale di protezione civile. In particolare:
            </p>
            <ul class="list-disc list-inside text-sm text-slate-700 space-y-1 mt-2">
                <li><strong>Dipendenti pubblici:</strong> NON UTILIZZARE PEC. Usare solo mail istituzionali dell'Ente (es. mario.rossi@comunexxx.it; tecnico@comunexxx.it).</li>
                <li><strong>Volontari:</strong> Si possono usare mail personali o dell'associazione. L’abilitazione verrà convalidata previa conferma del Presidente/Coordinatore all’indirizzo <a class="underline" href="mailto:protezionecivile.pianificazione@regione.veneto.it">protezionecivile.pianificazione@regione.veneto.it</a>.</li>
                <li>La stessa mail non può essere utilizzata da più utenti. Tutti i campi sono obbligatori.</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('register') }}" class="grid gap-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1" for="first_name">Nome</label>
                    <input id="first_name" name="first_name" type="text" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2" value="{{ old('first_name') }}">
                    @error('first_name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="last_name">Cognome</label>
                    <input id="last_name" name="last_name" type="text" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2" value="{{ old('last_name') }}">
                    @error('last_name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" for="organization">Ente di appartenenza</label>
                <select id="organization" name="organization" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2">
                    <option value="">selezionare Ente di appartenenza</option>
                    <option {{ old('organization')=='Comune' ? 'selected' : '' }}>Comune</option>
                    <option {{ old('organization')=='Provincia' ? 'selected' : '' }}>Provincia</option>
                    <option {{ old('organization')=='Prefettura' ? 'selected' : '' }}>Prefettura</option>
                    <option {{ old('organization')=='Regione del Veneto' ? 'selected' : '' }}>Regione del Veneto</option>
                    <option {{ old('organization')=='Organizzazione di Volontariato' ? 'selected' : '' }}>Organizzazione di Volontariato</option>
                </select>
                @error('organization')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1" for="email">Indirizzo mail</label>
                    <input id="email" name="email" type="email" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2" value="{{ old('email') }}">
                    @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="phone">Recapito telefonico</label>
                    <input id="phone" name="phone" type="text"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2" value="{{ old('phone') }}">
                    @error('phone')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1" for="password">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2">
                    @error('password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="password_confirmation">Ripeti password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
            </div>

            <button class="mt-2 rounded-lg bg-slate-900 text-white px-4 py-2 font-medium hover:bg-slate-800">
                Crea account
            </button>
        </form>
    </div>
</x-layout>