<?php

namespace App\Livewire\Admin\Areas;

use App\Models\Area;
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
        $query = Area::query();

        if ($this->search) {
            $s = '%' . $this->search . '%';

            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', $s)
                    ->orWhere('description', 'like', $s);
            });
        }

        $areas = $query
            ->orderBy('name', 'asc')
            ->paginate(15);

        return view('admin.areas.livewire.search', [
            'areas' => $areas,
        ]);
    }
}
