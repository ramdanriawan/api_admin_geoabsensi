<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminUserShiftStoreRequest;
use App\Http\Requests\Web\Admin\WebAdminUserShiftUpdateRequest;
use App\Models\Dtos\UserShiftStoreDto;
use App\Models\Dtos\UserShiftUpdateDto;
use App\Models\Shift;
use App\Models\UserShift;
use App\Services\ServiceImpl\ShiftServiceImpl;
use App\Services\ServiceImpl\UserShiftServiceImpl;
use App\Services\ServiceImpl\TitleServiceImpl;

class WebAdminUserShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['shifts'] = ShiftServiceImpl::findAllNoFilter();

        return view('web.admin.userShift.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.userShift.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebAdminUserShiftStoreRequest $request)
    {
        //
        UserShiftServiceImpl::store(UserShiftStoreDto::fromJson($request->all()));

        return redirect()->route('web.admin.userShift.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserShift $userShift)
    {
        //

        return view('web.admin.userShift.show', compact('userShift'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserShift $userShift)
    {
        //

        return view('web.admin.userShift.edit', compact('userShift'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebAdminUserShiftUpdateRequest $request, UserShift $userShift)
    {
               //
        UserShiftServiceImpl::update(UserShiftUpdateDto::fromJson([
            'id' => $userShift->id,
            ...$request->all(),
        ]));

        return redirect()->route('web.admin.userShift.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserShift $userShift)
    {
        //

        $userShift->delete();

        return redirect()->route('web.admin.userShift.index')->with('success', true);
    }
}
