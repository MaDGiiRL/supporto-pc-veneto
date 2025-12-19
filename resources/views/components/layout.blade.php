@props([
'title' => 'Titolo di Default',
'hideFooter' => false,
])

<!DOCTYPE html>
<html lang="it" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Titolo di Default' }}</title>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>


<body class="h-full antialiased font-[Inter] bg-white text-slate-900">
    <x-banner-avviso dataLimite="01/01/2026" />

    <x-navbar />

    <main class="min-h-screen">
        {{ $slot }}
    </main>

    {{-- Footer opzionale --}}
    @unless($hideFooter)
    @if (View::exists('components.footer'))
    <x-footer />
    @endif
    @endunless

    {{-- Toast da sessione (usa Swal caricato in <head>) --}}
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
                    timer: 2000,
                });
            });
        })();
    </script>
    @endif

    @include('partials.sor-modals')

    <script>
        window.PROVINCE = @json(config('province.veneto'));
        window.VENETO_COMUNI = @json(config('comuni_veneto'));
        window.SOR_CAN_EDIT_COORDS = @json(auth()->user()?->can('sor.edit_coords') ?? true);
    </script>

    @stack('scripts')

</body>

</html>