<?php

namespace App\Models\Segnalazioni;

use Illuminate\Database\Eloquent\Model;

class TblStatiSaleOperative extends Model
{
    protected $table = 'segnalazioni.tbl_stati_sale_operative';
    protected $primaryKey = 'id_stati_sale_operative';
    public $timestamps = false;

    protected $fillable = ['descrizione'];
}
