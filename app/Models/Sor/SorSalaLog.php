<?php

namespace App\Models\Sor;

use Illuminate\Database\Eloquent\Model;

class SorSalaLog extends Model
{
    protected $table = 'sor.sor_sala_logs';
    public $timestamps = false;

    protected $fillable = [
        'from_stato_id',
        'to_stato_id',
        'from_config_id',
        'to_config_id',
        'from_decorrenza',
        'to_decorrenza',
        'from_descrizione',
        'to_descrizione',
        'from_rischi',
        'to_rischi',
        'from_funzioni',
        'to_funzioni',
        'action',
        'performed_by',
        'performed_by_id',
        'created_at',
    ];

    protected $casts = [
        'from_decorrenza' => 'date',
        'to_decorrenza'   => 'date',
        'from_rischi'     => 'array',
        'to_rischi'       => 'array',
        'from_funzioni'   => 'array',
        'to_funzioni'     => 'array',
        'created_at'      => 'datetime',
    ];
}
