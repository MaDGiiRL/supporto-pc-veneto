@props([
  'title' => 'Titolo di Default',
  'hideFooter' => false,
  'hideNavbar' => false,
])

<!DOCTYPE html>
<html lang="it" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Titolo di Default' }}</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    {{-- IMPORTANTISSIMO: prima di @vite --}}
    <script>
        window.PROVINCE = @json((array) config('province.veneto', []));
        window.VENETO_COMUNI = @json((array) config('comuni_veneto', []));
        window.SOR_CAN_EDIT_COORDS = @json(auth()->user()?->can('sor.edit_coords') ?? true);
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>

<body class="h-full antialiased font-[Inter] bg-white text-slate-900">

    <x-banner-avviso dataLimite="01/01/2026" />

    @unless($hideNavbar)
        <x-navbar />
    @endunless

    <main class="min-h-screen">
        {{ $slot }}
    </main>

    @unless($hideFooter)
        @if (View::exists('components.footer'))
            <x-footer />
        @endif
    @endunless

    {{-- Toast da sessione --}}
    @if(session('alert'))
        <script>
            (function() {
                const alertData = @json(session('alert'));
                window.addEventListener('DOMContentLoaded', function() {
                    if (!window.Swal) return;
                    Swal.fire({
                        icon: alertData?.type ?? 'success',
                        title: alertData?.title ?? 'Operazione riuscita',
                        text: alertData?.message ?? '',
                        showConfirmButton: false,
                        timer: 2000,
                    });
                });
            })();
        </script>
    @endif

    {{-- ✅ MODALI SOR (ora in resources/views/partials/sor-modals.blade.php) --}}
    @include('partials.sor-modals')

    @stack('scripts')
</body>
</html>
