@props(['headers' => []])
<div class="overflow-x-auto">
    <table {{ $attributes->merge(['class'=>'w-full text-sm']) }}>
        <thead class="bg-slate-50 text-left">
            <tr>
                @foreach($headers as $h)
                <th class="px-3 py-2">{{ $h }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>{{ $slot }}</tbody>
    </table>
</div>