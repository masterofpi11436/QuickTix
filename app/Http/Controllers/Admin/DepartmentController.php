<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.departments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.departments.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()
            ->route('admin.departments.index')
            ->with('create-edit-delete-message', 'Department deleted!');
    }
}
