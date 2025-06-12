<?php

namespace App\Services\ServiceImpl;

use App\Models\Attendance;
use App\Models\OffDay;
use App\Models\OffType;
use App\Models\Recape;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use RamdanRiawan\Accounting;
use RamdanRiawan\DateTime;
use stdClass;

class RecapeServiceImpl
{
    public static function createRecape(User|Model $user, $startDate, $endDate)
    {
        if(!$user->employee){
            return null;
        }

        $recape = new stdClass();

        $attendance = Attendance::where(['user_id' => $user->id])->whereBetween('date', [$startDate, $endDate])->get();

        if (!$attendance->count()) {
            return null;
        }

        $recape->present = $attendance->where('status', 'present')->count();
        $recape->late = $attendance->where('status', 'late')->count();
        $recape->absent = $attendance->where('status', 'not present')->count();

        // overtime hours
        $totalMinutes = $attendance->sum(function ($item) {
            return optional($item->overTime)->duration_in_minutes ?? 0;
        });

        $recape->overTimeHours = $totalMinutes / 60;

        // sick
        $offDay = OffDayServiceImpl::findByUserIdAndDate($user->id, $startDate, $endDate);

        $offType = OffType::where(['name' => 'Sick'])->first();
        $recape->sick = $offDay ? $offDay->where('off_type_id', $offType->id)->count() : 0;

        // offDay
        $offType = OffType::whereNotIn('name', ['Sick'])->get();
        $recape->offDay = $offDay ? $offDay->whereNotIn('off_type_id', $offType->pluck('id')->toArray())->count() : 0;

        // trip
        $trip = Trip::where([
            'employee_id' => $user->employee->id,
        ])->whereBetween(
            'date', [$startDate, $endDate],
        )->where([
            'status' => 'agreed',
        ])->get();

        $recape->trip = $trip->count();

        // $recape->save();

        // $recape->startDateDateTime = DateTime::getDetail("Y-m-d", $recape->start_date);
        // $recape->endDateDateTime   = DateTime::getDetail("Y-m-d", $recape->end_date);

        $recape->startDateDateTime = DateTime::getDetail("Y-m-d", $startDate);
        $recape->endDateDateTime = DateTime::getDetail("Y-m-d", $endDate);
        $recape->user = User::with(['employee.title'])->find($user->id);

        // perhitungan bayaran
        $recape->deduction_late_or_leave = $user->employee->title->penalty_per_late * $recape->late;
        $recape->deductionLateOrLeaveString = Accounting::formatRupiah($recape->deduction_late_or_leave);

        $recape->meal_allowance = $user->employee->title->meal_allowance_per_present * $recape->present;
        $recape->mealAllowanceString = Accounting::formatRupiah($recape->meal_allowance);

        $recape->transport_allowance = $user->employee->title->transport_allowance_per_present * $recape->present;
        $recape->transportAllowanceString = Accounting::formatRupiah($recape->transport_allowance);

        $recape->overTime_pay = $user->employee->title->overTime_pay_per_hours * $recape->overTimeHours;
        $recape->overTimePayString = Accounting::formatRupiah($recape->overTime_pay);

        return $recape;
    }
}
