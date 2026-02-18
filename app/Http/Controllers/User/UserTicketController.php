<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Status;
use App\Models\Ticket;
use App\Enums\UserRole;
use App\Enums\StatusType;
use Illuminate\Http\Request;
use App\Models\StatusTypeDefault;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        $newTickets = Ticket::with(['submittedBy'])
            ->where('status_type', 'new')
            ->latest()
            ->limit(10)
            ->get();

        $inProgress = Ticket::with(['submittedBy'])
            ->where('status_type', 'in_progress')
            ->latest()
            ->limit(10)
            ->get();

        $completedTickets = Ticket::with(['submittedBy'])
            ->where('status_type', 'completed')
            ->latest('completed_at')
            ->limit(10)
            ->get();

        $ticketsByType = collect()
            ->merge($newTickets)
            ->merge($inProgress)
            ->merge($completedTickets)
            ->groupBy('status_type');

        return view('user.dashboard', compact('ticketsByType'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.tickets.create-ticket');
    }
}
