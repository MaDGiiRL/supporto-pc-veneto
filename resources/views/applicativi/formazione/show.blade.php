{{-- resources/views/applicativi/formazione/show.blade.php --}}
@php
$title = $app['title'] ?? 'Gestione formazione';
@endphp

<x-layout :title="$title" :hideFooter="false">

    <div class="w-full min-h-screen bg-white">
        ... (il tuo markup show invariato) ...
        @include('applicativi.formazione.partials.modals')
    </div>

    @include('applicativi.formazione.partials.styles')

    <script>
        (function() {
            console.log('✅ Formazione show scripts loaded');

            // MODALI (stesso codice index)
            const openModal = (sel) => {
                const m = document.querySelector(sel);
                if (!m) return;
                m.classList.remove('hidden');
                m.setAttribute('aria-hidden', 'false');
                document.documentElement.classList.add('overflow-hidden');
            };
            const closeModal = (m) => {
                if (!m) return;
                m.classList.add('hidden');
                m.setAttribute('aria-hidden', 'true');
                document.documentElement.classList.remove('overflow-hidden');
            };
            document.addEventListener('click', (e) => {
                const btn = e.target.closest('[data-open-modal]');
                if (!btn) return;
                e.preventDefault();
                openModal(btn.getAttribute('data-open-modal'));
            });
            document.addEventListener('click', (e) => {
                const closeBtn = e.target.closest('[data-close-modal]');
                if (!closeBtn) return;
                const modal = e.target.closest('.c-modal');
                closeModal(modal);
            });
            document.addEventListener('keydown', (e) => {
                if (e.key !== 'Escape') return;
                const open = document.querySelector('.c-modal:not(.hidden)');
                if (open) closeModal(open);
            });

            // TAB SWITCH show
            const app = document.getElementById('fm-course-app');
            if (app) {
                const tabs = Array.from(app.querySelectorAll('.sor-tab[data-tab]'));
                const panels = Array.from(app.querySelectorAll('.fm-tab[data-tab-panel]'));

                const setTab = (key) => {
                    tabs.forEach(t => {
                        const on = t.dataset.tab === key;
                        t.classList.toggle('is-active', on);
                        t.setAttribute('aria-current', on ? 'page' : 'false');
                    });
                    panels.forEach(p => p.classList.toggle('hidden', p.dataset.tabPanel !== key));
                    const active = tabs.find(t => t.dataset.tab === key);
                    if (active) active.scrollIntoView({
                        behavior: 'smooth',
                        inline: 'center',
                        block: 'nearest'
                    });
                };

                tabs.forEach(t => t.addEventListener('click', () => setTab(t.dataset.tab)));
                const init = tabs.find(t => t.classList.contains('is-active'))?.dataset.tab || 'overview';
                setTab(init);
            }

        })();
    </script>

</x-layout>