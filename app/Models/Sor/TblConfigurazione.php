<?php

namespace App\Models\Segnalazioni;

use Illuminate\Database\Eloquent\Model;

class TblConfigurazione extends Model
{
    protected $table = 'segnalazioni.tbl_configurazione';
    protected $primaryKey = 'id_configurazione';
    public $timestamps = false;

    protected $fillable = [
        'sigla',
        'configurazione',
    ];
}
