<?php

namespace App\Models\Segnalazioni;

use Illuminate\Database\Eloquent\Model;

class CoremFunzione extends Model
{
    protected $table = 'segnalazioni.corem_funzioni';
    protected $primaryKey = 'id'; // idem
    public $timestamps = false;

    protected $fillable = [
        'id_funzione',
        'id_segnalazione_stato_sala_op',
        'data_inizio',
        'data_fine',
    ];
}
