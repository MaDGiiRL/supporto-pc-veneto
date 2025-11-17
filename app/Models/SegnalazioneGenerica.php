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
        // campi base
        'creata_il',
        'direzione',     // E / U
        'tipologia',     // sismico, idraulico, ...

        'aree',
        'sintesi',
        'operatore',
        'priorita',      // Nessuna, Alta, Media, Bassa
        'evento_id',

        // campi di COORDINAMENTO (già esistenti)
        'status',
        'assigned_to',
        'instructions',
        'last_note_text',
        'last_note_by',
        'last_note_at',

        // campi “comunicazione” aggiunti con la tua migration
        'tipo',          // es: FAX, Email, Telefono, PEC…
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
    ];

    protected $casts = [
        'aree'            => 'array',
        'campi_specifici' => 'array',
        'creata_il'       => 'datetime',
        'last_note_at'    => 'datetime',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }
}
