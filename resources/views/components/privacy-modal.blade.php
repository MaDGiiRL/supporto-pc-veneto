@props([
'modalId' => 'privacy-modal',
'title' => "Informativa privacy ai sensi dell’art. 13 del Regolamento (UE) 2016/679",
])

<div
    id="{{ $modalId }}"
    class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/50 p-4"
    data-privacy-overlay="{{ $modalId }}"
    aria-modal="true" role="dialog">
    <div class="bg-white max-w-3xl w-full rounded-xl shadow-lg overflow-y-auto max-h-[90vh] p-6 relative">
        <button type="button" data-privacy-close="{{ $modalId }}"
            class="absolute top-3 right-3 inline-flex h-8 w-8 items-center justify-center rounded-full text-slate-500 hover:text-slate-800 hover:bg-slate-100"
            aria-label="Chiudi modale">✕</button>

        <h2 class="text-lg font-bold mb-4">{{ $title }}</h2>

        <div class="space-y-4 text-sm leading-relaxed max-h-[70vh] overflow-y-auto pr-2">
            {{-- TESTO COMPLETO --}}
            <p>
                Ai sensi e per gli effetti dell’art. 13 del Regolamento (UE) 2016/679 - relativo alla protezione
                delle persone fisiche con riguardo al trattamento dei dati personali – ed in conformità alla normativa di riferimento
                nonché base giuridica del trattamento (Codice della Protezione civile, D. Lgs n. 1/2018, L.R. 13/2022 “Disciplina delle attività di protezione civile”).
            </p>
            <p>
                La informiamo che i dati personali (nome, cognome, email, ecc.) da Lei conferiti – in qualità di operatore volontario
                della Protezione Civile o di referente di organizzazione di volontariato – saranno trattati secondo i principi di correttezza,
                liceità, trasparenza nonché nel rispetto della normativa applicabile – nazionale ed europea – in materia di tutela e protezione dei dati personali,
                per le finalità istituzionali di competenza della Direzione Protezione Civile, Sicurezza e Polizia Locale come previste dal D. Lgs. 1/2018,
                dalla L.R. 13/2022 e dai vigenti regolamenti regionali in materia.
            </p>

            <p><strong>Titolare del trattamento:</strong> Regione del Veneto / Giunta Regionale, con sede a Palazzo Balbi - Dorsoduro, 3901, 30123 – Venezia.</p>

            <p>
                <strong>Delegato al trattamento:</strong> Direttore della Direzione Protezione Civile, Sicurezza e Polizia Locale, ai sensi della DGR n. 596 del 08.05.2018. <br>
                Email:
                <a href="mailto:protezionecivilepolizialocale@regione.veneto.it" class="underline text-sky-600">
                    protezionecivilepolizialocale@regione.veneto.it
                </a>
                – PEC:
                <a href="mailto:protezionecivilepolizialocale@pec.veneto.it" class="underline text-sky-600">
                    protezionecivilepolizialocale@pec.veneto.it
                </a>
            </p>

            <p>
                <strong>Responsabile della Protezione dei dati / Data Protection Officer:</strong> Palazzo Sceriman, Cannaregio, 168, 30121 – Venezia. <br>
                Email: <a href="mailto:dpo@regione.veneto.it" class="underline text-sky-600">dpo@regione.veneto.it</a>
                – PEC: <a href="mailto:dpo@pec.regione.veneto.it" class="underline text-sky-600">dpo@pec.regione.veneto.it</a>
            </p>

            <h3 class="font-semibold mt-4">Natura dei dati trattati e finalità del trattamento</h3>
            <p>I dati personali (nome, cognome, email, ecc.) saranno trattati al solo fine di consentire ad ogni socio volontario di:</p>
            <ul class="list-disc list-inside space-y-1">
                <li>prestare il proprio servizio in qualità di operativo e consentire contestualmente – in relazione a domande di partecipazione a bandi, avvisi finalizzati all’ottenimento di contributi o rimborsi di cui agli artt. 39 e 40 D. Lgs n. 1/2018 – all’Organizzazione di volontariato la concessione dei contributi di protezione civile di cui alle citate disposizioni normative.</li>
                <li>essere utilizzati altresì nell’ambito di accordi istituzionali con altre Autorità e componenti del servizio nazionale di protezione civile e funzionali allo svolgimento, da parte del conferente, dell’attività di volontario di protezione civile.</li>
            </ul>

            <h3 class="font-semibold mt-4">Base giuridica del trattamento</h3>
            <p>
                La base giuridica del trattamento dei dati personali forniti, per le predette finalità, è costituita dal Suo consenso
                manifestato all’atto del conferimento dei dati stessi, nonché dalle disposizioni di legge e regolamentari relative al
                servizio nazionale di protezione civile.
            </p>

            <h3 class="font-semibold mt-4">Facoltatività del conferimento dei dati e conseguenze del rifiuto</h3>
            <p>Il conferimento dei dati personali non è obbligatorio: tuttavia il mancato, parziale o inesatto conferimento degli stessi comporterà l’impossibilità di utilizzare i predetti dati per le sopra indicate finalità.</p>

            <h3 class="font-semibold mt-4">Periodo di conservazione dei dati</h3>
            <p>I dati personali saranno conservati per un periodo di tempo non superiore al raggiungimento della summenzionata finalità, salvo che la legge e/o la normativa di settore preveda un diverso periodo di conservazione degli stessi.</p>

            <h3 class="font-semibold mt-4">Comunicazione dei dati</h3>
            <p>I dati personali potranno essere comunicati alle Autorità e ai Componenti del servizio Nazionale di Protezione Civile ove funzionali alle attività istituzionali della Direzione Protezione Civile, Sicurezza e Polizia Locale e allo svolgimento, da parte del conferente, dell’attività di volontario di protezione civile.</p>
            <p>I dati non saranno trasferiti all’estero.</p>

            <h3 class="font-semibold mt-4">Modalità del trattamento dei dati</h3>
            <p>Il trattamento dei dati personali conferiti sarà effettuato sia con l’ausilio di strumenti informatici idonei a garantire la sicurezza e la riservatezza dei dati trattati sia senza l’ausilio di detti strumenti (trattamento cartaceo).</p>
            <p>Il trattamento è svolto da soggetti autorizzati con opportune istruzioni operative in materia di tutela dei dati personali.</p>

            <h3 class="font-semibold mt-4">Diritti degli interessati</h3>
            <p>
                L’interessato può esercitare, in qualsiasi momento, i diritti previsti dagli artt. 15 e ss. del Regolamento (UE) 2016/679,
                compresa la cancellazione dei dati e la revoca del consenso.
            </p>
            <p>
                Per l’esercizio dei propri diritti l’interessato può utilizzare il modulo sul sito del Garante
                <a href="https://www.garanteprivacy.it" class="underline text-sky-600" target="_blank" rel="noreferrer">www.garanteprivacy.it</a>
                e inoltrare le richieste al Titolare del trattamento (anche tramite DPO).
            </p>
            <p>
                È possibile proporre reclamo al Garante per la protezione dei dati personali (Piazza Venezia, 11 – 00187 Roma),
                seguendo le indicazioni su
                <a href="https://www.garanteprivacy.it" class="underline text-sky-600" target="_blank" rel="noreferrer">www.garanteprivacy.it</a>.
            </p>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    (function() {
        if (window.__privacyModalBound) return;
        window.__privacyModalBound = true;

        const open = (id) => {
            const modal = document.getElementById(id);
            if (!modal) return;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // focus management (accessibilità di base)
            const closeBtn = modal.querySelector('[data-privacy-close]');
            closeBtn?.focus();
        };

        const close = (id) => {
            const modal = document.getElementById(id);
            if (!modal) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };

        // Delegazione apertura/chiusura
        document.addEventListener('click', (e) => {
            const opener = e.target.closest('[data-privacy-open]');
            if (opener) {
                e.preventDefault();
                open(opener.getAttribute('data-privacy-open'));
                return;
            }

            const closer = e.target.closest('[data-privacy-close]');
            if (closer) {
                e.preventDefault();
                close(closer.getAttribute('data-privacy-close'));
                return;
            }

            // Clic sull'overlay
            const overlayId = e.target?.getAttribute?.('data-privacy-overlay');
            if (overlayId) {
                close(overlayId);
            }
        });

        // Esc chiude la modale aperta
        document.addEventListener('keydown', (e) => {
            if (e.key !== 'Escape') return;
            document.querySelectorAll('[id^="privacy-modal"]').forEach(m => {
                if (getComputedStyle(m).display !== 'none') close(m.id);
            });
        });
    })();
</script>
@endpush
@endonce