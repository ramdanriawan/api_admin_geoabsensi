<?php

namespace App\Services\ServiceImpl;

use App\Models\Dtos\EmployeeOffDayStoreDto;
use App\Models\Dtos\EmployeeOffDayUpdateDto;
use App\Models\Employee;
use App\Models\EmployeeOffDay;
use App\Models\OffDay;
use App\Services\OffDayService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use RamdanRiawan\DateTime;

class EmployeeOffDayServiceImpl implements OffDayService
{

    private static $withRelations = ['employee.user', 'off_type'];
    private static $withCount = [];
    public static $columnOrder = [
        'id',
        'employee_id',
        'off_type_id',
    ];

    public static function findByEmployeeAndTypeId(int $employeeId, $offTypeId)
    {
        $employeeOffDay = EmployeeOffDay::where([
            'employee_id' => $employeeId,
            'off_type_id' => $offTypeId,
            ])->first();

        if (! $employeeOffDay) {
            return null;
        }

        $employeeOffDay = self::addAllAttributes($employeeOffDay);

        return $employeeOffDay;
    }

    private static function addAllAttributes(EmployeeOffDay | Model $item)
    {
        //
        $item->created_at_human = Carbon::parse($item->created_at)->diffForHumans();
        $item->updated_at_human = Carbon::parse($item->updated_at)->diffForHumans();
        $item->deleted_at_human = Carbon::parse($item->deleted_at)->diffForHumans();

        $item->createdAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->created_at);
        $item->updatedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->updated_at);
        $item->deletedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->deleted_at);

        $item->isCanDelete = true;
        $item->isCanEdit = true;

        return $item;
    }


    public
    static function findOne($id)
    {

        $data = EmployeeOffDay::with(self::$withRelations)->where(['id' => $id])->withCount(self::$withCount)->first();

        $data = self::addAllAttributes($data);

        return $data;
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

            $data = EmployeeOffDay::limit($length);
        } else {

            $data = EmployeeOffDay::limit($length)->offset($start);
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

    public static function update(EmployeeOffDayUpdateDto $employeeOffDayUpdateDto)
    {
        $input = [
            'employee_id' => $employeeOffDayUpdateDto->getEmployeeId(),
            'off_type_id' => $employeeOffDayUpdateDto->getOffTypeId(),
            'quota' => $employeeOffDayUpdateDto->getQuota()
        ];

        $employeeOffDay = EmployeeOffDay::find($employeeOffDayUpdateDto->getId());

        $employeeOffDay->update($input);

        $employeeOffDay = self::addAllAttributes($employeeOffDay);

        return $employeeOffDay;
    }


    public static function store(EmployeeOffDayStoreDto $employeeOffDayStoreDto)
    {
        $input = [
            'employee_id' => $employeeOffDayStoreDto->getEmployeeId(),
            'off_type_id' => $employeeOffDayStoreDto->getOffTypeId(),
            'quota' => $employeeOffDayStoreDto->getQuota()
        ];


        $employeeOffDay = EmployeeOffDay::create($input);

        $employeeOffDay = EmployeeOffDay::find($employeeOffDay->id);

        $employeeOffDay = self::addAllAttributes($employeeOffDay);

        return $employeeOffDay;
    }

    public static function decreaseQuota($employeeId, $offTypeId)
    {
        $employeeOffDay = EmployeeOffDay::where(['employee_id' => $employeeId, 'off_type_id' => $offTypeId])->first();

        if(!$employeeOffDay) {
            return null;
        }

        if ($employeeOffDay->quota) {

            $employeeOffDay->decrement('quota', 1);
        }
    }


    public static function delete(EmployeeOffDay $employeeOffDay)
    {
        DB::transaction(function () use ($employeeOffDay) {

            $employeeOffDay->delete();
        });
    }
}
