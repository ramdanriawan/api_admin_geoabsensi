<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminEmployeeStoreRequest;
use App\Http\Requests\Web\Admin\WebAdminEmployeeUpdateRequest;
use App\Models\Dtos\EmployeeStoreDto;
use App\Models\Dtos\EmployeeUpdateDto;
use App\Models\Employee;
use App\Services\ServiceImpl\EmployeeServiceImpl;
use App\Services\ServiceImpl\TitleServiceImpl;

class WebAdminEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['titles'] = TitleServiceImpl::findAllByEmployees();

        return view('web.admin.employee.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebAdminEmployeeStoreRequest $request)
    {
        //
        EmployeeServiceImpl::store(EmployeeStoreDto::fromJson($request->all()));

        return redirect()->route('web.admin.employee.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //

        return view('web.admin.employee.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //

        return view('web.admin.employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebAdminEmployeeUpdateRequest $request, Employee $employee)
    {
               //
        EmployeeServiceImpl::update(EmployeeUpdateDto::fromJson([
            'id' => $employee->id,
            ...$request->all(),
        ]));

        return redirect()->route('web.admin.employee.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //

        $employee->delete();

        return redirect()->route('web.admin.employee.index')->with('success', true);
    }
}
