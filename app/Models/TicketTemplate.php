<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketTemplate extends Model
{
    protected $fillable = [
        'title',
        'description',
        'area_id',
        'department_id',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
