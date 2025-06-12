<?php
namespace App\Http\Controllers\Api\V1\Mobile\Employee;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Attendance;
use App\Services\ServiceImpl\AttendanceServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RamdanRiawan\ResponseJson;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
        if (AttendanceServiceImpl::findByUserId($request->user()->id)) {
            return ResponseJson::exist();
        }

        $Validator = Validator::make($request->all(), [
            'lat'     => 'required|numeric',
            'lng'     => 'required|numeric',
            'picture' => 'required|image',
        ]);

        if ($Validator->fails()) {
            return ResponseJson::badRequest($Validator->failed());
        }

        // cek jaraknya, kalau kejauhan tolak saja
        $applicationInfo = Application::where(['is_active' => 1])->first();

        if(!$applicationInfo) {
            return ResponseJson::notFound();
        }

        if (AttendanceServiceImpl::getDistanceFromOrganization($request->lat, $request->lng) > $applicationInfo->maximum_radius_in_meters) {
            return ResponseJson::badRequest(__("Maximum Radius: " . $applicationInfo->maximum_radius_in_meters . " Meters"));
        }

        $attendance = AttendanceServiceImpl::store($request->user(), $request->file('picture'), $request->lat, $request->lng);

        return ResponseJson::success($attendance);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }

    public function findByUserId(Request $request)
    {
        $attendance = AttendanceServiceImpl::findByUserId($request->user()->id);

        if (! $attendance) {
            return ResponseJson::notFound();
        }

        return ResponseJson::success($attendance);
    }

    public function endAttendance(Request $request)
    {
        // apakah sudah checkin atau belum
        if ($attendance = AttendanceServiceImpl::findByUserId($request->user()->id)) {
            if (! $attendance->isCheckIn) {
                return ResponseJson::badRequest(
                    __("Not Check In")
                );
            }
        }


        // kalau udah end attendance maka g usah lagi
        if ($attendance->check_out_time) {
            return ResponseJson::exist();
        }

        $Validator = Validator::make($request->all(), [
            'lat'     => 'required|numeric',
            'lng'     => 'required|numeric',
            'picture' => 'required|image',
        ]);

        if ($Validator->fails()) {
            return ResponseJson::badRequest($Validator->failed());
        }

        // cek jaraknya, kalau kejauhan tolak saja
        $applicationInfo = Application::where(['is_active' => 1])->first();

        if(!$applicationInfo) {
            return ResponseJson::notFound();
        }

        if (AttendanceServiceImpl::getDistanceFromOrganization($request->lat, $request->lng) > $applicationInfo->maximum_radius_in_meters) {
            return ResponseJson::badRequest(__("Maximum Radius: " . $applicationInfo->maximum_radius_in_meters . " Meters"));
        }

        $attendance = AttendanceServiceImpl::endAttendance($request->user(), $request->file('picture'), $request->lat, $request->lng);

        return ResponseJson::success($attendance);
    }
}
