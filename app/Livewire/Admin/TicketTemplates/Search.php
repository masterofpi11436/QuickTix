<?php

namespace App\Livewire\Admin\TicketTemplates;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TicketTemplate;

class Search extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingQ(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $templates = TicketTemplate::query()
            ->with(['area', 'department'])
            ->when(trim($this->search) !== '', function ($q) {
                $term = '%' . trim($this->search) . '%';
                $q->where(function ($qq) use ($term) {
                    $qq->where('title', 'like', $term)
                       ->orWhere('description', 'like', $term);
                });
            })
            ->orderByDesc('id')
            ->paginate(15);

        return view('admin.tickettemplates.livewire.search', [
            'templates' => $templates,
        ]);
    }
}
