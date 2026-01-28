<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Models\User;

class ControllerUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Controller.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Controller.users.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('Controller.users.edit', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('controller.users.index')
            ->with('success', 'User deleted!');
    }
}
