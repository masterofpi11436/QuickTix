<?php

namespace App\Livewire\Admin\Departments;

use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Department::query();

        if ($this->search) {
            $s = '%' . $this->search . '%';

            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', $s)
                    ->orWhere('description', 'like', $s);
            });
        }

        $departments = $query
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.departments.livewire.search', [
            'departments' => $departments,
        ]);
    }
}
