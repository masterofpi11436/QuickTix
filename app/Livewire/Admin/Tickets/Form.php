<?php

namespace App\Livewire\Admin\Tickets;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\TicketTemplate;
use App\Models\Department;
use App\Models\Area;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public ?int $ticket_template_id = null;

    // User input
    public string $title = '';
    public string $description = '';
    public string $department = '';
    public string $area = '';

    // Default system value (not user input)
    public string $status = 'New';

    protected function rules(): array
    {
        return [
            'ticket_template_id' => ['nullable', 'integer', 'exists:ticket_templates,id'],

            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],

            'department' => ['required', 'string', 'max:255'],
            'area' => ['required', 'string', 'max:255'],

            // Ensure default is valid
            'status' => ['required', 'string', 'max:255', 'exists:statuses,name'],
        ];
    }

    public function mount(): void
    {
        // In case you want to guarantee it always starts as New
        $this->status = 'New';
    }

    public function save()
    {
        $validated = $this->validate();

        $user = Auth::user();

        // Optional: enforce department/area exist by name
        if (! Department::where('name', $validated['department'])->exists()) {
            $this->addError('department', 'Selected department is invalid.');
            return;
        }
        if (! Area::where('name', $validated['area'])->exists()) {
            $this->addError('area', 'Selected area is invalid.');
            return;
        }

        Ticket::create([
            'ticket_template_id' => null,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'department' => $validated['department'],
            'area' => $validated['area'],
            'status' => $validated['status'],
            'submitted_by_user_id' => $user->id,

            // all these null by requirement
            'notes' => null,
            'technician' => null,
            'assigned_by' => null,
            'assigned' => null,
            'completed' => null,
        ]);

        session()->flash('success', 'Ticket created.');

        return redirect()->route('admin.tickets.index');
    }

    public function render()
    {
        return view('admin.tickets.livewire.create-ticket', [
            'templates' => TicketTemplate::query()->orderBy('id', 'desc')->get(),
            'departments' => Department::query()->orderBy('name')->get(),
            'areas' => Area::query()->orderBy('name')->get(),
            'statuses' => Status::query()->orderBy('name')->get(),
        ]);
    }
}
