<?php

namespace App\Http\Controllers\Auth;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
     /**
     * Display a listing of the statuses.
     */
    public function index()
    {
        $statuses = Status::orderBy('name')->get();

        return view('admin.statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new status.
     */
    public function create()
    {
        return view('admin.statuses.create');
    }

    /**
     * Store a newly created status in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255', 'unique:statuses,name'],
            'color'       => ['nullable', 'string', 'max:20'],
            'is_default'  => ['boolean'],
        ]);

        // If a default status is chosen, unset default for others
        if (!empty($validated['is_default']) && $validated['is_default']) {
            Status::where('is_default', true)->update(['is_default' => false]);
        }

        Status::create($validated);

        return redirect()->route('admin.statuses.index')
            ->with('success', 'Status created successfully.');
    }

    /**
     * Show the form for editing the specified status.
     */
    public function edit(Status $status)
    {
        return view('admin.statuses.edit', compact('status'));
    }

    /**
     * Update the specified status.
     */
    public function update(Request $request, Status $status)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255', 'unique:statuses,name,' . $status->id],
            'color'       => ['nullable', 'string', 'max:20'],
            'is_default'  => ['boolean'],
        ]);

        // Ensure only one default status exists
        if (!empty($validated['is_default']) && $validated['is_default']) {
            Status::where('is_default', true)->where('id', '!=', $status->id)
                ->update(['is_default' => false]);
        }

        $status->update($validated);

        return redirect()->route('admin.statuses.index')
            ->with('success', 'Status updated successfully.');
    }

    /**
     * Remove the specified status from storage.
     */
    public function destroy(Status $status)
    {
        // Optional: prevent deleting a default status
        if ($status->is_default) {
            return redirect()->route('admin.statuses.index')
                ->with('error', 'You cannot delete the default status.');
        }

        $status->delete();

        return redirect()->route('admin.statuses.index')
            ->with('success', 'Status deleted successfully.');
    }
}
