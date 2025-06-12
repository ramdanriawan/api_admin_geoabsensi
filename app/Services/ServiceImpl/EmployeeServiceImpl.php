<?php

namespace App\Services\ServiceImpl;

use App\Models\Dtos\EmployeeStoreDto;
use App\Models\Dtos\EmployeeUpdateDto;
use App\Models\Employee;
use App\Models\Title;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\DB;
use RamdanRiawan\DateTime;

class EmployeeServiceImpl implements EmployeeService
{
    private static $withRelations = ['title', 'user', 'employee_offDays'];
    private static $withCount = [
        'employee_offDays'
    ];
    public static $columnOrder = [
        'id',
        'user_id',
        'title_id',
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

            $data = Employee::limit($length);
        } else {

            $data = Employee::limit($length)->offset($start);
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

    public static function findByUserId($userId)
    {
        $employee = Employee::with(['title'])->where(['user_id' => $userId])->first();

        if(!$employee) {
            return null;
        }

        $employee = self::addAllAttributes($employee);

        return $employee;
    }


    public static function addAllAttributes(Employee $item)
    {
        if (!$item) {
            return null;
        }

        $item->user = UserServiceImpl::addAllAttributes($item->user);

        $item->createdAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->created_at);
        $item->updatedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->updated_at);
        $item->deletedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->deleted_at);

        $item->isCanDelete = true;

        return $item;
    }


    public static function findOne($id)
    {
        $employee = Employee::with(self::$withRelations)->where(['id' => $id])->withCount(self::$withCount)->first();

        if(!$employee) {
            return null;
        }

        $employee = self::addAllAttributes($employee);

        return $employee;
    }


    public static function delete(Employee $employee)
    {
        DB::transaction(function () use ($employee) {

            $employee->delete();
        });
    }


    public static function update(EmployeeUpdateDto $employeeUpdateDto)
    {
        $input = [
            'title_id' => $employeeUpdateDto->getTitleID(),
            'user_id' => $employeeUpdateDto->getUserID(),
        ];

        $employee = Employee::find($employeeUpdateDto->getId());

        if(!$employee) {
            return null;
        }

        $employee->update($input);

        $employee = self::addAllAttributes($employee);

        return $employee;
    }


    public static function store(EmployeeStoreDto $employeeStoreDto)
    {

        $employee = Employee::create([
            'title_id' => $employeeStoreDto->getTitleID(),
            'user_id' => $employeeStoreDto->getUserID(),
        ]);

        $employee = Employee::find($employee->id);

        $employee = self::addAllAttributes($employee);

        return $employee;
    }

}
