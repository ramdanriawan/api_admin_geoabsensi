<?php

namespace App\Http\Controllers\Api\V1\Mobile\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Services\ServiceImpl\AttendanceServiceImpl;
use App\Services\ServiceImpl\BreakTimeServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;

class BreakTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // kalau sudah absen cek apakah dia sudah sudah break atau belum
        $attendance = AttendanceServiceImpl::findByUserId($request->user()->id);

        if(!$attendance) {
            return ResponseJson::notFound();
        }

        // kalau dia sudah absen cek apakak dia sudah break time apa belum
        $breakTime = BreakTimeServiceImpl::findByAttendanceId($attendance->id);

        if($breakTime) {
            return ResponseJson::exist();
        }

        $breakTime = BreakTimeServiceImpl::store($request->user(), $request->break_type);

        return ResponseJson::success($breakTime);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function findByAttendanceId(Request $request, $attendanceId) {

        $breakTime = BreakTimeServiceImpl::findByAttendanceId($attendanceId);


        if(!$breakTime) {
            return ResponseJson::notFound();
        }

        return ResponseJson::success($breakTime);
    }

    public function findByUserId(Request $request) {
        $breakTime = BreakTimeServiceImpl::findByUserId($request->user()->id);

        if(!$breakTime) {
            return ResponseJson::notFound();
        }

        return ResponseJson::success($breakTime);
    }

    public function end(Request $request) {
        // cek apakah sudah di end dan apakah sudah mulai
        $breakTime = BreakTimeServiceImpl::findByUserId($request->user()->id);

        if(!$breakTime) {
            return ResponseJson::notFound();
        }

        if($breakTime->isEnded) {
            return ResponseJson::badRequest(__("Is Ended"));
        }

        $breakTime = BreakTimeServiceImpl::end($request->user());
        $breakTime = BreakTimeServiceImpl::findByUserId($request->user()->id);

        return ResponseJson::success($breakTime);
    }
}
