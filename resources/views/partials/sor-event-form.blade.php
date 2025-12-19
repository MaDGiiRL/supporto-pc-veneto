<form id="form-ev-comm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @csrf

    <input type="hidden" id="ev-event-id" name="event_id" value="" />

    <label class="grid gap-1.5 md:col-span-2">
        <span class="label">Priorità</span>
        <div class="flex flex-wrap items-center gap-4 mt-1">
            <label class="inline-flex items-center gap-2"><input type="radio" name="priorita" value="Nessuna" checked> Nessuna</label>
            <label class="inline-flex items-center gap-2"><input type="radio" name="priorita" value="Alta"> Alta</label>
            <label class="inline-flex items-center gap-2"><input type="radio" name="priorita" value="Media"> Media</label>
            <label class="inline-flex items-center gap-2"><input type="radio" name="priorita" value="Bassa"> Bassa</label>
        </div>
    </label>

    <label class="grid gap-1.5">
        <span class="label">Data comunicazione</span>
        <input id="ev-data" name="data" class="input" type="text" placeholder="gg/mm/aaaa" />
    </label>

    <label class="grid gap-1.5">
        <span class="label">Ora comunicazione</span>
        <input id="ev-ora" name="ora" class="input" type="text" placeholder="hh:mm" />
    </label>

    <label class="grid gap-1.5">
        <span class="label">Tipo comunicazione</span>
        <select id="ev-tipo" name="tipo" class="input">
            <option value="" selected>Seleziona...</option>
            <option value="FAX">FAX</option>
            <option value="Email">Email</option>
            <option value="Telefono">Telefono</option>
            <option value="PEC">PEC</option>
        </select>
    </label>

    <div class="grid gap-1.5">
        <span class="label">Verso</span>
        <div class="flex items-center gap-4">
            <label class="inline-flex items-center gap-2"><input type="radio" name="verso" value="E" checked> Entrata (E)</label>
            <label class="inline-flex items-center gap-2"><input type="radio" name="verso" value="U"> Uscita (U)</label>
        </div>
    </div>

    <label class="grid gap-1.5 md:col-span-2">
        <span class="label">Mittente/Destinatario</span>
        <input id="ev-mitt" name="mitt_dest" class="input" />
    </label>

    <label class="grid gap-1.5">
        <span class="label">Telefono</span>
        <input id="ev-tel" name="telefono" class="input" />
    </label>

    <label class="grid gap-1.5">
        <span class="label">E-mail</span>
        <input id="ev-mail" name="email" class="input" type="email" />
    </label>

    <label class="grid gap-1.5 md:col-span-2">
        <span class="label">Indirizzo zona colpita</span>
        <input id="ev-indirizzo" name="indirizzo" class="input" />
    </label>

    <label class="grid gap-1.5">
        <span class="label">Provincia</span>
        <select id="ev-provincia" name="provincia" class="input">
            <option value="">Tutte le province...</option>
        </select>
    </label>

    <label class="grid gap-1.5">
        <span class="label">Zona (Comune)</span>
        <select id="ev-comune" name="comune" class="input" disabled>
            <option value="">Prima seleziona una provincia...</option>
        </select>
    </label>

    <label class="grid gap-1.5 md:col-span-2">
        <span class="label">Aree interessate (Comuni e Frazioni)</span>
        <div class="tag-input" id="ev-aree" data-datalist="comuni-datalist"></div>
        <input type="hidden" name="aree" id="ev-aree-hidden" value="[]" />
    </label>

    <label class="grid gap-1.5 md:col-span-2">
        <span class="label">Posizione su mappa</span>
        <p class="text-xs opacity-70">Clicca sulla mappa per impostare la posizione. Trascina il marker (se hai i permessi).</p>

        <div id="ev-map" class="w-full rounded-xl border border-slate-300" style="height:280px;"></div>

        <div class="mt-2 grid grid-cols-2 gap-3">
            <label class="grid gap-1 text-xs">
                <span class="label">Latitudine</span>
                <input id="ev-lat" name="lat" class="input" type="text" readonly placeholder="Clicca sulla mappa…" />
            </label>
            <label class="grid gap-1 text-xs">
                <span class="label">Longitudine</span>
                <input id="ev-lng" name="lng" class="input" type="text" readonly placeholder="Clicca sulla mappa…" />
            </label>
        </div>
    </label>

    <label class="grid gap-1.5 md:col-span-2">
        <span class="label">Oggetto</span>
        <input id="ev-oggetto" name="oggetto" class="input" />
    </label>

    <label class="grid gap-1.5 md:col-span-2">
        <span class="label">Contenuto</span>
        <textarea id="ev-contenuto" name="contenuto" class="input" rows="4"></textarea>
    </label>

    <div class="md:col-span-2 flex justify-end gap-2 pt-2">
        <button type="button" class="btn" data-close-modal>Chiudi</button>
        <button type="reset" class="btn">Reset</button>
        <button type="submit" class="btn btn-primary">💾 Salva comunicazione</button>
    </div>
</form>