<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'sor.eventi';
    public $timestamps = false;

    protected $fillable = [
        'tipologia',
        'descrizione',
        'aree',
        'aperto',
        'aggiornato_il',
        'operatore',
    ];

    protected $casts = [
        'aree' => 'array',
        'aperto' => 'boolean',
        'aggiornato_il' => 'datetime',
    ];

    public function comunicazioni()
    {
        return $this->hasMany(Comunicazione::class, 'evento_id')->orderByDesc('comunicata_il')->orderByDesc('id');
    }

    public function segnalazioni()
    {
        return $this->hasMany(SegnalazioneGenerica::class, 'evento_id')->orderByDesc('creata_il')->orderByDesc('id');
    }
}
