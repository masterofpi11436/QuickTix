<?php

namespace App\Livewire\Admin\AllowedDomains;

use App\Models\AllowedDomain;
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

    public function toggleActive(int $id): void
    {
        $domain = AllowedDomain::findOrFail($id);
        $domain->is_active = ! $domain->is_active;
        $domain->save();
    }

    public function render()
    {
        $query = AllowedDomain::query();

        if ($this->search) {
            $s = '%' . $this->search . '%';

            $query->where('name', 'like', $s);
        }

        $allowedDomains = $query
            ->orderBy('name', 'asc')
            ->paginate(15);

        return view('admin.allowed-domains.livewire.search', [
            'allowedDomains' => $allowedDomains,
        ]);
    }
}
