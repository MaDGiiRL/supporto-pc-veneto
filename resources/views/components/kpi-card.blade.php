@props(['icon' => null, 'label' => '', 'value' => '-', 'badge' => null])
<div class="rounded-2xl border border-slate-200 bg-white shadow-card p-4">
    <p class="flex items-center gap-1 text-sm text-slate-500">{!! $icon !!} {{ $label }}</p>
    <div class="flex items-end justify-between">
        <div class="text-3xl font-semibold text-slate-900">{{ $value }}</div>
        @if($badge)
        <span class="inline-flex items-center gap-1 rounded-full border px-2 py-0.5 text-xs border-slate-200 text-slate-700 bg-slate-50">{!! $badge !!}</span>
        @endif
    </div>
</div>