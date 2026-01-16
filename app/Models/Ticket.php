<?php

namespace App\Models;

use App\Enums\StatusType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_template_id',
        'title',
        'description',
        'notes',

        'submitted_by_user_id',
        'submitted_by_name',

        'assigned_to_user_id',
        'assigned_to_name',

        'assigned_by_user_id',
        'assigned_by_name',

        'department',
        'area',

        'status_type',

        'assigned_at',
        'completed_at',
    ];

    protected $casts = [
        'status_type'  => StatusType::class,
        'assigned_at'  => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function ticketTemplate(): BelongsTo
    {
        return $this->belongsTo(TicketTemplate::class);
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by_user_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by_user_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
