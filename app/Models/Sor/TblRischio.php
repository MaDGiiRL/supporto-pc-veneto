<?php

namespace App\Models\Segnalazioni;

use Illuminate\Database\Eloquent\Model;

class TblRischio extends Model
{
    protected $table = 'segnalazioni.tbl_rischio';
    protected $primaryKey = 'id_rischio';
    public $timestamps = false;

    protected $fillable = ['rischio'];
}
