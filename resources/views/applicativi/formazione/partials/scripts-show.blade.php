{{-- resources/views/applicativi/formazione/partials/scripts-show.blade.php --}}

{{-- riusa modali + wheel/drag nav --}}
@include('applicativi.formazione.partials.scripts')

<script>
    /**
     * TAB SWITCH (show): usa data-tab / data-tab-panel
     */
    (() => {
        const app = document.getElementById('fm-course-app');
        if (!app) return;

        const nav = app.querySelector('[data-sor-hnav-rail]');
        const tabs = Array.from(app.querySelectorAll('.sor-tab[data-tab]'));
        const panels = Array.from(app.querySelectorAll('.fm-tab[data-tab-panel]'));

        const setTab = (key) => {
            tabs.forEach(t => {
                const on = t.dataset.tab === key;
                t.classList.toggle('is-active', on);
                t.setAttribute('aria-current', on ? 'page' : 'false');
            });
            panels.forEach(p => {
                const on = p.dataset.tabPanel === key;
                p.classList.toggle('hidden', !on);
            });

            const active = tabs.find(t => t.dataset.tab === key);
            if (active) active.scrollIntoView({
                behavior: 'smooth',
                inline: 'center',
                block: 'nearest'
            });
        };

        tabs.forEach(t => t.addEventListener('click', () => setTab(t.dataset.tab)));

        // init
        const init = tabs.find(t => t.classList.contains('is-active'))?.dataset.tab || 'overview';
        setTab(init);
    })();
</script>