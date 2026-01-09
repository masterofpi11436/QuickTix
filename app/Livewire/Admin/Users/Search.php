<?php

namespace App\Livewire\Admin\Users;

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
        $query = User::query()->with('department');

        if ($this->search) {
            $s = '%' . $this->search . '%';

            $query->where(function ($q) use ($s) {
                $q->where('first_name', 'like', $s)
                    ->orWhere('last_name', 'like', $s)
                    ->orWhere('email', 'like', $s)
                    ->orWhere('role', 'like', $s);
            });
        }

        $users = $query
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.users.livewire.search', [
            'users' => $users,
        ]);
    }
}
