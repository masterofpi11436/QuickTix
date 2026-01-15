<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Status;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.statuses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.statuses.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        return view('admin.statuses.edit', compact('status'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        $count = Status::where('status_type', $status->status_type)->count();

        if ($count <= 1) {
            return redirect()
                ->route('admin.statuses.index')
                ->with('error', 'You must keep at least one status for each type.');
        }

        $status->delete();

        return redirect()
            ->route('admin.statuses.index')
            ->with('success', 'Status deleted!');
    }
}
