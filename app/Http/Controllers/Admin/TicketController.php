<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Status;
use App\Models\Ticket;
use App\Enums\UserRole;
use App\Enums\StatusType;
use Illuminate\Http\Request;
use App\Models\StatusTypeDefault;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $openTickets = Ticket::with(['submittedBy'])
            ->whereIn('status_type', ['new', 'in_progress'])
            ->latest()
            ->limit(10)
            ->get();

        $completedTickets = Ticket::with(['submittedBy'])
            ->where('status_type', 'completed')
            ->latest('completed_at')
            ->limit(10)
            ->get();

        $ticketsByType = collect()
            ->merge($openTickets)
            ->merge($completedTickets)
            ->groupBy('status_type');

        return view('admin.tickets.index', compact('ticketsByType'));
    }

    public function completedTickets()
    {
        $completedTickets = Ticket::query()
            ->where('status_type', StatusType::Completed)
            ->with('submittedBy')
            ->latest('completed_at')
            ->paginate(10);

        return view('admin.tickets.all-tickets', compact('completedTickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tickets.create-ticket');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load('submittedBy');

        $assignees = User::query()
            ->whereIn('role', [
                UserRole::Administrator->value,
                UserRole::Controller->value,
                UserRole::Technician->value,
            ])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get(['id', 'first_name', 'last_name', 'role']);

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

            $departments = Department::query()
                ->select(['name'])
                ->orderBy('name')
                ->get();

        return view('admin.tickets.show', compact('ticket', 'assignees', 'completedStatuses', 'statusLabels', 'pendingStatus', 'departments'));
    }

    public function updateDepartment(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'department' => ['required', 'string', 'max:255'],
        ]);

        $ticket->department = $data['department'];
        $ticket->save();

        return back()->with('success', 'Department updated.');
    }

    public function updateStatusTypeDefault(Request $request, string $statusType)
    {
        $data = $request->validate([
            'status_id' => ['required', 'integer', 'exists:statuses,id'],
        ]);

        // enforce that the selected status matches the statusType we’re updating
        Status::query()
            ->whereKey($data['status_id'])
            ->where('status_type', $statusType)
            ->firstOrFail();

        StatusTypeDefault::query()
            ->where('status_type', $statusType)
            ->update(['status_id' => $data['status_id']]);

        return back()->with('success', 'Status Updated.');
    }

    public function assign(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'assigned_to' => ['required', 'integer', 'exists:users,id'],
            'technical_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $assignee = User::findOrFail($data['assigned_to']);

        $allowedRoles = [
            UserRole::Technician->value,
            UserRole::Controller->value,
            UserRole::Administrator->value,
        ];

        $assigneeRoleValue = $assignee->role instanceof UserRole ? $assignee->role->value : (string) $assignee->role;

        if (! in_array($assigneeRoleValue, $allowedRoles, true)) {
            abort(403);
        }

        $assignedByUser = Auth::user();

        if (array_key_exists('technical_notes', $data)) {
            $ticket->technical_notes = $data['technical_notes']; // allow clearing by submitting empty string
        }

        $ticket->assigned_to_user_id = $assignee->id;
        $ticket->assigned_to_name = trim($assignee->first_name . ' ' . $assignee->last_name);

        $ticket->assigned_by_user_id = $assignedByUser?->id;
        $ticket->assigned_by_name = $assignedByUser
            ? trim($assignedByUser->first_name . ' ' . $assignedByUser->last_name)
            : null;

        $ticket->assigned_at = now();

        if ($ticket->status_type === StatusType::New || empty($ticket->status_type)) {
            $ticket->status_type = StatusType::InProgress;
        }

        $ticket->save();

        return redirect()
            ->route('admin.tickets.index', $ticket)
            ->with('success', 'Ticket assigned.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'completed_status_id' => ['required', 'integer', 'exists:statuses,id'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        // Ensure chosen status is a "completed" jargon option
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
            ->route('admin.tickets.index', $ticket)
            ->with('success', 'Ticket completed.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()
            ->route('admin.tickets.index')
            ->with('success', 'Ticket deleted.');
    }
}
