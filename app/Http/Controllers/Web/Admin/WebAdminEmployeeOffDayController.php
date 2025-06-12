<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminEmployeeOffDayStoreRequest;
use App\Http\Requests\Web\Admin\WebAdminEmployeeOffDayUpdateRequest;
use App\Models\Dtos\EmployeeOffDayStoreDto;
use App\Models\Dtos\EmployeeOffDayUpdateDto;
use App\Models\EmployeeOffDay;
use App\Services\ServiceImpl\OffTypeServiceImpl;
use App\Services\ServiceImpl\EmployeeOffDayServiceImpl;
use App\Services\ServiceImpl\TitleServiceImpl;

class WebAdminEmployeeOffDayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['offTypes'] = OffTypeServiceImpl::findAllNoFilter();

        return view('web.admin.employeeOffDay.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.employeeOffDay.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebAdminEmployeeOffDayStoreRequest $request)
    {
        //
        EmployeeOffDayServiceImpl::store(EmployeeOffDayStoreDto::fromJson($request->all()));

        return redirect()->route('web.admin.employeeOffDay.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeOffDay $employeeOffDay)
    {
        //

        return view('web.admin.employeeOffDay.show', compact('employeeOffDay'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeOffDay $employeeOffDay)
    {
        //

        return view('web.admin.employeeOffDay.edit', compact('employeeOffDay'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebAdminEmployeeOffDayUpdateRequest $request, EmployeeOffDay $employeeOffDay)
    {
               //
        EmployeeOffDayServiceImpl::update(EmployeeOffDayUpdateDto::fromJson([
            'id' => $employeeOffDay->id,
            ...$request->all(),
        ]));

        return redirect()->route('web.admin.employeeOffDay.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeOffDay $employeeOffDay)
    {
        //

        $employeeOffDay->delete();

        return redirect()->route('web.admin.employeeOffDay.index')->with('success', true);
    }
}
