<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminVisitTypeStoreRequest;
use App\Http\Requests\Web\Admin\WebAdminVisitTypeUpdateRequest;
use App\Models\Dtos\VisitTypeStoreDto;
use App\Models\Dtos\VisitTypeUpdateDto;
use App\Models\Shift;
use App\Models\VisitType;
use App\Services\ServiceImpl\ShiftServiceImpl;
use App\Services\ServiceImpl\VisitTypeServiceImpl;
use App\Services\ServiceImpl\TitleServiceImpl;

class WebAdminVisitTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('web.admin.visitType.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.visitType.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebAdminVisitTypeStoreRequest $request)
    {
        //
        VisitTypeServiceImpl::store(VisitTypeStoreDto::fromJson($request->all()));

        return redirect()->route('web.admin.visitType.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(VisitType $visitType)
    {
        //

        return view('web.admin.visitType.show', compact('visitType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VisitType $visitType)
    {
        //

        return view('web.admin.visitType.edit', compact('visitType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebAdminVisitTypeUpdateRequest $request, VisitType $visitType)
    {
        //
        VisitTypeServiceImpl::update(VisitTypeUpdateDto::fromJson([
            'id' => $visitType->id,
            ...$request->all(),
        ]));

        return redirect()->route('web.admin.visitType.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VisitType $visitType)
    {
        //

        $visitType->delete();

        return redirect()->route('web.admin.visitType.index')->with('success', true);
    }
}
