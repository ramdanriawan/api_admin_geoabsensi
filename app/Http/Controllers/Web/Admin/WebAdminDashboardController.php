<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\OffDay;
use App\Models\OverTime;
use App\Services\ServiceImpl\AttendanceServiceImpl;
use App\Services\ServiceImpl\OrganizationServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\Table;

class WebAdminDashboardController extends Controller
{
    //
    public function index()
    {
        $employeeCount = Employee::whereHas('user', function ($query) {
            $query->where(['status' => 'active']);
        })->count();

        $attendanceCount = Attendance::whereHas('user', function ($query) {
            $query->where(['status' => 'active']);
        })->count();

        $overTimeCount = OverTime::whereHas('attendance.user', function ($query) {
            $query->where(['status' => 'active']);
        })->count();

        $offDayCount = OffDay::whereHas('employee.user', function ($query) {
            $query->where(['status' => 'active']);
        })->count();

        // last week
        $organization = OrganizationServiceImpl::findActive();


        return view('web.admin.dashboard.index', [
            'employeeCount' => $employeeCount,
            'attendanceCount' => $attendanceCount,
            'overTimeCount' => $overTimeCount,
            'offDayCount' => $offDayCount,

            // Tabel attendance hari ini
            'todayAttendances' => AttendanceServiceImpl::findAll(
                length: 10,
                start: 0,
                columnToSearch: Table::getColumn(new Attendance()),
                columnToSearchRelation: [

                ],
                search: '',
                andCondition: [
                    'date' => date('Y-m-d'),
                ],
                columnOrderName: 'id',
                columnOrderDir: 'desc',
            ),

            // Grafik weekly dummy
            'weeklyAttendanceChartData' => [
                [
                    'day' => now()->addDays(-4)->dayName,
                    'present' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(-4)->toDateString(), 'present'),
                    'late' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(-4)->toDateString(), 'late'),
                    'not_present' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(-4)->toDateString(), 'not present'),
                ], [
                    'day' => now()->addDays(-4)->dayName,
                    'present' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(-4)->toDateString(), 'present'),
                    'late' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(-4)->toDateString(), 'late'),
                    'not_present' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(-4)->toDateString(), 'not present'),
                ], [
                    'day' => now()->addDays(-3)->dayName,
                    'present' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(-3)->toDateString(), 'present'),
                    'late' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(-3)->toDateString(), 'late'),
                    'not_present' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(-3)->toDateString(), 'not present'),
                ], [
                    'day' => now()->addDays(-2)->dayName,
                    'present' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(-2)->toDateString(), 'present'),
                    'late' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(-2)->toDateString(), 'late'),
                    'not_present' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(-2)->toDateString(), 'not present'),
                ], [
                    'day' => now()->addDays(-1)->dayName,
                    'present' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(-1)->toDateString(), 'present'),
                    'late' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(-1)->toDateString(), 'late'),
                    'not_present' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(-1)->toDateString(), 'not present'),
                ], [
                    'day' => now()->addDays(0)->dayName,
                    'present' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(0)->toDateString(), 'present'),
                    'late' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(0)->toDateString(), 'late'),
                    'not_present' => AttendanceServiceImpl::countAttendanceByDateAndStatus(now()->addDays(0)->toDateString(), 'not present'),
                ],
            ],

            // Map center (ambil titik tengah asal)
            'mapCenterLat' => $organization->lat,
            'mapCenterLng' => $organization->lng,
        ]);

    }
}
