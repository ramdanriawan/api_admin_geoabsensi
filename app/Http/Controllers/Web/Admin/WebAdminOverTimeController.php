<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\OverTime;
use Illuminate\Http\Request;

class WebAdminOverTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view('web.admin.overTime.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.overTime.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        return redirect()->route('web.admin.overTime.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(OverTime $overTime)
    {
        //

        return view('web.admin.overTime.show', compact('overTime'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OverTime $overTime)
    {
        //

        return view('web.admin.overTime.edit', compact('overTime'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OverTime $overTime)
    {
        //

        return redirect()->route('web.admin.overTime.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OverTime $overTime)
    {
        //
    }
}
