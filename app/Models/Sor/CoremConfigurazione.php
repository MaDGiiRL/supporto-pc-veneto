<?php

namespace App\Models\Segnalazioni;

use Illuminate\Database\Eloquent\Model;

class CoremConfigurazione extends Model
{
    protected $table = 'segnalazioni.corem_configurazione';
    protected $primaryKey = 'id'; // adattalo se serve
    public $timestamps = false;

    protected $fillable = [
        'id_configurazione',
        'id_segnalazione_stato_sala_op',
        'data_inizio',
        'data_fine',
    ];
}
