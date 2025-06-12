<?php
namespace App\Services\ServiceImpl;

use App\Models\OffDay;
use App\Models\User;
use App\Services\OffDayService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use RamdanRiawan\DateTime;

class OffDayServiceImpl implements OffDayService
{
    private static $withRelations = ['employee.user', 'off_type'];
    private static $withCount = [];
    public static $columnOrder = [
        'id',
        'employee_id',
        'off_type_id',
        'start_date',
        'end_date',
        'date',
        'duration_in_days',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function store(

        $employeeId,
        $offTypeId,
        $startDate,
        $endDate,
    ) {
        // cek dulu apakah dia punya employee off day apa tidak dan dia punya quota atau tidak
        $employeeOffDay = EmployeeOffDayServiceImpl::findByEmployeeAndTypeId($employeeId, $offTypeId);

        if (!$employeeOffDay) {
            return null;
        }

        if(!$employeeOffDay->quota) {
            return null;
        }

        $startDate      = Carbon::parse($startDate);
        $endDate        = Carbon::parse($endDate);
        $durationInDays = $startDate->diffInDays($endDate);

        $offDay = OffDay::create([
            'employee_id'      => $employeeId,
            'off_type_id'      => $offTypeId,
            'start_date'       => $startDate->format("Y-m-d"),
            'end_date'         => $endDate->format("Y-m-d"),
            'date'             => date("Y-m-d"),
            'duration_in_days' => $durationInDays,
        ]);

        EmployeeOffDayServiceImpl::decreaseQuota($employeeId, $offTypeId);

        $offDay = OffDay::with(['off_type'])->find($offDay->id);

        $offDay = self::addAllAttributes($offDay);

        return $offDay;
    }

    private static function addAllAttributes(OffDay | Model $offDay)
    {

        $endDate = Carbon::parse($offDay->end_date);

        $offDay->isWaiting = $offDay->status == "waiting";

        $offDay->isStarted = $offDay->start_date != null && $offDay->end_date != null && $offDay->status == "agreed";

        $offDay->isEnded = Carbon::today()->greaterThan($endDate);

        $offDay->isOnOffDay = $offDay->isStarted && ! $offDay->isEnded;

        //
        $offDay->startDateDateTime = DateTime::getDetail("Y-m-d", $offDay->start_date);
        $offDay->endDateDateTime   = DateTime::getDetail("Y-m-d", $offDay->end_date);
        $offDay->dateDateTime      = DateTime::getDetail("Y-m-d", $offDay->date);

        return $offDay;
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

            $data = OffDay::limit($length);
        } else {

            $data = OffDay::limit($length)->offset($start);
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
        $offDay = OffDay::orderByDesc('id')->where(['employee_id' => $user->employee->id])->with(['off_type'])->offset($start)->limit($end)->get();

        foreach ($offDay as $key => $item) {
            $offDay[$key] = self::addAllAttributes($item);
        }

        return $offDay;
    }

    public static function findLastByUserId($id)
    {
        $user   = User::findOrFail($id);
        $offDay = OffDay::with(['off_type'])->orderByDesc('id')->where(['employee_id' => $user->employee->id])->first();
        if (! $offDay) {
            return null;
        }

        $offDay = self::addAllAttributes($offDay);

        return $offDay;
    }

    public static function findByEmployeeIdAndStatus($employeeId, $status)
    {
        $offDay = OffDay::with(['off_type'])->orderByDesc('id')
            ->where(['employee_id' => $employeeId, 'status' => $status])
            ->first();

        if (! $offDay) {
            return null;
        }

        $offDay = self::addAllAttributes($offDay);

        return $offDay;
    }

    public static function findByEmployeeId($id)
    {
        $offDay = OffDay::with(['off_type'])->where(['employee_id' => $id])->first();

        if (! $offDay) {
            return null;
        }

        $offDay = self::addAllAttributes($offDay);

        return $offDay;
    }

    public static function findByUserIdAndDate($userId, $startDate, $endDate)
    {
        $user = User::findOrFail($userId);

        if(!$user->employee) {
            return null;
        }

        $offDay = OffDay::with(['off_type'])->where([
            'employee_id' => $user->employee->id,
        ])
        ->whereBetween('date', [$startDate, $endDate])
        ->where([
            'status' => 'agreed',
        ])->get();

        if (! $offDay->count()) {
            return null;
        }

        foreach ($offDay as $key => $item) {
            $item = self::addAllAttributes($item);
        }

        return $offDay;
    }


    public static function updateStatus(OffDay $offDay, $status)
    {
        $offDay->update([
            'status' => $status,
        ]);

        $offDay = self::addAllAttributes($offDay);

        return $offDay;
    }
}
