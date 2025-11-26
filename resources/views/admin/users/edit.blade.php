<x-layout title="Modifica utente">
    <div class="max-w-3xl mx-auto py-8 px-4 space-y-6">

        <a href="{{ route('admin.users.index', ['tab' => 'all']) }}"
           class="inline-flex items-center text-sm text-slate-600 hover:text-slate-900">
            <x-heroicon-o-arrow-left class="h-4 w-4 mr-1" />
            Torna alla gestione utenti
        </a>

        <div class="flex items-center justify-between gap-2">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">
                    Modifica utente
                </h1>
                <p class="text-sm text-slate-600">
                    {{ $user->first_name }} {{ $user->last_name }} &mdash; {{ $user->email }}
                </p>
            </div>

            <div>
                @if($user->is_active)
                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-800 border border-emerald-200">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Attivo
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-800 border border-amber-200">
                        <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                        Da abilitare
                    </span>
                @endif
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-6 space-y-5">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Nome / Cognome --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700" for="first_name">Nome</label>
                        <input type="text" id="first_name" name="first_name"
                               value="{{ old('first_name', $user->first_name) }}"
                               class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-200">
                        @error('first_name')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700" for="last_name">Cognome</label>
                        <input type="text" id="last_name" name="last_name"
                               value="{{ old('last_name', $user->last_name) }}"
                               class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-200">
                        @error('last_name')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Ente di appartenenza --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700" for="organization">
                        Ente di appartenenza
                    </label>
                    <select id="organization" name="organization"
                            class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-200">
                        @php
                            $orgValue = old('organization', $user->organization);
                        @endphp
                        <option value="">Seleziona ente</option>
                        <option value="Comune" {{ $orgValue === 'Comune' ? 'selected' : '' }}>Comune</option>
                        <option value="Provincia" {{ $orgValue === 'Provincia' ? 'selected' : '' }}>Provincia</option>
                        <option value="Prefettura" {{ $orgValue === 'Prefettura' ? 'selected' : '' }}>Prefettura</option>
                        <option value="Regione del Veneto" {{ $orgValue === 'Regione del Veneto' ? 'selected' : '' }}>Regione del Veneto</option>
                        <option value="Organizzazione di Volontariato" {{ $orgValue === 'Organizzazione di Volontariato' ? 'selected' : '' }}>Organizzazione di Volontariato</option>
                    </select>
                    @error('organization')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email / Telefono --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700" for="email">Email</label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email', $user->email) }}"
                               class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-200">
                        @error('email')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700" for="phone">Telefono</label>
                        <input type="text" id="phone" name="phone"
                               value="{{ old('phone', $user->phone) }}"
                               class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-200">
                        @error('phone')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Ruoli --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">
                        Ruoli
                    </label>
                    <p class="mt-1 text-xs text-slate-500">
                        Seleziona uno o più ruoli applicativi per questo utente.
                    </p>

                    <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach($roles as $role)
                            <label class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-3 py-2 text-sm hover:bg-slate-50">
                                <input type="checkbox" name="roles[]" value="{{ $role->slug }}"
                                       class="rounded border-slate-300 text-sky-600 focus:ring-sky-500"
                                       {{ in_array($role->slug, old('roles', $userRoleSlugs)) ? 'checked' : '' }}>
                                <span>{{ $role->label }}</span>
                            </label>
                        @endforeach
                    </div>

                    @error('roles')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                    @error('roles.*')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stato attivo --}}
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                           class="rounded border-slate-300 text-sky-600 focus:ring-sky-500"
                           {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="text-sm text-slate-700">
                        Utente abilitato (può accedere all'applicativo)
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.users.index', ['tab' => 'all']) }}"
                       class="inline-flex items-center px-4 py-2 rounded-xl border border-slate-200 text-sm text-slate-700 hover:bg-slate-50">
                        Annulla
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 rounded-xl bg-sky-600 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
                        Salva modifiche
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-layout>
