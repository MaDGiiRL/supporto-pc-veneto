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

    <link rel="shortcut icon" href="/media/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Carica prima SweetAlert2, così è disponibile quando lo usi --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- SheetJS per esportare gli excel --}}
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="h-full antialiased font-[Inter] bg-white text-slate-900">
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
    @endif

    @stack('scripts')
</body>

</html>