<?php

namespace App\Livewire\Admin\Statuses;

use App\Models\Status;
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
        $query = Status::query();

        if ($this->search) {
            $s = '%' . $this->search . '%';

            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', $s)
                    ->orWhere('status_type', 'like', $s);
            });
        }

        $statuses = $query
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.statuses.livewire.search', [
            'statuses' => $statuses,
        ]);
    }
}
