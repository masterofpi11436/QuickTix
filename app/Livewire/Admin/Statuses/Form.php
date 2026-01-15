<?php

namespace App\Livewire\Admin\Statuses;

use Livewire\Component;
use App\Models\Status;
use Illuminate\Validation\Rule;

class Form extends Component
{
    public ?int $statusId = null;

    public string $name = '';
    public ?string $color = null;
    public ?string $status_type = 'default';

    public function mount($id = null): void
    {
        if ($id) {
            $this->statusId = (int) $id;
            $this->loadStatus();
        }
    }

    public function loadStatus(): void
    {
        $status = Status::findOrFail($this->statusId);

        $this->name = $status->name;
        $this->color = $status->color;
        $this->status_type = $status->status_type?->value;
    }

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('statuses', 'name')->ignore($this->statusId),
            ],
            'color' => ['nullable', 'string'],
            'status_type' => ['required', Rule::in(['default', 'in_progress', 'completed'])],
        ];
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function submitForm()
    {

        $this->name = trim(preg_replace('/\s+/', ' ', $this->name));

        $validated = $this->validate();

        $status = $this->statusId
            ? Status::findOrFail($this->statusId)
            : new Status();

        $status->fill($validated);
        $status->save();

        session()->flash(
            'success',
            $this->statusId ? 'Status updated!' : 'Status created!'
        );

        return redirect()->route('admin.statuses.index');
    }

    public function render()
    {
        return view('admin.statuses.livewire.form');
    }
}
