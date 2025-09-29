<x-layout title="Accedi">
    <div class="container mx-auto px-4 py-12 max-w-md">
        <h1 class="text-2xl font-bold mb-6">Accedi</h1>

        @if(session('status'))
        <div class="mb-4 p-3 rounded bg-green-50 text-green-700 text-sm">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1" for="email">Indirizzo email</label>
                <input id="email" name="email" type="email" required autofocus autocomplete="username"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2"
                    value="{{ old('email') }}">
                @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" for="password">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2">
                @error('password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="remember">
                    Ricordami
                </label>
                <a class="text-sm underline" href="{{ route('password.request') }}">Password smarrita?</a>
            </div>

            <button class="w-full rounded-lg bg-slate-900 text-white px-4 py-2 font-medium hover:bg-slate-800">
                Accedi
            </button>

            <p class="text-sm text-slate-600 mt-2">
                Non hai un account?
                <a class="underline" href="{{ route('register') }}">Registrati</a>
            </p>
        </form>
    </div>
</x-layout>