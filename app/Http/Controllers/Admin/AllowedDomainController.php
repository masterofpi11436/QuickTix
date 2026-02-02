<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AllowedDomain;

class AllowedDomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.allowed-domains.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.allowed-domains.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AllowedDomain $allowedDomain)
    {
        return view('admin.allowed-domains.edit', compact('allowedDomain'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AllowedDomain $allowedDomain)
    {
        $allowedDomain->delete();

        return redirect()
            ->route('admin.allowed-domains.index')
            ->with('success', 'Allowed domain deleted!');
    }
}
