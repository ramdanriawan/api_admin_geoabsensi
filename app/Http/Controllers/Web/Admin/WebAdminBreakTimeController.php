<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\BreakTime;
use Illuminate\Http\Request;

class WebAdminBreakTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view('web.admin.breakTime.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.breakTime.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        return redirect()->route('web.admin.breakTime.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(BreakTime $breakTime)
    {
        //

        return view('web.admin.breakTime.show', compact('breakTime'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BreakTime $breakTime)
    {
        //

        return view('web.admin.breakTime.edit', compact('breakTime'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BreakTime $breakTime)
    {
        //

        return redirect()->route('web.admin.breakTime.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BreakTime $breakTime)
    {
        //
    }
}
