@props([
'title' => 'Titolo di Default',
'hideFooter' => false, // 👈 prop con default
])

<!DOCTYPE html>
<html lang="it" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Titolo di Default' }}</title>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- SheetJS per esportare gli excel --}}
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="h-full antialiased font-[Inter] bg-white text-slate-900">

    <x-banner-avviso dataLimite="01/01/2026" />

    <x-navbar />

    <main class="min-h-screen">
        {{ $slot }}
    </main>

    {{-- 👇 render footer solo se NON richiesto di nasconderlo --}}
    @unless($hideFooter)
    @if (View::exists('components.footer'))
    <x-footer />
    @endif
    @endunless

    {{-- SweetAlert2 prima dell'uso + @stack('scripts') ecc. --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('alert'))
    <script>
        (function() {
            const alertData = @json(session('alert'));
            window.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: alertData?.type ?? 'success',
                    title: alertData?.title ?? 'Operazione riuscita',
                    text: alertData?.message ?? '',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        })();
    </script>

    <script src="/js/echo.js"></script> <!-- il tuo bundle -->
    <script>
        import Echo from 'laravel-echo';
        window.Pusher = require('pusher-js'); // se usi Pusher

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: 'PUSHER_KEY',
            cluster: 'eu',
            forceTLS: true
        });

        // 🔔 subscriptions
        window.Echo.channel('sor')
            .listen('.segnalazione.saved', async () => {
                await refreshGEN();
            })
            .listen('.segnalazione.deleted', async () => {
                await refreshGEN();
            })
            .listen('.comunicazione.saved', async () => {
                const id = state.ui.currentEventId;
                if (id) await openEventModal(id); // ricarica dettaglio
                await refreshONGOING();
            })
            .listen('.comunicazione.deleted', async () => {
                const id = state.ui.currentEventId;
                if (id) await openEventModal(id);
                await refreshONGOING();
            })
            .listen('.evento.saved', async () => {
                await refreshONGOING();
            })
            .listen('.evento.toggled', async () => {
                await refreshONGOING();
            });
    </script>

    <script>
        if (!res.ok) {
            const txt = await res.text().catch(() => "");
            Swal.fire({
                title: "Errore",
                text: txt || `HTTP ${res.status}`,
                icon: "error"
            });
            throw new Error(`HTTP ${res.status} ${res.statusText}\n${txt}`);
        }
    </script>
    @endif

    @stack('scripts')
</body>

</html>