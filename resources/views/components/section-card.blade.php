@props([
'href' => '#',
'title' => '',
'subtitle' => 'Vai alla sezione',
'description' => '',
'img' => null,
'imgAlt' => '',
])

<a href="{{ $href }}"
    {{ $attributes->merge([
      'class' => 'group block rounded-2xl relative
                  bg-white
                  border border-slate-200
                  ring-1 ring-slate-900/5
                  pt-4 pb-6 sm:pt-5 sm:pb-7 px-6 sm:px-7
                  shadow-sm hover:shadow-md hover:bg-slate-50
                  transition transition-colors duration-200 hover:-translate-y-0.5
                  focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-300/70'
   ]) }}>
    <div class="flex items-center gap-4">
        <div class="size-12 sm:size-14 flex items-center justify-center shrink-0 rounded-xl
                border border-slate-200
                bg-slate-100
                transition transition-colors duration-200 group-hover:bg-slate-50">
            {{ $icon ?? '' }}
        </div>

        <div class="min-w-0">
            <h3 class="text-base sm:text-lg font-semibold leading-snug text-slate-900">
                {{ $title }}
            </h3>
            @if($subtitle)
            <p class="text-xs sm:text-sm mt-1 text-slate-600">{{ $subtitle }}</p>
            @endif
        </div>

        <div class="ml-auto translate-x-0 group-hover:translate-x-1 transition-transform duration-200">
            <div class="size-8 sm:size-9 rounded-full flex items-center justify-center
                  border border-slate-200
                  bg-slate-100 transition transition-colors duration-200
                  group-hover:bg-slate-50">
                <x-heroicon-o-chevron-right class="h-4 w-4 text-slate-600" />
            </div>
        </div>
    </div>

    @if($description)
    <p class="mt-4 text-sm text-slate-700">{{ $description }}</p>
    @endif

    @if($img)
    <div class="mt-5">
        <img src="{{ asset($img) }}" alt="{{ $imgAlt }}"
            class="rounded-xl border border-slate-200 w-full h-55 object-cover" />
    </div>
    @endif
</a>