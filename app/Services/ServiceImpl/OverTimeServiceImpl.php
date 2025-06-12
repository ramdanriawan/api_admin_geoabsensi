<?php

namespace App\Services\ServiceImpl;

use App\Models\Attendance;
use App\Models\OverTime;
use App\Models\Organization;
use App\Models\User;
use App\Services\AttendanceService;
use App\Services\OverTimeService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use RamdanRiawan\DateTime;
use RamdanRiawan\Geolocator;

class OverTimeServiceImpl implements OverTimeService
{
    private static $withRelations = ['attendance.user'];
    private static $withCount = [];
    public static $columnOrder = [
        'id',
        'attendance_id',
        'start_time',
        'end_time',
        'date',
        'duration_in_minutes',
        'over_type',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function store(User $user, $overType)
    {
        $attendance = AttendanceServiceImpl::findByUserId($user->id);

        $overTime = OverTime::create([
            'attendance_id' => $attendance->id,
            'start_time' => date('H:i:s'),
            'date' => date("Y-m-d"),
            'over_type' => $overType,
        ]);

        $overTime = OverTimeServiceImpl::findByUserId($user->id);

        return $overTime;
    }

    public static function findByUserId(int $userId)
    {
        // cek apakah sudah absen
        $attendance = AttendanceServiceImpl::findByUserId($userId);

        if (!$attendance) {
            return null;
        }

        // cek apakah sudah pernah over apa belum
        $overTime = OverTime::where(['attendance_id' => $attendance->id, 'date' => date('Y-m-d')])->first();

        if (!$overTime) {
            return null;
        }

        $overTime = self::addAllAttributes($overTime);

        return $overTime;
    }

    public static function findByAttendanceId(int $attendanceId)
    {
        $overTime = OverTime::where(['attendance_id' => $attendanceId, 'date' => date('Y-m-d')])->first();

        if (!$overTime) {
            return null;
        }

        $overTime = self::addAllAttributes($overTime);

        return $overTime;
    }

    private static function addAllAttributes(OverTime|Model $item)
    {
        $attendance = AttendanceServiceImpl::addAllAttributes($item->attendance);

        //

        //
        $item->startTimeDateTime = DateTime::getDetail("H:i:s", $item->start_time);
        $item->endTimeDateTime = DateTime::getDetail("H:i:s", $item->end_time);
        $item->dateDateTime = DateTime::getDetail("Y-m-d", $item->date);

        $item->isStarted = $item->start_time != null;

        $item->isEnded = $item->end_time != null && $item->start_time != null;

        $item->isCanEnd = $item->start_time != null && $item->end_time == null;

        $item->isAgreed = $item->status == "agreed";

        $item->isDisagreed = $item->status == "disagreed";

        // kalau attendance sudah checkout maka g bisa mengakhiri / memulai over
        if ($attendance->isCheckOut) {
            $item->isCanStart = true;
        }

        $item->isCanOver = ($item->end_time == null || $item->is_started == null) && $attendance->isCheckOut;

        return $item;
    }

    public static function end(User $user)
    {

        $overTime = self::findByUserId($user->id);

        if(!$overTime) {
            return null;
        }

        $startTime = $overTime->start_time;
        $endTime = date("H:i:s");

        $carbonFormatStartTime = Carbon::createFromFormat("H:i:s", $startTime);
        $carbonFormatEndTime = Carbon::createFromFormat("H:i:s", $endTime);
        $durationInMinutes = $carbonFormatStartTime->diffInMinutes($carbonFormatEndTime);

        $overTime = OverTime::where(['id' => $overTime->id])->first();

        $overTime->update([
            'end_time' => $endTime,
            'duration_in_minutes' => (double)$durationInMinutes,
        ]);

        $overTime = self::findByUserId($user->id);

        return $overTime;
    }

    public static function findAll(
        $length = 10,
        $start = 0,
        $columnToSearch = [

        ],
        $columnToSearchRelation = [

        ],
        $search = '',
        $andCondition = [],
        $columnOrderName = 'id',
        $columnOrderDir = 'desc',
        $notInCondition = [

        ],
        $notInConditionRelation = [

        ],
        $hasRelations = [
        ]
    )
    {
        if (empty($search) && !$start) {

            $data = OverTime::limit($length);
        } else {

            $data = OverTime::limit($length)->offset($start);
        }

        $data->with(self::$withRelations);
        $data->withCount(self::$withCount);
        $data->when($search, function ($query) use ($columnToSearch, $columnToSearchRelation, $search) {
            $query->where(function ($query) use ($columnToSearch, $columnToSearchRelation, $search) {
                foreach ($columnToSearch as $key => $value) {
                    $query->orWhere($value, 'like', '%' . $search . '%');
                }

                foreach ($columnToSearchRelation as $key => $value) {
                    $query->orWhereHas($key, function ($query) use ($value, $search) {
                        $query->where($value, 'like', '%' . $search . '%');
                    });
                }
            });
        });

        foreach ($andCondition as $key => $item) {
            $data->when($item, function ($query) use ($key, $item) {
                $query->where($key, $item);
            });
        }

        foreach ($notInCondition as $key => $item) {
            $data->whereNotIn($key, $item);
        }

        foreach ($notInConditionRelation as $key => $item) {
            $data->whereHas($key, function ($query) use ($key, $item) {
                foreach ($item as $key => $value) {
                    $query->whereNotIn($key, $value);
                }
            });
        }

        foreach ($hasRelations as $key => $item) {

            $data->has($item);
        }

        $data->orderBy(self::$columnOrder[$columnOrderName] ?? $columnOrderName, $columnOrderDir);
        $data = $data->get();

        foreach ($data as $item) {
            $item = self::addAllAttributes($item);
        }

        return $data;
    }


    public static function findAllByUserId(User $user, $start = 0, $end = 100)
    {


        $attendanceIds = Attendance::orderByDesc('id')->where('user_id', $user->id)->pluck('id')->toArray();

        $overTime = OverTime::orderByDesc('id')->whereIn('attendance_id', $attendanceIds)->offset($start)->limit($end)->get();

        foreach ($overTime as $key => $item) {
            $overTime[$key] = self::addAllAttributes($item);
        }

        return $overTime;
    }

    public static function updateStatus(OverTime $overTime, $status)
    {
        $overTime->update([
            'status' => $status,
        ]);

        $overTime = self::addAllAttributes($overTime);

        return $overTime;
    }
}
