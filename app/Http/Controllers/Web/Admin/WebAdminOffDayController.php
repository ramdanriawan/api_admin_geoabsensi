<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\OffDay;
use Illuminate\Http\Request;

class WebAdminOffDayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view('web.admin.offDay.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.offDay.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        return redirect()->route('web.admin.offDay.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(OffDay $offDay)
    {
        //

        return view('web.admin.offDay.show', compact('offDay'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OffDay $offDay)
    {
        //

        return view('web.admin.offDay.edit', compact('offDay'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OffDay $offDay)
    {
        //

        return redirect()->route('web.admin.offDay.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OffDay $offDay)
    {
        //
    }
}
