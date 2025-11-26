<?php

namespace App\Models\Coc;

use Illuminate\Database\Eloquent\Model;

class CocStato extends Model
{
    protected $table = 'coc.coc_stati';

    protected $fillable = [
        'codistat',
        'stato_coc',
        'fase_operativa',
        'nota_stato',
        'nota_fase',
        'data_ora',
    ];

    protected function casts(): array
    {
        return [
            'data_ora' => 'datetime',
        ];
    }
}
