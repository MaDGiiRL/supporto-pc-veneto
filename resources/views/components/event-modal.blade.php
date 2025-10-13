@props([
'modalId' => 'event-modal',
'title' => 'Nuovo evento',
])

<div id="{{ $modalId }}" class="fixed inset-0 z-[1000] hidden items-center justify-center bg-black/60 p-4" data-modal-overlay="{{ $modalId }}">
    <div class="relative w-full max-w-4xl rounded-2xl border border-slate-200 bg-white shadow-lg">
        <div class="flex items-center justify-between gap-3 border-b border-slate-200 px-5 py-3">
            <h3 class="text-lg font-semibold text-slate-900">{{ $title }}</h3>
            <button type="button" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100" data-modal-close="{{ $modalId }}" aria-label="Chiudi">
                <x-heroicon-o-x-mark class="h-5 w-5" />
            </button>
        </div>

        <form class="grid gap-4 p-5 max-h-[78vh] overflow-auto" data-event-form data-modal-id="{{ $modalId }}">
            {{-- Intestazione --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <label class="grid gap-1.5">
                    <span class="text-sm font-medium text-slate-700 inline-flex items-center gap-1.5">
                        <x-heroicon-o-document-text class="h-4 w-4 text-slate-500" /> Titolo <span class="text-red-600">*</span>
                    </span>
                    <input name="titolo" required maxlength="100" placeholder="Es. Fumo in località Bosco Alto"
                        class="h-10 w-full rounded-xl border border-slate-300 px-3 text-sm focus-visible:ring-2 focus-visible:ring-sky-500" />
                </label>

                <label class="grid gap-1.5">
                    <span class="text-sm font-medium text-slate-700 inline-flex items-center gap-1.5">
                        <x-heroicon-o-adjustments-horizontal class="h-4 w-4 text-slate-500" /> Priorità <span class="text-red-600">*</span>
                    </span>
                    <select name="priorita" required
                        class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm focus-visible:ring-2 focus-visible:ring-sky-500">
                        <option value="bassa">Bassa</option>
                        <option value="media" selected>Media</option>
                        <option value="alta">Alta</option>
                        <option value="critica">Critica</option>
                    </select>
                </label>

                <label class="grid gap-1.5">
                    <span class="text-sm font-medium text-slate-700 inline-flex items-center gap-1.5">
                        <x-heroicon-o-tag class="h-4 w-4 text-slate-500" /> Categoria <span class="text-red-600">*</span>
                    </span>
                    {{-- Se scegli "AIB (Incendio boschivo)" si aprono i campi AIB --}}
                    <select name="categoria" required data-aib-toggle
                        class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm focus-visible:ring-2 focus-visible:ring-sky-500">
                        <option value="generico">Generico</option>
                        <option value="idrogeologico">Idrogeologico</option>
                        <option value="idraulico">Idraulico</option>
                        <option value="meteo">Meteo</option>
                        <option value="frana">Frana</option>
                        <option value="aib">AIB (Incendio boschivo)</option>
                        <option value="altro">Altro</option>
                    </select>
                </label>

                <label class="grid gap-1.5">
                    <span class="text-sm font-medium text-slate-700 inline-flex items-center gap-1.5">
                        <x-heroicon-o-map-pin class="h-4 w-4 text-slate-500" /> Comune <span class="text-red-600">*</span>
                    </span>
                    <input name="comune" required placeholder="Es. Adria"
                        class="h-10 w-full rounded-xl border border-slate-300 px-3 text-sm focus-visible:ring-2 focus-visible:ring-sky-500" />
                </label>

                <label class="md:col-span-2 grid gap-1.5">
                    <span class="text-sm font-medium text-slate-700 inline-flex items-center gap-1.5">
                        <x-heroicon-o-user class="h-4 w-4 text-slate-500" /> Contatto
                    </span>
                    <input name="contatto" placeholder="Es. Mario Rossi – 3331234567"
                        class="h-10 w-full rounded-xl border border-slate-300 px-3 text-sm focus-visible:ring-2 focus-visible:ring-sky-500" />
                </label>

                <label class="grid gap-1.5">
                    <span class="text-sm font-medium text-slate-700 inline-flex items-center gap-1.5">
                        <x-heroicon-o-cursor-arrow-rays class="h-4 w-4 text-slate-500" /> Latitudine <span class="text-red-600">*</span>
                    </span>
                    <input name="lat" type="number" step="0.000001" required placeholder="45.123456"
                        class="h-10 w-full rounded-xl border border-slate-300 px-3 text-sm focus-visible:ring-2 focus-visible:ring-sky-500" />
                </label>

                <label class="grid gap-1.5">
                    <span class="text-sm font-medium text-slate-700 inline-flex items-center gap-1.5">
                        <x-heroicon-o-cursor-arrow-rays class="h-4 w-4 text-slate-500" /> Longitudine <span class="text-red-600">*</span>
                    </span>
                    <input name="lon" type="number" step="0.000001" required placeholder="11.123456"
                        class="h-10 w-full rounded-xl border border-slate-300 px-3 text-sm focus-visible:ring-2 focus-visible:ring-sky-500" />
                </label>

                <label class="md:col-span-2 grid gap-1.5">
                    <span class="text-sm font-medium text-slate-700">
                        Località
                    </span>
                    <input name="localita" placeholder="Es. Località Bosco Alto"
                        class="h-10 w-full rounded-xl border border-slate-300 px-3 text-sm focus-visible:ring-2 focus-visible:ring-sky-500" />
                </label>

                <label class="md:col-span-2 grid gap-1.5">
                    <span class="text-sm font-medium text-slate-700 inline-flex items-center gap-1.5">
                        <x-heroicon-o-document-text class="h-4 w-4 text-slate-500" /> Note iniziali
                    </span>
                    <textarea name="noteIniziali" rows="3" placeholder="Descrizione iniziale dell'evento"
                        class="min-h-24 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus-visible:ring-2 focus-visible:ring-sky-500"></textarea>
                </label>
            </div>

            {{-- Blocchi opzionali AIB --}}
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 hidden" data-aib-block>
                <div class="mb-2 flex items-center gap-2 text-amber-700">
                    <x-heroicon-o-fire class="h-5 w-5" />
                    <h4 class="text-sm font-semibold">Campi specifici AIB</h4>
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium text-slate-700">Tipo combustibile</span>
                        <input name="aib_combustibile" placeholder="Es. Bosco di pino"
                            class="h-10 w-full rounded-xl border border-slate-300 px-3 text-sm focus-visible:ring-2 focus-visible:ring-sky-500" />
                    </label>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium text-slate-700">Direzione vento</span>
                        <input name="aib_dirVento" placeholder="Es. NE (45°)"
                            class="h-10 w-full rounded-xl border border-slate-300 px-3 text-sm focus-visible:ring-2 focus-visible:ring-sky-500" />
                    </label>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium text-slate-700">Velocità vento (km/h)</span>
                        <input name="aib_velVento" type="number" min="0" placeholder="Es. 20"
                            class="h-10 w-full rounded-xl border border-slate-300 px-3 text-sm focus-visible:ring-2 focus-visible:ring-sky-500" />
                    </label>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex flex-wrap items-center justify-end gap-2 pt-2">
                <button type="button" class="rounded-xl h-10 px-4 text-sm font-medium bg-slate-100 text-slate-900 hover:bg-slate-200"
                    data-modal-close="{{ $modalId }}">Annulla</button>
                <button type="submit"
                    class="rounded-xl h-10 px-4 text-sm font-medium bg-sky-600 text-white hover:bg-sky-700 focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-sky-500">
                    Salva evento
                </button>
            </div>
        </form>
    </div>
</div>