<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TicketTemplate;

class ControllerTicketTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = TicketTemplate::with(['area', 'department'])
            ->orderBy('title')
            ->paginate(15);

        return view('controller.tickettemplates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('controller.tickettemplates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketTemplate $tickettemplate)
    {
        return view('controller.tickettemplates.edit', ['template' => $tickettemplate]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketTemplate $tickettemplate)
    {
        $tickettemplate->delete();

        return redirect()
            ->route('controller.tickettemplates.index')
            ->with('success', 'Template deleted!');
    }

}
