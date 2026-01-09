<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use App\Models\Department;
use Illuminate\Validation\Rule;

class Form extends Component
{
    public ?int $userId = null;

    public string $first_name = '';
    public ?string $middle_initial = null;
    public string $last_name = '';
    public string $email = '';
    public string $password;
    public ?string $role = 'User';
    public ?int $department_id = null;
    public bool $has_multi_department_coverage = false;
    public array $covered_department_ids = [];

    public function mount($id = null): void
    {
        if ($id) {
            $this->userId = (int) $id;
            $this->loadUser();
        }
    }

    public function loadUser(): void
    {
        $user = User::with('coveredDepartments')->findOrFail($this->userId);
        $this->has_multi_department_coverage = $user->coveredDepartments()->exists();

        $this->first_name = $user->first_name;
        $this->middle_initial = $user->middle_initial;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->role = $user->role?->value;
        $this->department_id = $user->department_id;

        $this->covered_department_ids = $user->coveredDepartments->pluck('id')->all();
    }

    protected function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'max:255',
            ],

            'middle_initial' => [
                'string',
                'max:255',
                'nullable',
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->userId),
            ],
            'role' => ['string', Rule::in(['User', 'Reporting User', 'Technician', 'Controller', 'Administrator'])],
            'department_id' => ['nullable', 'integer', Rule::exists('departments', 'id')],

            // pivot selection
            'covered_department_ids' => ['array'],
            'covered_department_ids.*' => ['integer', Rule::exists('departments', 'id')],
        ];
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function submitForm()
    {
        $validated = $this->validate();

        if (empty($validated['password'])) {
            unset($validated['password']); // keep existing password
        }

        $user = $this->userId
            ? User::findOrFail($this->userId)
            : new User();

        $user->fill($validated);
        $user->save();

        // Only Controllers get coverage departments; otherwise clear pivot
        if (($validated['role'] ?? null) === 'Controller') {
            $user->coveredDepartments()->sync($validated['covered_department_ids'] ?? []);
        } else {
            $user->coveredDepartments()->sync([]);
        }

        session()->flash(
            'create-edit-delete-message',
            $this->userId ? 'User updated!' : 'User created!'
        );

        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('admin.users.livewire.form', [
            'departments' => Department::orderBy('name')->get(),
        ]);
    }
}
