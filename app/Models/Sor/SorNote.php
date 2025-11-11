<?php

namespace App\Models\Sor;

use Illuminate\Database\Eloquent\Model;

class SorNote extends Model
{
    protected $table = 'sor.sor_notes';
    public $timestamps = false;
    protected $fillable = [
        'segnalazione_id',
        'text',
        'created_by',
        'created_by_id',
        'created_at',
        'updated_at'
    ];
}
