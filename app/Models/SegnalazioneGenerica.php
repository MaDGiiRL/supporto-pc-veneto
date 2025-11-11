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
  'creata_il','direzione','tipologia','aree','sintesi','operatore','priorita','evento_id',
  'status','assigned_to','instructions','last_note_text','last_note_by','last_note_at',
    ];

    protected $casts = [
        'aree'      => 'array',
        'creata_il' => 'datetime',
        'last_note_at' => 'datetime',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }
}
