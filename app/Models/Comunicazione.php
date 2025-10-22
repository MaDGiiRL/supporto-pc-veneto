<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comunicazione extends Model
{
    protected $table = 'sor.comunicazioni';

    // Se la tabella non ha created_at/updated_at
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
        'priorita'
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
