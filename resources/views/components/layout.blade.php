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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="h-full antialiased font-[Inter] bg-slate-50 text-slate-900">
    <x-navbar />

    <main class="min-h-screen">
        {{ $slot }}
    </main>

    @if (View::exists('components.footer'))
    <x-footer />
    @endif

    {{-- niente script dark mode --}}
    @stack('scripts')
</body>

</html>