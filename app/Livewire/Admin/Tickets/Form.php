<?php

namespace App\Livewire\Admin\Tickets;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\TicketTemplate;
use Illuminate\Support\Carbon;

class Form extends Component
{
    // Form fields
    public ?int $ticket_template_id = null;

    public string $title = '';
    public string $description = '';
    public string $notes = '';
    public string $submitted_by = '';

    public ?string $technician = null;
    public ?string $assigned_by = null;

    public string $department = '';
    public string $area = '';

    public string $status = 'open';

    // If you want user to pick opened time, keep it; otherwise we default on save.
    public ?string $opened = null;     // datetime-local string
    public ?string $assigned = null;   // datetime-local string
    public ?string $completed = null;  // datetime-local string

    public function mount(): void
    {
        // Default opened to "now" for convenience (HTML datetime-local format)
        $this->opened = now()->format('Y-m-d\TH:i');
    }

    protected function rules(): array
    {
        return [
            'ticket_template_id' => ['nullable', 'integer', 'exists:ticket_templates,id'],

            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'notes' => ['required', 'string'],
            'submitted_by' => ['required', 'string', 'max:255'],

            'technician' => ['nullable', 'string', 'max:255'],
            'assigned_by' => ['nullable', 'string', 'max:255'],

            'department' => ['required', 'string', 'max:255'],
            'area' => ['required', 'string', 'max:255'],

            'status' => ['required', 'string', 'max:255'],

            // Accept datetime-local strings; we convert to Carbon on save.
            'opened' => ['required', 'date'],
            'assigned' => ['nullable', 'date'],
            'completed' => ['nullable', 'date'],
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        // Convert datetime-local strings to timestamps
        $validated['opened'] = Carbon::parse($validated['opened']);
        $validated['assigned'] = $validated['assigned'] ? Carbon::parse($validated['assigned']) : null;
        $validated['completed'] = $validated['completed'] ? Carbon::parse($validated['completed']) : null;

        $ticket = Ticket::create($validated);

        session()->flash('success', 'Ticket created.');

        // Redirect wherever you want
        return redirect()->route('tickets.show', $ticket);
        // Or: return redirect()->route('tickets.index');
    }

    public function render()
    {
        return view('admin.tickets.livewire.create-ticket', [
            'templates' => TicketTemplate::query()->orderBy('id', 'desc')->get(),
        ]);
    }
}
