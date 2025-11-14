<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'name',
        'color',
        'is_completed',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
    ];
}
