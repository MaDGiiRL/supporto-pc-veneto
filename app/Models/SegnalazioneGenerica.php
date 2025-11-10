<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegnalazioneGenerica extends Model
{
    use HasFactory;

    protected $table = 'sor.segnalazioni_generiche';
    public $timestamps = false;

    protected $fillable = [
        'creata_il',
        'direzione',
        'tipologia',
        'aree',
        'sintesi',
        'operatore',
        'priorita',
        'evento_id',
    ];

    protected $casts = [
        'aree'      => 'array',
        'creata_il' => 'datetime',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }
}
