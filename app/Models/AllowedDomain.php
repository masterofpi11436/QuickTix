<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllowedDomain extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = strtolower(trim($value));
    }
}
