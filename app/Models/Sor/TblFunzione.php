<?php

namespace App\Models\Segnalazioni;

use Illuminate\Database\Eloquent\Model;

class TblFunzione extends Model
{
    protected $table = 'segnalazioni.tbl_funzioni';
    protected $primaryKey = 'id_funzione';
    public $timestamps = false;

    protected $fillable = [
        'sigla',
        'funzione',
    ];
}
