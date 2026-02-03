<?php

namespace App\Http\Controllers\Technician;

use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\StatusTypeDefault;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicianTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $ticketsQuery = Ticket::with(['submittedBy'])
            ->where('assigned_to_user_id', $user?->id);

        $openTickets = (clone $ticketsQuery)
            ->whereIn('status_type', [StatusType::New, StatusType::InProgress])
            ->latest()
            ->get();

        $completedTickets = (clone $ticketsQuery)
            ->where('status_type', StatusType::Completed)
            ->latest('completed_at')
            ->limit(10)
            ->get();

        $ticketsByType = collect()
            ->merge($openTickets)
            ->merge($completedTickets)
            ->groupBy('status_type');

        return view('technician.tickets.index', compact('ticketsByType'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $this->authorizeTicketVisibility($ticket);

        $ticket->load('submittedBy');

        $completedStatuses = Status::query()
            ->where('status_type', StatusType::Completed->value)
            ->orderBy('name')
            ->get(['id', 'name']);

        $statusLabels = StatusTypeDefault::with('status')
            ->get()
            ->mapWithKeys(fn ($row) => [$row->status_type => $row->status->name]);

        $pendingStatus = Status::query()
            ->select(['id', 'name', 'status_type'])
            ->orderBy('name')
            ->get()
            ->groupBy('status_type');

        return view('technician.tickets.show', compact('ticket', 'completedStatuses', 'statusLabels', 'pendingStatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('technician.tickets.create-ticket');
    }

    public function assign(Request $request, Ticket $ticket)
    {
        $this->authorizeTicketVisibility($ticket);

        $user = Auth::user();

        if ($ticket->assigned_to_user_id && $ticket->assigned_to_user_id !== $user?->id) {
            abort(403);
        }

        $data = $request->validate([
            'technical_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        if (array_key_exists('technical_notes', $data)) {
            $ticket->technical_notes = $data['technical_notes'];
        }

        $ticket->assigned_to_user_id = $user?->id;
        $ticket->assigned_to_name = $user ? trim($user->first_name . ' ' . $user->last_name) : null;

        $ticket->assigned_by_user_id = $user?->id;
        $ticket->assigned_by_name = $user ? trim($user->first_name . ' ' . $user->last_name) : null;

        $ticket->assigned_at = now();

        if ($ticket->status_type === StatusType::New || empty($ticket->status_type)) {
            $ticket->status_type = StatusType::InProgress;
        }

        $ticket->save();

        return redirect()
            ->route('technician.tickets.show', $ticket)
            ->with('success', 'Ticket assigned to you.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $this->authorizeTicketVisibility($ticket);

        $user = Auth::user();

        if ($ticket->assigned_to_user_id !== $user?->id) {
            abort(403);
        }

        $data = $request->validate([
            'completed_status_id' => ['required', 'integer', 'exists:statuses,id'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        Status::query()
            ->whereKey($data['completed_status_id'])
            ->where('status_type', StatusType::Completed->value)
            ->firstOrFail();

        $ticket->status_type = StatusType::Completed;
        $ticket->completed_at = now();

        if (array_key_exists('notes', $data)) {
            $ticket->notes = $data['notes'];
        }

        $ticket->save();

        return redirect()
            ->route('technician.tickets.index', $ticket)
            ->with('success', 'Ticket completed.');
    }

    public function updateStatusTypeDefault(Request $request, string $statusType)
    {
        $data = $request->validate([
            'status_id' => ['required', 'integer', 'exists:statuses,id'],
        ]);

        Status::query()
            ->whereKey($data['status_id'])
            ->where('status_type', $statusType)
            ->firstOrFail();

        StatusTypeDefault::query()
            ->where('status_type', $statusType)
            ->update(['status_id' => $data['status_id']]);

        return back()->with('success', 'Status Updated.');
    }

    protected function authorizeTicketVisibility(Ticket $ticket): void
    {
        $user = Auth::user();
        $departmentName = $user?->department?->name;

        if ($ticket->assigned_to_user_id === $user?->id) {
            return;
        }

        if ($departmentName && $ticket->department === $departmentName) {
            return;
        }

        abort(403);
    }
}
