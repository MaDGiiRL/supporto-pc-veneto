<?php

namespace App\Http\Controllers\Sor;

use App\Http\Controllers\Controller;
use App\Models\SegnalazioneGenerica;
use App\Models\Sor\SorLog;          // ⬅️ import modello log coordinamento
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SegnalazioneOpsController extends Controller
{
    const OPEN   = 'aperta';
    const WORK   = 'in_lavorazione';
    const CLOSED = 'chiusa';

    public function roles()
    {
        return response()->json([
            ['slug' => 'coordinamento', 'label' => 'Coordinamento', 'can_assign' => true, 'can_close' => true],
            ['slug' => 'volontariato', 'label' => 'Volontariato', 'can_assign' => false, 'can_close' => true],
            ['slug' => 'mezzi',        'label' => 'Mezzi e Materiali', 'can_assign' => false, 'can_close' => true],
            ['slug' => 'prociv',       'label' => 'Protezione Civile', 'can_assign' => false, 'can_close' => true],
        ]);
    }

    public function assign(Request $r, int $id)
    {
        $to = (string) $r->input('to');
        $instructions = trim((string) ($r->input('instructions') ?? ''));
        if (!in_array($to, ['volontariato', 'mezzi', 'prociv'], true)) {
            return response()->json(['message' => 'Ruolo non valido'], 422);
        }

        $me  = $r->user();
        $who = $me->name ?? $me->email ?? 'system';

        DB::transaction(function () use ($id, $to, $instructions, $who, $me) {
            $row = SegnalazioneGenerica::lockForUpdate()->findOrFail($id);
            $prevStatus = $row->status ?? self::OPEN;
            $prevAss    = $row->assigned_to;

            $row->status       = self::WORK;
            $row->assigned_to  = $to;
            $row->instructions = $instructions ?: null;
            $row->save();

            DB::table('sor.sor_logs')->insert([
                'segnalazione_id' => $row->id,
                'action'          => 'assign',
                'from_status'     => $prevStatus,
                'to_status'       => self::WORK,
                'from_assignee'   => $prevAss,
                'to_assignee'     => $to,
                'details'         => $instructions ?: null,
                'performed_by'    => $who,
                'performed_by_id' => $me->id ?? null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        });

        return response()->json(['ok' => true]);
    }

    public function addNote(Request $r, int $id)
    {
        $r->validate(['text' => ['required', 'string', 'min:1']]);
        $me   = $r->user();
        $who  = $me->name ?? $me->email ?? 'system';
        $text = trim($r->input('text'));

        DB::transaction(function () use ($id, $who, $me, $text) {
            DB::table('sor.sor_notes')->insert([
                'segnalazione_id' => $id,
                'text'            => $text,
                'created_by'      => $who,
                'created_by_id'   => $me->id ?? null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            SegnalazioneGenerica::whereKey($id)->update([
                'last_note_text' => $text,
                'last_note_by'   => $who,
                'last_note_at'   => now(),
            ]);

            DB::table('sor.sor_logs')->insert([
                'segnalazione_id' => $id,
                'action'          => 'note',
                'details'         => $text,
                'performed_by'    => $who,
                'performed_by_id' => $me->id ?? null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        });

        return response()->json(['ok' => true]);
    }

    public function close(Request $r, int $id)
    {
        $me  = $r->user();
        $who = $me->name ?? $me->email ?? 'system';

        DB::transaction(function () use ($id, $who, $me) {
            $row = SegnalazioneGenerica::lockForUpdate()->findOrFail($id);
            $prevStatus = $row->status ?? self::OPEN;
            $prevAss    = $row->assigned_to;

            $row->status = self::CLOSED;
            $row->save();

            DB::table('sor.sor_logs')->insert([
                'segnalazione_id' => $row->id,
                'action'          => 'close',
                'from_status'     => $prevStatus,
                'to_status'       => self::CLOSED,
                'from_assignee'   => $prevAss,
                'to_assignee'     => $prevAss,
                'performed_by'    => $who,
                'performed_by_id' => $me->id ?? null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        });

        return response()->json(['ok' => true]);
    }

    public function logs(Request $r)
    {
        $page = max((int) $r->integer('page', 1), 1);
        $per  = min(max((int) $r->integer('per_page', 10), 1), 100);

        $q = SorLog::query()->orderByDesc('created_at')->orderByDesc('id');

        if ($r->filled('segnalazione_id')) {
            $q->where('segnalazione_id', (int) $r->integer('segnalazione_id'));
        }

        $total = (clone $q)->count();
        $rows  = $q->forPage($page, $per)->get();

        return response()->json([
            'data' => $rows,
            'meta' => [
                'current_page' => $page,
                'last_page'    => (int) ceil($total / $per),
                'total'        => $total,
            ],
        ]);
    }
}
