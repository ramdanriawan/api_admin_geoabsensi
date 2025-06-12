<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Services\ServiceImpl\AttendanceServiceImpl;
use Illuminate\Http\Request;

class WebAdminAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view('web.admin.attendance.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.attendance.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        return redirect()->route('web.admin.attendance.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
        $attendance = AttendanceServiceImpl::addAllAttributes($attendance);

        return view('web.admin.attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //

        return view('web.admin.attendance.edit', compact('attendance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //

        return redirect()->route('web.admin.attendance.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
