<?php

namespace App\Livewire\Controller\Users;

use App\Models\User;
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
        $query = User::query()->with(['department', 'coveredDepartments']);

        if ($this->search) {
            $s = '%' . $this->search . '%';

            $query->where(function ($q) use ($s) {
                $q->where('first_name', 'like', $s)
                  ->orWhere('last_name', 'like', $s)
                  ->orWhere('email', 'like', $s)
                  ->orWhere('role', 'like', $s)
                  ->orWhereHas('department', function ($dq) use ($s) {
                      $dq->where('name', 'like', $s);
                  })
                  ->orWhereHas('coveredDepartments', function ($dq) use ($s) {
                      $dq->where('name', 'like', $s);
                  });
            });
        }

        $users = $query
            ->orderBy('last_name', 'asc')
            ->paginate(15);

        return view('controller.users.livewire.search', [
            'users' => $users,
        ]);
    }
}
