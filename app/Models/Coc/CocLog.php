<?php

namespace App\Models\Coc;

use Illuminate\Database\Eloquent\Model;

class CocLog extends Model
{
    // append-only, niente updated_at
    public $timestamps = false;

    protected $table = 'coc.coc_logs';

    protected $fillable = [
        'codistat',
        'from_stato_id',
        'to_stato_id',
        'from_fase_id',
        'to_fase_id',
        'from_decorrenza',
        'to_decorrenza',
        'from_descrizione',
        'to_descrizione',
        'action',
        'performed_by',
        'performed_by_id',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'from_decorrenza' => 'date',
            'to_decorrenza'   => 'date',
            'created_at'      => 'datetime',
        ];
    }
}
