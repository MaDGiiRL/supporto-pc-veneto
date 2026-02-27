@php $page = $page ?? ['label' => 'Sezione']; @endphp

<div class="card">
    <div class="card-h">
        <div>
            <div class="text-lg font-bold">{{ $page['label'] ?? 'Sezione' }}</div>
            <div class="help">Sezione non ancora disponibile (placeholder).</div>
        </div>
    </div>
    <div class="card-b">
        <div class="help">
            Collega qui i dati dal back e sostituisci il contenuto.
        </div>
    </div>
</div>
