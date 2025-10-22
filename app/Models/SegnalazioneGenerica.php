<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegnalazioneGenerica extends Model
{
    use HasFactory;

    // *** usa lo schema sor come gli altri modelli ***
    protected $table = 'sor.segnalazioni_generiche'; // <-- se la tua tabella si chiama diversamente, mettila qui

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
