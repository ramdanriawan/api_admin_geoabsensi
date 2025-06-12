<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Services\ServiceImpl\TripServiceImpl;
use Illuminate\Http\Request;

class WebAdminTripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view('web.admin.trip.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.trip.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        return redirect()->route('web.admin.trip.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {
        //
        $trip = TripServiceImpl::addAllAttributes($trip);

        return view('web.admin.trip.show', compact('trip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trip $trip)
    {
        //

        return view('web.admin.trip.edit', compact('trip'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trip $trip)
    {
        //

        return redirect()->route('web.admin.trip.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        //
    }
}
