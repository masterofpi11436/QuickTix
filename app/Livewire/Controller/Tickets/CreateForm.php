<?php

namespace App\Livewire\Controller\Tickets;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\TicketTemplate;
use App\Models\Department;
use App\Models\Area;
use App\Enums\StatusType;
use Illuminate\Support\Facades\Auth;

class CreateForm extends Component
{
    public ?int $ticket_template_id = null;

    public string $title = '';
    public string $description = '';
    public string $department = '';

    public string $area_search = '';
    public string $area = '';
    public bool $show_area_dropdown = false;

    public function updated($property, $value): void
    {
        if ($property !== 'ticket_template_id') {
            return;
        }

        if (blank($value)) {
            $this->title = '';
            $this->description = '';
            $this->department = '';
            $this->area = '';
            $this->area_search = '';
            $this->show_area_dropdown = false;
            return;
        }

        $template = TicketTemplate::with(['department', 'area'])->find((int) $value);

        if (! $template) {
            return;
        }

        $this->title = $template->title ?? '';
        $this->description = $template->description ?? '';
        $this->department = $template->department?->name ?? '';

        $this->area = $template->area?->name ?? '';
        $this->area_search = $this->area;

        $this->show_area_dropdown = false;
        $this->resetErrorBag(['title', 'description', 'department', 'area']);
    }

    protected function rules(): array
    {
        return [
            'ticket_template_id' => ['nullable', 'integer', 'exists:ticket_templates,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'department' => ['required', 'string', 'max:255'],
            'area' => ['required', 'string', 'max:255'],
            'area_search' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function updatedAreaSearch(): void
    {
        $this->show_area_dropdown = true;

        $this->area = trim($this->area_search);
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

        Ticket::create([
            'ticket_template_id' => $validated['ticket_template_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'notes' => null,

            'submitted_by_user_id' => $user?->id,
            'submitted_by_name' => trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: ($user->email ?? 'Unknown'),

            'assigned_to_user_id' => null,
            'assigned_to_name' => null,

            'assigned_by_user_id' => null,
            'assigned_by_name' => null,

            'department' => $validated['department'],
            'area' => $validated['area'],

            'status_type' => StatusType::New, // always new on create

            'assigned_at' => null,
            'completed_at' => null,
        ]);

        session()->flash('success', 'Ticket created.');
        return redirect()->route('controller.tickets.index');
    }

    public function render()
    {
        $areas = collect();

        if (mb_strlen(trim($this->area_search)) >= 2) {
            $term = '%' . trim($this->area_search) . '%';

            $areas = Area::query()
                ->where('name', 'like', $term)
                ->orderBy('name')
                ->limit(50)
                ->get();
        }

        return view('controller.tickets.livewire.create-ticket', [
            'templates' => TicketTemplate::query()->orderBy('id', 'desc')->get(),
            'departments' => Department::query()->orderBy('name')->get(),
            'areas' => $areas,
        ]);
    }
}
