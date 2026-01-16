<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatusTypeDefault extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'status_type';
    protected $keyType = 'string';

    protected $fillable = ['status_type', 'status_id'];

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
