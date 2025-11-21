<?php

namespace App\Models\Segnalazioni;

use Illuminate\Database\Eloquent\Model;

class CoremRischio extends Model
{
    protected $table = 'segnalazioni.corem_rischio';
    protected $primaryKey = 'id'; // adattalo se è diverso
    public $timestamps = false;

    protected $fillable = [
        'id_rischio',
        'id_segnalazione_stato_sala_op',
        'data_inizio',
        'data_fine',
        'note_rischio',
    ];
}
