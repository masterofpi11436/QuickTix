<?php

namespace App\Livewire\Admin\Tickets;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\TicketTemplate;
use App\Models\Department;
use App\Models\Area;
use App\Models\Status;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public ?int $ticket_template_id = null;

    public string $title = '';
    public string $description = '';

    // Stored as strings (name columns)
    public string $department = '';
    public string $area = '';
    public string $status = '';

    protected function rules(): array
    {
        return [
            'ticket_template_id' => ['nullable', 'integer', 'exists:ticket_templates,id'],

            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],

            'department' => ['required', 'string', 'max:255'],
            'area' => ['required', 'string', 'max:255'],

            // status stored as string, but must exist in statuses table
            'status' => ['required', 'string', 'max:255', 'exists:statuses,name'],
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        $user = Auth::user();
        if (! $user) {
            abort(403);
        }

        if (! Department::where('name', $validated['department'])->exists()) {
            $this->addError('department', 'Selected department is invalid.');
            return;
        }

        if (! Area::where('name', $validated['area'])->exists()) {
            $this->addError('area', 'Selected area is invalid.');
            return;
        }

        $validated['submitted_by'] = $user->name ?? $user->email ?? (string) $user->id;

        $ticket = Ticket::create($validated);

        session()->flash('success', 'Ticket created.');

        return redirect()->route('admin.tickets.show', $ticket);
    }

    public function render()
    {
        $statuses = Status::query()->orderBy('name')->get();

        return view('admin.tickets.livewire.create-ticket', [
            'templates' => TicketTemplate::query()->orderBy('id', 'desc')->get(),
            'departments' => Department::query()->orderBy('name')->get(),
            'areas' => Area::query()->orderBy('name')->get(),
            'statuses' => $statuses,
        ]);
    }
}
