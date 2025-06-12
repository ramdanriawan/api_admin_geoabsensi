<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminShiftStoreRequest;
use App\Models\Dtos\ShiftStoreDto;
use App\Models\Dtos\ShiftUpdateDto;
use App\Models\Shift;
use App\Services\ServiceImpl\ShiftServiceImpl;
use Illuminate\Http\Request;

class WebAdminShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view('web.admin.shift.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.shift.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebAdminShiftStoreRequest $request)
    {
        //
        ShiftServiceImpl::store(
            ShiftStoreDto::fromJson(
                $request->all()
            )
        );

        return redirect()->route('web.admin.shift.index')->with(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        //

        return view('web.admin.shift.edit', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shift $shift)
    {
        //
        ShiftServiceImpl::update(
            ShiftUpdateDto::fromJson([
                ...$request->all(),
                'id' => $shift->id
            ])
        );

        return redirect()->route('web.admin.shift.index')->with(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift)
    {
        //
    }
}
