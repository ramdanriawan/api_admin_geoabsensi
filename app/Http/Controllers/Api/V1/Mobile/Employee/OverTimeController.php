<?php

namespace App\Http\Controllers\Api\V1\Mobile\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Services\ServiceImpl\AttendanceServiceImpl;
use App\Services\ServiceImpl\OverTimeServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;

class OverTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $data = OverTimeServiceImpl::findAll();

        return ResponseJson::success($data);
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
        // kalau sudah absen cek apakah dia sudah sudah over atau belum
        $attendance = AttendanceServiceImpl::findByUserId($request->user()->id);

        if(!$attendance) {
            return ResponseJson::notFound();
        }

        // kalau dia sudah absen cek apakak dia sudah over time apa belum
        $overTime = OverTimeServiceImpl::findByAttendanceId($attendance->id);

        if($overTime) {
            return ResponseJson::exist();
        }

        $overTime = OverTimeServiceImpl::store($request->user(), $request->over_type);

        return ResponseJson::success($overTime);
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


    public function findByAttendanceId(Request $request, Attendance $attendance) {
        $overTime = OverTimeServiceImpl::findByAttendanceId($attendance->id);


        if(!$overTime) {
            return ResponseJson::notFound();
        }

        return ResponseJson::success($overTime);
    }

    public function findByUserId(Request $request) {
        $overTime = OverTimeServiceImpl::findByUserId($request->user()->id);

        if(!$overTime) {
            return ResponseJson::notFound();
        }

        return ResponseJson::success($overTime);
    }

    public function end(Request $request) {
        // cek apakah sudah di end dan apakah sudah mulai
        $overTime = OverTimeServiceImpl::findByUserId($request->user()->id);

        if(!$overTime) {
            return ResponseJson::notFound();
        }

        if($overTime->isEnded) {
            return ResponseJson::badRequest(__("Is Ended"));
        }

        $overTime = OverTimeServiceImpl::end($request->user());
        $overTime = OverTimeServiceImpl::findByUserId($request->user()->id);

        return ResponseJson::success($overTime);
    }
}
