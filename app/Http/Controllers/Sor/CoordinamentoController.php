<?php

namespace App\Http\Controllers\Sor;

use App\Http\Controllers\Controller;
use App\Models\SegnalazioneGenerica;
use App\Models\Sor\SorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoordinamentoController extends Controller
{
    const STATUS_OPEN   = 'aperta';
    const STATUS_WORK   = 'in_lavorazione';
    const STATUS_CLOSED = 'chiusa';

    /**
     * Ruoli esposti al client
     */
    public function roles()
    {
        return response()->json([
            ['slug' => 'coordinamento', 'label' => 'Coordinamento (Admin)', 'can_assign' => true, 'can_close' => true],
            ['slug' => 'volontariato',  'label' => 'Volontariato',          'can_assign' => false, 'can_close' => true],
            ['slug' => 'mezzi',         'label' => 'Mezzi e Materiali',     'can_assign' => false, 'can_close' => true],
            ['slug' => 'prociv',        'label' => 'Protezione Civile',     'can_assign' => false, 'can_close' => true],
        ]);
    }

    /**
     * Lista segnalazioni generiche (filtri: status, assigned_to)
     */
    public function listSegnalazioni(Request $r)
    {
        $status = $r->string('status');
        $ass    = $r->string('assigned_to');

        $q = SegnalazioneGenerica::query()
            ->select([
                'id',
                'sintesi',
                'tipologia',
                'aree',
                'operatore',
                'creata_il',
                'status',
                'assigned_to',
                'instructions',
                'last_note_text',
                'last_note_by',
                'last_note_at'
            ])
            ->orderByDesc('creata_il')
            ->orderByDesc('id');

        if ($status->isNotEmpty()) $q->where('status', $status->toString());
        if ($ass->isNotEmpty())    $q->where('assigned_to', $ass->toString());

        $rows = $q->limit((int)$r->integer('per_page', 200))->get()->map(function ($s) {
            return [
                'id'           => $s->id,
                'sintesi'      => $s->sintesi,
                'tipologia'    => $s->tipologia ?? 'altro',
                'aree'         => $s->aree ?? [],
                'operatore'    => $s->operatore,
                'created_at'   => $s->creata_il,
                'status'       => $s->status ?? self::STATUS_OPEN,
                'assigned_to'  => $s->assigned_to,
                'instructions' => $s->instructions,
                'last_note'    => $s->last_note_text ? [
                    'text' => $s->last_note_text,
                    'by'   => $s->last_note_by,
                    'at'   => $s->last_note_at,
                ] : null,
            ];
        });

        return response()->json($rows);
    }

    /**
     * Assegna una segnalazione (solo ruolo coordinamento)
     */
    public function assign(Request $r, int $id)
    {
        $me   = $r->user();
        $role = $me->role ?? 'coordinamento';

        if ($role !== 'coordinamento') {
            return response()->json(['message' => 'Operazione non permessa'], 403);
        }

        $to = (string)$r->input('to');
        if (!in_array($to, ['volontariato', 'mezzi', 'prociv'], true)) {
            return response()->json(['message' => 'Ruolo non valido'], 422);
        }

        $instructions = trim((string)($r->input('instructions') ?? ''));

        DB::transaction(function () use ($id, $me, $to, $instructions) {
            $prev = SegnalazioneGenerica::findOrFail($id);

            SegnalazioneGenerica::whereKey($id)->update([
                'status'       => self::STATUS_WORK,
                'assigned_to'  => $to,
                'instructions' => $instructions ?: null,
            ]);

            SorLog::create([
                'segnalazione_id' => $id,
                'action'          => 'assign',
                'from_status'     => $prev->status ?? self::STATUS_OPEN,
                'to_status'       => self::STATUS_WORK,
                'from_assignee'   => $prev->assigned_to,
                'to_assignee'     => $to,
                'details'         => $instructions ?: null,
                'performed_by'    => $me->name ?? $me->email ?? 'system',
                'performed_by_id' => $me->id ?? null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        });

        return response()->json(['ok' => true]);
    }

    /**
     * Aggiungi nota (tutti i ruoli)
     */
    public function addNote(Request $r, int $id)
    {
        $r->validate(['text' => ['required', 'string', 'min:1']]);
        $me   = $r->user();
        $text = trim($r->input('text'));

        DB::transaction(function () use ($id, $me, $text) {
            SegnalazioneGenerica::whereKey($id)->update([
                'last_note_text' => $text,
                'last_note_by'   => $me->name ?? $me->email ?? 'system',
                'last_note_at'   => now(),
            ]);

            SorLog::create([
                'segnalazione_id' => $id,
                'action'          => 'note',
                'details'         => $text,
                'performed_by'    => $me->name ?? $me->email ?? 'system',
                'performed_by_id' => $me->id ?? null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        });

        return response()->json(['ok' => true]);
    }

    /**
     * Chiudi segnalazione
     */
    public function close(Request $r, int $id)
    {
        $me = $r->user();

        DB::transaction(function () use ($id, $me) {
            $prev = SegnalazioneGenerica::findOrFail($id);

            SegnalazioneGenerica::whereKey($id)->update([
                'status' => self::STATUS_CLOSED,
            ]);

            SorLog::create([
                'segnalazione_id' => $id,
                'action'          => 'close',
                'from_status'     => $prev->status ?? self::STATUS_OPEN,
                'to_status'       => self::STATUS_CLOSED,
                'from_assignee'   => $prev->assigned_to,
                'to_assignee'     => $prev->assigned_to,
                'performed_by'    => $me->name ?? $me->email ?? 'system',
                'performed_by_id' => $me->id ?? null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        });

        return response()->json(['ok' => true]);
    }

    /**
     * Elenco dei log (visibile a coordinamento o ruoli autorizzati)
     */
    public function logs(Request $r)
    {
        $page    = max((int)$r->integer('page', 1), 1);
        $perPage = min(max((int)$r->integer('per_page', 10), 1), 100);

        $q = SorLog::query()->orderByDesc('created_at');

        if ($r->filled('segnalazione_id')) {
            $q->where('segnalazione_id', (int)$r->integer('segnalazione_id'));
        }

        $total = (clone $q)->count();

        $rows = $q->forPage($page, $perPage)->get()->map(function ($l) {
            return [
                'id'              => $l->id ?? null,
                'segnalazione_id' => $l->segnalazione_id,
                'action'          => $l->action,
                'from_status'     => $l->from_status,
                'to_status'       => $l->to_status,
                'from_assignee'   => $l->from_assignee,
                'to_assignee'     => $l->to_assignee,
                'details'         => $l->details,
                'by'              => $l->performed_by,
                'created_at'      => $l->created_at,
            ];
        });

        return response()->json([
            'data' => $rows,
            'meta' => [
                'current_page' => $page,
                'last_page'    => (int)ceil($total / $perPage),
                'total'        => $total,
            ],
        ]);
    }
}
