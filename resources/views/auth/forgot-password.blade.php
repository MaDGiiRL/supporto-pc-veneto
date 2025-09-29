<x-layout title="Password smarrita">
    <div class="container mx-auto px-4 py-12 max-w-md">
        <h1 class="text-2xl font-bold">Password smarrita</h1>
        <p class="mt-2 text-slate-700 text-sm">
            Procedura per il recupero della password. Indicare l'indirizzo di posta elettronica utilizzato per la registrazione.
        </p>

        @if(session('status'))
        <div class="mt-4 p-3 rounded bg-green-50 text-green-700 text-sm">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4 mt-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1" for="email">Indirizzo di posta elettronica</label>
                <input id="email" name="email" type="email" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2" value="{{ old('email') }}">
                @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <button class="w-full rounded-lg bg-slate-900 text-white px-4 py-2 font-medium hover:bg-slate-800">
                Invia link di reset
            </button>
        </form>

        <p class="text-xs text-slate-500 mt-6">
            Regione del Veneto - Direzione Protezione Civile e Polizia Locale - Ufficio Pianificazione
        </p>
    </div>
</x-layout>