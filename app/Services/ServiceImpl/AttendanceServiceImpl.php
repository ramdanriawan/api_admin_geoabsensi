<?php

namespace App\Services\ServiceImpl;

use App\Models\Attendance;
use App\Models\OffDay;
use App\Models\Organization;
use App\Models\User;
use App\Services\AttendanceService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RamdanRiawan\DateTime;
use RamdanRiawan\Geolocator;

class AttendanceServiceImpl implements AttendanceService
{
    private static $withRelations = ['breakTime', 'user', 'overTime'];
    private static $withCount = [];
    public static $columnOrder = [
        'id',
        'user_id',
        'check_in_time',
        'check_out_time',
        'attendance_total_hours',
        'date',
        'status',
        'picture',
        'picture_check_out',
        'lat',
        'lng',
        'distance_in_meters',
        'distance_in_meters_check_out',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

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

            $data = Attendance::limit($length);
        } else {

            $data = Attendance::limit($length)->offset($start);
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

    public static function getDistanceFromOrganization($lat, $lng)
    {
        $organization = Organization::where(['is_active' => 1])->first();

        if (!$organization) {
            return null;
        }

        $distanceInMeters = Geolocator::distanceBetween($lat, $lng, $organization->lat, $organization->lng, 'm');

        return $distanceInMeters;
    }

    public static function getAttendanceStatusStore(User $user)
    {
        $userShift = UserShiftServiceImpl::findByUserId($user->id);

        $shiftstart = Carbon::createFromFormat('H:i:s', $userShift->shift->start_time);

        $status = $shiftstart->isBefore(Carbon::now()) ? "late" : "present";

        return $status;
    }

    public static function store(User $user, UploadedFile $picture, $lat, $lng)
    {
        $picturePath = $picture->store('images', 'public');

        $distanceInMeters = self::getDistanceFromOrganization($lat, $lng);

        $attendance = Attendance::updateOrCreate([
            'user_id' => $user->id,
            'date' => date('Y-m-d'),
        ], [
            'check_in_time' => date('H:i:s'),
            'picture' => Storage::url($picturePath),
            'distance_in_meters' => round($distanceInMeters, 2),
            'lat' => $lat,
            'lng' => $lng,
            'status' => self::getAttendanceStatusStore($user)
        ]);

        $attendance = Attendance::find($attendance->id);

        $attendance = self::addAllAttributes($attendance);

        return $attendance;
    }

    public static function addNotPresent(User $user)
    {
        if (!$user) {
            return null;
        }

        $attendance = Attendance::create([
            'user_id' => $user->id,
            'date' => date('Y-m-d'),
            'status' => 'not present',
        ]);

        $attendance = Attendance::find($attendance->id);

        $attendance = self::addAllAttributes($attendance);

        return $attendance;
    }

    public static function findByBreakTime($attendanceId)
    {
        $attendance = Attendance::find($attendanceId);
        if (!$attendance) {

            return null;
        }

        $attendance = self::addAllAttributes($attendance);

        return $attendance;
    }

    public static function findByOverTime($attendanceId)
    {
        $attendance = Attendance::find($attendanceId);

        if (!$attendance) {
            return null;
        }

        $attendance = self::addAllAttributes($attendance);

        return $attendance;
    }

    public static function findByOffDay($attendanceId)
    {
        $attendance = OffDay::findOrFail($attendanceId);

        if (!$attendance) {
            return null;
        }

        $attendance = self::addAllAttributes($attendance);

        return $attendance;
    }

    public static function findByUserId(int $userId)
    {
        $attendance = Attendance::where([
            'user_id' => $userId,
            'date' => date('Y-m-d')
        ])->whereNotIn('status', [
            'not present',
        ])->first();

        if (!$attendance) {
            return null;
        }

        $attendance = self::addAllAttributes($attendance);

        return $attendance;
    }

    public static function addAllAttributes(Attendance|Model $item)
    {
        if (!$item) {
            return null;
        }

        $item->pictureUrl = url($item->picture);
        $item->pictureCheckOutUrl = url($item->picture_check_out);

        if ((!$item->attendance_total_hours && $item->check_in_time)) {

            $item->attendance_total_hours = number_format(abs(now()->diffInHours(Carbon::createFromFormat("H:i:s", $item->check_in_time))), 2);
        }


        $item->isPresent = $item->status == "present";
        $item->isLate = $item->status == "late";
        $item->isNotPresent = $item->status == "not present";
        $item->isWfh = $item->status == "wfh";
        $item->isCheckOut = $item->check_out_time != null;
        $item->isCheckIn = $item->check_in_time != null;
        $item->isCanAttendance = $item->check_in_time == null || $item->check_out_time == null;
        $item->isCanCheckOut = $item->isCanAttendance && !$item->isCheckOut;

        // kalau mau istirahat ya harus absen dulu dan belum pulang
        $item->canBreakTime = $item->isCheckIn && !$item->isCheckOut;

        // kalau mau lembur ya harus absen datang dan pulang dulu
        $item->canOverTime = $item->isCheckIn && $item->isCheckOut;

        // kalau mau cuti ya ga perlu absen
        $item->canOffDay = !$item->isCheckIn;

        // kalau izin brartiharus absen dulu
        $item->canLeave = $item->isCheckIn;

        // kalau ada kunjungan harus absen, tapi boleh dari tempat kunjungan
        $item->canTrip = $item->isCheckIn;

        // untuk memberikan catatan berarti harus izin dulu
        $item->canNote = $item->isCheckIn;

        $item->isCanDelete = false;
        $item->isCanEdit = false;
        $item->isCanShow = true;

        $item->created_at_human = Carbon::parse($item->created_at)->diffForHumans();
        $item->updated_at_human = Carbon::parse($item->updated_at)->diffForHumans();
        $item->deleted_at_human = Carbon::parse($item->deleted_at)->diffForHumans();

        $item->dateDateTime = DateTime::getDetail('Y-m-d', $item->date);
        $item->createdAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->created_at);
        $item->updatedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->updated_at);
        $item->deletedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->deleted_at);


        return $item;
    }

    public static function endAttendance(User $user, UploadedFile $picture, $lat, $lng)
    {

        $attendance = self::findByUserId($user->id);

        if (!$attendance) {
            return null;
        }

        $picturePath = $picture->store('images', 'public');

        $checkInTime = $attendance->check_in_time;
        $checkOutTime = date("H:i:s");

        $carbonFormatCheckIn = Carbon::createFromFormat("H:i:s", $checkInTime);
        $carbonFormatCheckOut = Carbon::createFromFormat("H:i:s", $checkOutTime);
        $attendanceTotalHours = $carbonFormatCheckIn->diffInHours($carbonFormatCheckOut);

        $attendance = Attendance::where(['id' => $attendance->id])->first();

        $distanceInMeters = self::getDistanceFromOrganization($lat, $lng);

        $attendance->update([
            'check_out_time' => $checkOutTime,
            'attendance_total_hours' => (double)$attendanceTotalHours,
            'picture_check_out' => Storage::url($picturePath),
            'distance_in_meters_check_out' => round($distanceInMeters, 2),
        ]);

        $attendance = self::findByUserId($user->id);

        return $attendance;
    }

    public static function countAttendanceByDateAndStatus($date, $status)
    {
        $attendanceCount = Attendance::where(['date' => $date, 'status' => $status])->count();

        return $attendanceCount;
    }
}
