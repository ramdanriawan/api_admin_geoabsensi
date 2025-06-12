<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminOffTypeStoreRequest;
use App\Http\Requests\Web\Admin\WebAdminOffTypeUpdateRequest;
use App\Models\Dtos\OffTypeStoreDto;
use App\Models\Dtos\OffTypeUpdateDto;
use App\Models\Shift;
use App\Models\OffType;
use App\Services\ServiceImpl\ShiftServiceImpl;
use App\Services\ServiceImpl\OffTypeServiceImpl;
use App\Services\ServiceImpl\TitleServiceImpl;

class WebAdminOffTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['shifts'] = ShiftServiceImpl::findAllNoFilter();

        return view('web.admin.offType.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.offType.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebAdminOffTypeStoreRequest $request)
    {
        //
        OffTypeServiceImpl::store(OffTypeStoreDto::fromJson($request->all()));

        return redirect()->route('web.admin.offType.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(OffType $offType)
    {
        //

        return view('web.admin.offType.show', compact('offType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OffType $offType)
    {
        //

        return view('web.admin.offType.edit', compact('offType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebAdminOffTypeUpdateRequest $request, OffType $offType)
    {
        //
        OffTypeServiceImpl::update(OffTypeUpdateDto::fromJson([
            'id' => $offType->id,
            ...$request->all(),
        ]));

        return redirect()->route('web.admin.offType.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OffType $offType)
    {
        //

        $offType->delete();

        return redirect()->route('web.admin.offType.index')->with('success', true);
    }
}
