<?php

namespace App\Models\Segnalazioni;

use Illuminate\Database\Eloquent\Model;

class StatoSalaOperativa extends Model
{
    protected $table = 'segnalazioni.stato_sala_operativa';
    protected $primaryKey = 'id_segnalazione_stato_sala_op';
    public $timestamps = false;

    protected $fillable = [
        'segnalazione',
        'stato_sala_op',
        'data_ora',
        'nota_stato_sala_op',
        'codistat',
        'data_ora_reg',
    ];

    public function stato()
    {
        return $this->belongsTo(TblStatiSaleOperative::class, 'stato_sala_op', 'id_stati_sale_operative');
    }
}
