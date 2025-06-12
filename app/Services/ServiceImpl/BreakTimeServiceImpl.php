<?php

namespace App\Services\ServiceImpl;

use App\Models\Attendance;
use App\Models\BreakTime;
use App\Models\Organization;
use App\Models\User;
use App\Services\BreakTimeService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use RamdanRiawan\DateTime;
use RamdanRiawan\Geolocator;

class BreakTimeServiceImpl implements BreakTimeService
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
        'break_type',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function store(User $user, $breakType)
    {
        $attendance = AttendanceServiceImpl::findByUserId($user->id);

        if(!$attendance) {
            return null;
        }

        $breakTime = BreakTime::create([
            'attendance_id' => $attendance->id,
            'start_time' => date('H:i:s'),
            'date' => date("Y-m-d"),
            'break_type' => $breakType,
        ]);

        $breakTime = BreakTimeServiceImpl::findByUserId($user->id);

        return $breakTime;
    }

    public static function findByUserId(int $userId)
    {
        // cek apakah sudah absen
        $attendance = AttendanceServiceImpl::findByUserId($userId);

        if (!$attendance) {
            return null;
        }

        // cek apakah sudah pernah break apa belum
        $breakTime = BreakTime::where(['attendance_id' => $attendance->id, 'date' => date('Y-m-d')])->first();

        if (!$breakTime) {
            return null;
        }

        $breakTime = self::addAllAttributes($breakTime);

        return $breakTime;
    }

    public static function findByAttendanceId(int $attendanceId)
    {
        $breakTime = BreakTime::where(['attendance_id' => $attendanceId, 'date' => date('Y-m-d')])->first();

        if (!$breakTime) {
            return null;
        }

        $breakTime = self::addAllAttributes($breakTime);

        return $breakTime;
    }

    private static function addAllAttributes(BreakTime|Model $breakTime)
    {
        $attendance = AttendanceServiceImpl::addAllAttributes($breakTime->attendance);

        if (!$attendance) {
            return null;
        }

        //
        $breakTime->startTimeDateTime = DateTime::getDetail("H:i:s", $breakTime->start_time);
        $breakTime->endTimeDateTime = DateTime::getDetail("H:i:s", $breakTime->end_time);
        $breakTime->dateDateTime = DateTime::getDetail("Y-m-d", $breakTime->date);

        $breakTime->isStarted = $breakTime->start_time != null;

        $breakTime->isEnded = $breakTime->end_time != null && $breakTime->start_time != null;

        $breakTime->isCanEnd = $breakTime->start_time != null && $breakTime->end_time == null;

        // kalau attendance sudah checkout maka g bisa mengakhiri / memulai break
        if ($attendance->isCheckOut) {
            $breakTime->isCanEnd = false;
        }

        $breakTime->isCanBreak = $breakTime->end_time == null || $breakTime->start_time == null;

        if ($attendance->isCheckOut) {
            $breakTime->isCanBreak = false;
        }

        return $breakTime;
    }

    public static function end(User $user)
    {

        $breakTime = self::findByUserId($user->id);

        if(!$breakTime) {
            return null;
        }

        $startTime = $breakTime->start_time;
        $endTime = date("H:i:s");

        $carbonFormatStartTime = Carbon::createFromFormat("H:i:s", $startTime);
        $carbonFormatEndTime = Carbon::createFromFormat("H:i:s", $endTime);
        $durationInMinutes = $carbonFormatStartTime->diffInMinutes($carbonFormatEndTime);

        $breakTime = BreakTime::where(['id' => $breakTime->id])->first();

        if(!$breakTime) {
            return null;
        }

        $breakTime->update([
            'end_time' => $endTime,
            'duration_in_minutes' => (double)$durationInMinutes,
        ]);

        $breakTime = self::findByUserId($user->id);

        return $breakTime;
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

            $data = BreakTime::limit($length);
        } else {

            $data = BreakTime::limit($length)->offset($start);
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
        $attendanceUserIds = Attendance::orderByDesc('id')
            ->where(['user_id' => $user->id])
            ->pluck('id')
            ->toArray();

        $breakTime = BreakTime::whereIn('attendance_id', $attendanceUserIds)->offset($start)->limit($end)->get();

        foreach ($breakTime as $key => $item) {
            $breakTime[$key] = self::addAllAttributes($item);

            if (!$breakTime[$key]) {
                return [];
            }
        }

        if (empty($breakTime)) {
            return [];
        }

        return $breakTime;
    }
}
