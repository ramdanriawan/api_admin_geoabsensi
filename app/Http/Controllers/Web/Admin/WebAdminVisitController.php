<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use App\Services\ServiceImpl\VisitServiceImpl;
use Illuminate\Http\Request;

class WebAdminVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view('web.admin.visit.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.visit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        return redirect()->route('web.admin.visit.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Visit $visit)
    {
        //
        $visit = VisitServiceImpl::addAllAttributes($visit);

        return view('web.admin.visit.show', compact('visit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visit $visit)
    {
        //

        return view('web.admin.visit.edit', compact('visit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visit $visit)
    {
        //

        return redirect()->route('web.admin.visit.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $visit)
    {
        //
    }
}
