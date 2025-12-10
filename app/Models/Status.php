<?php

namespace App\Models;

use App\Enums\StatusType;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'name',
        'color',
        'status_type',
    ];

    protected $casts = [
        'status_type' => StatusType::class,
    ];
}
