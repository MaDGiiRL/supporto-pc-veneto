<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comunicazione extends Model
{
    protected $table = 'sor.comunicazioni';
    public $timestamps = false;

    protected $fillable = [
        'evento_id',
        'comunicata_il',
        'tipo',
        'verso',
        'mitt_dest',
        'telefono',
        'email',
        'indirizzo',
        'provincia',
        'comune',
        'aree',
        'oggetto',
        'contenuto',
        'priorita',
        'operatore',
    ];

    protected $casts = [
        'aree' => 'array',
        'comunicata_il' => 'datetime',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }
}
