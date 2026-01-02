<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.areas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.areas.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        return view('admin.areas.edit', compact('area'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        $area->delete();

        return redirect()
            ->route('admin.areas.index')
            ->with('create-edit-delete-message', 'Area deleted!');
    }
}
