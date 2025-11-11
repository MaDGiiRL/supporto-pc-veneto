<?php

namespace App\Models\Sor;

use Illuminate\Database\Eloquent\Model;

class SorLog extends Model
{
    protected $table = 'sor.sor_logs';
    public $timestamps = false;
    protected $fillable = [
        'segnalazione_id',
        'action',
        'from_status',
        'to_status',
        'from_assignee',
        'to_assignee',
        'details',
        'performed_by',
        'performed_by_id',
        'created_at',
        'updated_at'
    ];
}
