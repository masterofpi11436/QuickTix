<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Ticket;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with('submittedBy')->paginate(15);

        return view('admin.tickets.index', compact('tickets'));
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

        return view('admin.tickets.show', compact('ticket', 'assignees'));
    }

    public function assign(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'assigned_to' => ['required', 'exists:users,id'],
        ]);

        $assignee = User::findOrFail($data['assigned_to']);

        if (! in_array($assignee->role, [
            UserRole::Technician,
            UserRole::Controller,
            UserRole::Administrator,
        ], true)) {
            abort(403);
        }

        $assignedByUser = Auth::user();

        $ticket->technician  = trim($assignee->first_name . ' ' . $assignee->last_name);
        $ticket->assigned_by = trim($assignedByUser->first_name . ' ' . $assignedByUser->last_name);
        $ticket->assigned    = now();

        if ($ticket->status === 'New' || empty($ticket->status)) {
            $ticket->status = 'In Progress';
        }

        $ticket->save();

        return redirect()
            ->route('admin.tickets.index', $ticket)
            ->with('success', 'Ticket assigned.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
