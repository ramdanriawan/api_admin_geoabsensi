<?php
namespace App\Services\ServiceImpl;

use App\Models\Trip;
use App\Models\TripAttendance;
use App\Models\User;
use App\Services\TripService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use RamdanRiawan\DateTime;

class TripServiceImpl implements TripService
{
    private static $withRelations = ['employee.user', 'trip_type', 'trip_attendance'];
    private static $withCount = [];
    public static $columnOrder = [
        'id',
        'employee_id',
        'trip_type_id',
        'start_date',
        'end_date',
        'date',
        'duration_in_hours',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function store(
        $employeeId,
        $tripTypeId,
        $startDate,
        $endDate,
        $lat,
        $lng,
        UploadedFile $picture
    ) {
        $startDate       = Carbon::parse($startDate);
        $endDate         = Carbon::parse($endDate);
        $durationInHours = $startDate->diffInHours($endDate);

        $trip = Trip::create([
            'employee_id'       => $employeeId,
            'trip_type_id'      => $tripTypeId,
            'start_date'        => $startDate->format("Y-m-d"),
            'end_date'          => $endDate->format("Y-m-d"),
            'date'              => date("Y-m-d"),
            'duration_in_hours' => $durationInHours,
        ]);

        // buat absensinya
        $tripAttendance = TripAttendanceServiceImpl::store(
            $trip->id,
            $lat,
            $lng,
            $picture
        );

        if(!$tripAttendance) {
            return null;
        }

        $trip = Trip::find($trip->id);

        $trip = self::addAllAttributes($trip);

        return $trip;
    }

    public static function addAllAttributes(Trip | Model $item)
    {
        $endDate = Carbon::parse($item->end_date);

        $item->isWaiting = $item->status == "waiting";

        $item->isStarted = $item->start_date != null && $item->end_date != null && $item->status == "agreed";

        $item->isEnded = Carbon::today()->greaterThan($endDate);

        $item->created_at_human = Carbon::parse($item->created_at)->diffForHumans();
        $item->updated_at_human = Carbon::parse($item->updated_at)->diffForHumans();
        $item->deleted_at_human = Carbon::parse($item->deleted_at)->diffForHumans();

        $item->createdAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->created_at);
        $item->updatedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->updated_at);
        $item->deletedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->deleted_at);


        $item->startDateDateTime = DateTime::getDetail("Y-m-d", $item->start_date);
        $item->endDateDateTime   = DateTime::getDetail("Y-m-d", $item->end_date);
        $item->dateDateTime      = DateTime::getDetail("Y-m-d", $item->date);

        $item->isCanEdit = false;
        $item->isCanDelete = false;
        $item->isCanShow = true;

        return $item;
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

            $data = Trip::limit($length);
        } else {

            $data = Trip::limit($length)->offset($start);
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
        $trip = Trip::orderByDesc('id')->where(['employee_id' => $user->employee->id])->with(['trip_type'])->offset($start)->limit($end)->get();

        foreach ($trip as $key => $item) {
            $trip[$key] = self::addAllAttributes($item);
        }

        return $trip;
    }

    public static function findLastByUserId($id)
    {
        $user = User::findOrFail($id);
        $trip = Trip::with(['trip_type'])->orderByDesc('id')->where(['employee_id' => $user->employee->id])->first();
        if (! $trip) {
            return null;
        }

        $trip = self::addAllAttributes($trip);

        return $trip;
    }

    public static function findByEmployeeIdAndStatus($employeeId, $status)
    {
        $trip = Trip::with(['trip_type'])->orderByDesc('id')
            ->where(['employee_id' => $employeeId, 'status' => $status])
            ->first();

        if (! $trip) {
            return null;
        }

        $trip = self::addAllAttributes($trip);

        return $trip;
    }

    public static function findByEmployeeId($id)
    {
        $trip = Trip::with(['trip_type'])->where(['employee_id' => $id])->first();

        if (! $trip) {
            return null;
        }

        $trip = self::addAllAttributes($trip);

        return $trip;
    }

    public static function updateStatus(Trip $trip, $status)
    {
        $trip->update([
            'status' => $status,
        ]);

        $trip = self::addAllAttributes($trip);

        return $trip;
    }
}
