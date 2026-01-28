<?php

namespace App\Livewire\Controller\TicketTemplates;

use Livewire\Component;
use App\Models\Area;
use App\Models\Department;
use App\Models\TicketTemplate;
use Illuminate\Validation\Rule;

class Form extends Component
{
    public ?int $templateId = null;

    public string $title = '';
    public string $description = '';
    public ?int $area_id = null;
    public ?int $department_id = null;

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->templateId = $id;
            $this->loadTemplate();
        }
    }

    private function loadTemplate(): void
    {
        $t = TicketTemplate::findOrFail($this->templateId);

        $this->title = $t->title;
        $this->description = $t->description;
        $this->area_id = $t->area_id;
        $this->department_id = $t->department_id;
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'area_id' => ['nullable', 'integer', Rule::exists('areas', 'id')],
            'department_id' => ['nullable', 'integer', Rule::exists('departments', 'id')],
        ];
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $validated = $this->validate();

        $template = $this->templateId
            ? TicketTemplate::findOrFail($this->templateId)
            : new TicketTemplate();

        $template->fill($validated);
        $template->save();

        session()->flash('success', $this->templateId ? 'Template updated.' : 'Template created.');

        return redirect()->route('controller.tickettemplates.index');
    }

    public function render()
    {
        return view('controller.tickettemplates.livewire.form', [
            'areas' => Area::query()->orderBy('name')->get(),
            'departments' => Department::query()->orderBy('name')->get(),
        ]);
    }
}
