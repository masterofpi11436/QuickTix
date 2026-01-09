<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_template_id',
        'title',
        'description',
        'notes',
        'submitted_by_user_id',
        'technician',
        'assigned_by',
        'department',
        'area',
        'status',
        'assigned',
        'completed',
    ];

    protected $casts = [
        'assigned'   => 'datetime',
        'completed'  => 'datetime',
    ];

    public function ticketTemplate()
    {
        return $this->belongsTo(TicketTemplate::class);
    }

    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by_user_id');
    }
}
