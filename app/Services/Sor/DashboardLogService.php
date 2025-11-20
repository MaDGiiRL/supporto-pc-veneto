<?php
// app/Services/Sor/DashboardLogService.php

namespace App\Services\Sor;

use App\Models\Sor\SorDashboardLog;
use Illuminate\Support\Facades\Auth;

class DashboardLogService
{
    public function log(
        string $action,
        array $data = []
    ): SorDashboardLog {
        $user = Auth::user();

        return SorDashboardLog::create([
            'segnalazione_id' => $data['segnalazione_id'] ?? null,
            'evento_id'       => $data['evento_id'] ?? null,
            'from_status'     => $data['from_status'] ?? null,
            'to_status'       => $data['to_status'] ?? null,
            'from_assignee'   => $data['from_assignee'] ?? null,
            'to_assignee'     => $data['to_assignee'] ?? null,
            'details'         => $data['details'] ?? null,
            'performed_by'    => $data['performed_by'] ?? ($user?->name ?? null),
            'performed_by_id' => $data['performed_by_id'] ?? ($user?->id ?? null),
            'created_at'      => now(),
            'updated_at'      => now(),
        ] + ['action' => $action]);
    }
}
