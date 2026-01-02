<?php

namespace App\Livewire\Admin\Areas;

use Livewire\Component;
use App\Models\Area;
use Illuminate\Validation\Rule;

class Form extends Component
{
    public ?int $areaId = null;

    public string $name = '';
    public ?string $description = null;

    public function mount($id = null): void
    {
        if ($id) {
            $this->areaId = (int) $id;
            $this->loadArea();
        }
    }

    public function loadArea(): void
    {
        $area = Area::findOrFail($this->areaId);

        $this->name = $area->name;
        $this->description = $area->description;
    }

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('areas', 'name')->ignore($this->areaId),
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

        $area = $this->areaId
            ? Area::findOrFail($this->areaId)
            : new Area();

        $area->fill($validated);
        $area->save();

        session()->flash(
            'create-edit-delete-message',
            $this->areaId ? 'Area updated!' : 'Area created!'
        );

        return redirect()->route('admin.areas.index');
    }

    public function render()
    {
        return view('admin.areas.livewire.form');
    }
}
