<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'slug',
        'label',
        'can_assign',
        'can_close',
    ];

    protected $casts = [
        'can_assign' => 'boolean',
        'can_close'  => 'boolean',
    ];
}
