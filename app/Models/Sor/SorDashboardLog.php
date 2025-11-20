<?php

namespace App\Models\Sor;

use Illuminate\Database\Eloquent\Model;

class SorDashboardLog extends Model
{
    protected $table = 'sor.sor_dashboard_logs';
    public $timestamps = false;

    protected $fillable = [
        'segnalazione_id',
        'evento_id',
        'action',
        'from_status',
        'to_status',
        'from_assignee',
        'to_assignee',
        'details',
        'performed_by',
        'performed_by_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
