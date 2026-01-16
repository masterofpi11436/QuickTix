<?php

namespace App\Livewire\Admin\Statuses;

use App\Models\Status;
use Livewire\Component;
use App\Enums\StatusType;
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
                $raw = strtolower(trim($this->search));
                $like = '%' . $raw . '%';

                // Try to resolve the search term to a StatusType
                $statusType = match ($raw) {
                    'new' => StatusType::New,
                    'in progress', 'in_progress', 'progress' => StatusType::InProgress,
                    'completed', 'complete', 'done' => StatusType::Completed,
                    default => null,
                };

                $query->where(function ($q) use ($like, $statusType) {
                    $q->where('name', 'like', $like);

                    if ($statusType) {
                        $q->orWhere('status_type', $statusType->value);
                    }
                });
            }

            return view('admin.statuses.livewire.search', [
                'statuses' => $query
                    ->orderBy('created_at', 'desc')
                    ->paginate(15),
            ]);
    }
}
