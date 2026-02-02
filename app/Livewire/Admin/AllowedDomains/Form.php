<?php

namespace App\Livewire\Admin\AllowedDomains;

use App\Models\AllowedDomain;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Form extends Component
{
    public ?int $allowedDomainId = null;

    public string $name = '';
    public bool $is_active = true;

    public function mount($id = null): void
    {
        if ($id) {
            $this->allowedDomainId = (int) $id;
            $this->loadAllowedDomain();
        }
    }

    public function loadAllowedDomain(): void
    {
        $allowedDomain = AllowedDomain::findOrFail($this->allowedDomainId);

        $this->name = $allowedDomain->name;
        $this->is_active = (bool) $allowedDomain->is_active;
    }

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('allowed_domains', 'name')->ignore($this->allowedDomainId),
            ],
            'is_active' => ['boolean'],
        ];
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function submitForm()
    {
        $validated = $this->validate();

        $allowedDomain = $this->allowedDomainId
            ? AllowedDomain::findOrFail($this->allowedDomainId)
            : new AllowedDomain();

        $allowedDomain->fill($validated);
        $allowedDomain->save();

        session()->flash(
            'success',
            $this->allowedDomainId ? 'Allowed domain updated!' : 'Allowed domain created!'
        );

        return redirect()->route('admin.allowed-domains.index');
    }

    public function render()
    {
        return view('admin.allowed-domains.livewire.form');
    }
}
