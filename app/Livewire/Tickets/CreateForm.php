<?php

namespace App\Livewire\Tickets;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\TicketTemplate;
use App\Models\Department;
use App\Models\Area;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class CreateForm extends Component
{
    public ?int $ticket_template_id = null;

    public string $title = '';
    public string $description = '';
    public string $department = '';

    // user types here
    public string $area_search = '';

    // what gets saved (keep as string name like your current schema)
    public string $area = '';

    // dropdown state
    public bool $show_area_dropdown = false;

    protected function rules(): array
    {
        return [
            'ticket_template_id' => ['nullable', 'integer', 'exists:ticket_templates,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],

            'department' => ['required', 'string', 'max:255'],
            'area' => ['required', 'string', 'max:255'],

            'status' => ['required', 'string', 'max:255', 'exists:statuses,name'],
        ];
    }

    public string $status = 'New';

    public function mount(): void
    {
        $this->status = 'New';
    }

    // When typing, clear the selected area if user edits text
    public function updatedAreaSearch($value): void
    {
        $this->show_area_dropdown = true;

        // If they type something different, make them re-pick a valid area
        if ($this->area !== $value) {
            $this->area = '';
        }
    }

    public function selectArea(string $name): void
    {
        $this->area = $name;
        $this->area_search = $name;
        $this->show_area_dropdown = false;
        $this->resetErrorBag('area');
    }

    public function closeAreaDropdown(): void
    {
        $this->show_area_dropdown = false;
    }

    public function save()
    {
        $validated = $this->validate();
        $user = Auth::user();

        if (! Department::where('name', $validated['department'])->exists()) {
            $this->addError('department', 'Selected department is invalid.');
            return;
        }

        // Enforce that the selected area is one that exists (by name)
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
        $areas = collect();

        // Only query when user has typed 1-2 chars (you choose)
        if (mb_strlen(trim($this->area_search)) >= 2) {
            $term = '%' . trim($this->area_search) . '%'; // Change with $term = trim($this->area_search) . '%'; if slow search results

            $areas = Area::query()
                ->where('name', 'like', $term)
                ->orderBy('name')
                ->limit(50)
                ->get();
        }

        return view('admin.tickets.livewire.create-ticket', [
            'templates' => TicketTemplate::query()->orderBy('id', 'desc')->get(),
            'departments' => Department::query()->orderBy('name')->get(),
            'areas' => $areas, // NOTE: this is now the filtered list
            'statuses' => Status::query()->orderBy('name')->get(),
        ]);
    }
}
