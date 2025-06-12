<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminTripTypeStoreRequest;
use App\Http\Requests\Web\Admin\WebAdminTripTypeUpdateRequest;
use App\Models\Dtos\TripTypeStoreDto;
use App\Models\Dtos\TripTypeUpdateDto;
use App\Models\Shift;
use App\Models\TripType;
use App\Services\ServiceImpl\ShiftServiceImpl;
use App\Services\ServiceImpl\TripTypeServiceImpl;
use App\Services\ServiceImpl\TitleServiceImpl;

class WebAdminTripTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('web.admin.tripType.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.tripType.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebAdminTripTypeStoreRequest $request)
    {
        //
        TripTypeServiceImpl::store(TripTypeStoreDto::fromJson($request->all()));

        return redirect()->route('web.admin.tripType.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(TripType $tripType)
    {
        //

        return view('web.admin.tripType.show', compact('tripType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TripType $tripType)
    {
        //

        return view('web.admin.tripType.edit', compact('tripType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebAdminTripTypeUpdateRequest $request, TripType $tripType)
    {
        //
        TripTypeServiceImpl::update(TripTypeUpdateDto::fromJson([
            'id' => $tripType->id,
            ...$request->all(),
        ]));

        return redirect()->route('web.admin.tripType.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TripType $tripType)
    {
        //

        $tripType->delete();

        return redirect()->route('web.admin.tripType.index')->with('success', true);
    }
}
