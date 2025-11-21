<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CocActivation extends Model
{
    use HasFactory;

    protected $table = 'coc_activations';

    protected $fillable = [
        'codistat',
        'categoria',
        'opened_at',
        'closed_at',
        'lat',
        'lon',
        'note',
        'created_by',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
