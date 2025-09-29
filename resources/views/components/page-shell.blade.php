@props(['title' => '', 'description' => null])

<div class="p-6">
    <header class="mb-4">
        <h2 class="text-xl font-semibold">{{ $title }}</h2>
        @if($description)
        <p class="text-sm opacity-75 mt-1">{{ $description }}</p>
        @endif
    </header>
    <div class="border-t border-slate-200 pt-4">
        {{ $slot }}
    </div>
</div>