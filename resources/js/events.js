// Stato in-memory finché non attacchi il DB
window.APP_STATE = window.APP_STATE || { eventi: [], telefonate: [], sor: { stato: 'chiusa' }, eventiInAtto: [] };

(function () {
    const $ = (s, r = document) => r.querySelector(s);
    const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));

    // Open/Close modali via data-attributes
    document.addEventListener('click', (e) => {
        const openBtn = e.target.closest('[data-modal-open]');
        if (openBtn) {
            e.preventDefault();
            const id = openBtn.getAttribute('data-modal-open');
            const modal = document.getElementById(id);
            if (modal) modal.classList.remove('hidden'), modal.classList.add('flex');
            return;
        }
        const closeBtn = e.target.closest('[data-modal-close]');
        if (closeBtn) {
            e.preventDefault();
            const id = closeBtn.getAttribute('data-modal-close');
            const modal = document.getElementById(id);
            if (modal) modal.classList.add('hidden'), modal.classList.remove('flex');
            return;
        }
        const overlayId = e.target.getAttribute?.('data-modal-overlay');
        if (overlayId) {
            const modal = document.getElementById(overlayId);
            if (modal) modal.classList.add('hidden'), modal.classList.remove('flex');
        }
    });

    // Toggle blocco AIB
    document.addEventListener('change', (e) => {
        const sel = e.target.closest('[data-aib-toggle]');
        if (!sel) return;
        const form = e.target.closest('form');
        const aibBlock = $('[data-aib-block]', form);
        if (!aibBlock) return;
        const isAIB = sel.value === 'aib';
        aibBlock.classList.toggle('hidden', !isAIB);
    });

    // Submit evento (dispatch CustomEvent per aggiornare dashboard)
    document.addEventListener('submit', (e) => {
        const form = e.target.closest('[data-event-form]');
        if (!form) return;
        e.preventDefault();

        const fd = Object.fromEntries(new FormData(form).entries());
        const isAIB = (fd.categoria === 'aib');
        const now = new Date();
        const pad = n => String(n).padStart(2, '0');
        const stamp = `${pad(now.getDate())}/${pad(now.getMonth() + 1)}/${now.getFullYear()} ${pad(now.getHours())}:${pad(now.getMinutes())}`;

        const record = {
            id: Date.now(),
            datetime: stamp,
            titolo: fd.titolo?.trim() || 'Evento',
            categoria: fd.categoria,
            priorita: fd.priorita,
            comune: fd.comune?.trim() || '-',
            localita: fd.localita?.trim() || '',
            contatto: fd.contatto?.trim() || '',
            lat: fd.lat, lon: fd.lon,
            note: fd.noteIniziali?.trim() || '',
            aib: isAIB,
            aib_extra: isAIB ? {
                combustibile: fd.aib_combustibile?.trim() || '',
                dirVento: fd.aib_dirVento?.trim() || '',
                velVento: fd.aib_velVento?.trim() || '',
            } : null,
        };

        window.APP_STATE.eventi.unshift(record);
        document.dispatchEvent(new CustomEvent('app:event-created', { detail: record }));

        // chiudi modale
        const modalId = form.getAttribute('data-modal-id');
        if (modalId) {
            const modal = document.getElementById(modalId);
            if (modal) modal.classList.add('hidden'), modal.classList.remove('flex');
        }
        form.reset();
        // nascondi blocco AIB se era visibile
        const aibSel = form.querySelector('[data-aib-toggle]');
        if (aibSel) aibSel.value = 'generico';
        const aibBlock = form.querySelector('[data-aib-block]');
        if (aibBlock) aibBlock.classList.add('hidden');

        // Toast (se hai SweetAlert2 caricato)
        if (window.Swal) {
            Swal.fire({ icon: 'success', title: 'Evento salvato', timer: 1500, showConfirmButton: false });
        }
    });
})();
