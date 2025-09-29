<x-layout title="Reimposta password">
    <div class="container mx-auto px-4 py-12 max-w-md">
        <h1 class="text-2xl font-bold mb-6">Reimposta password</h1>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <input type="hidden" name="email" value="{{ request('email') }}">

            <div>
                <label class="block text-sm font-medium mb-1" for="password">Nuova password</label>
                <input id="password" name="password" type="password" required autocomplete="new-password"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2">
                @error('password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" for="password_confirmation">Conferma nuova password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2">
            </div>

            <button class="w-full rounded-lg bg-slate-900 text-white px-4 py-2 font-medium hover:bg-slate-800">
                Aggiorna password
            </button>
        </form>
    </div>
</x-layout>