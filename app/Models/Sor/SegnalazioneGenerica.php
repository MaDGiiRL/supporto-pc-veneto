<?php

namespace App\Models\Sor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Evento;

class SegnalazioneGenerica extends Model
{
    use HasFactory;

    protected $table = 'sor.segnalazioni_generiche';
    public $timestamps = false;

    protected $fillable = [
        // campi base
        'creata_il',
        'direzione',
        'tipologia',

        'aree',
        'sintesi',
        'operatore',
        'priorita',
        'evento_id',

        // coordinamento
        'status',
        'assigned_to',
        'instructions',
        'last_note_text',
        'last_note_by',
        'last_note_at',

        // comunicazione
        'tipo',
        'ente',
        'mitt_dest',
        'telefono',
        'email',
        'indirizzo',
        'provincia',
        'comune',
        'oggetto',
        'contenuto',
        'campi_specifici',

        // coordinate
        'lat',
        'lng',
    ];

    protected $casts = [
        'aree'            => 'array',
        'campi_specifici' => 'array',
        'creata_il'       => 'datetime',
        'last_note_at'    => 'datetime',
        'lat'             => 'float',
        'lng'             => 'float',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }
}
