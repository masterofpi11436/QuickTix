<?php

namespace App\Livewire\Admin\Departments;

use Livewire\Component;
use App\Models\Department;
use Illuminate\Validation\Rule;

class Form extends Component
{
    public ?int $departmentId = null;

    public string $name = '';
    public ?string $description = null;

    public function mount($id = null): void
    {
        if ($id) {
            $this->departmentId = (int) $id;
            $this->loadDepartment();
        }
    }

    public function loadDepartment(): void
    {
        $department = Department::findOrFail($this->departmentId);

        $this->name = $department->name;
        $this->description = $department->description;
    }

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('departments', 'name')->ignore($this->departmentId),
            ],
            'description' => ['nullable', 'string'],
        ];
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function submitForm()
    {
        $validated = $this->validate();

        $department = $this->departmentId
            ? Department::findOrFail($this->departmentId)
            : new Department();

        $department->fill($validated);
        $department->save();

        session()->flash(
            'create-edit-delete-message',
            $this->departmentId ? 'Department updated!' : 'Department created!'
        );

        return redirect()->route('admin.departments.index');
    }

    public function render()
    {
        return view('admin.departments.livewire.form');
    }
}
