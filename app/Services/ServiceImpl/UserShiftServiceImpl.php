<?php

namespace App\Services\ServiceImpl;

use App\Models\Dtos\UserShiftStoreDto;
use App\Models\Dtos\UserShiftUpdateDto;
use App\Models\UserShift;
use App\Models\Shift;
use App\Services\UserShiftService;
use Illuminate\Support\Facades\DB;
use RamdanRiawan\DateTime;

class UserShiftServiceImpl
{
    private static $withRelations = [
        'user',
        'shift',
    ];
    private static $withCount = [];
    public static $columnOrder = [
        'id',
        'user_id',
        'shift_id',
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

            $data = UserShift::limit($length);
        } else {

            $data = UserShift::limit($length)->offset($start);
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
        $userShift = UserShift::with(self::$withRelations)->where(['user_id' => $userId])->first();

        if (!$userShift) {
            return null;
        }

        $userShift = self::addAllAttributes($userShift);

        return $userShift;
    }


    public static function addAllAttributes(UserShift $item)
    {
        if ($item->user) {

            $item->user = UserServiceImpl::addAllAttributes($item->user);
        }

        if ($item->shift) {
            $item->shift = ShiftServiceImpl::addAllAttributes($item->shift);
        }

        if (!$item) {
            return null;
        }

        $item->createdAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->created_at);
        $item->updatedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->updated_at);
        $item->deletedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->deleted_at);

        $item->isCanDelete = true;

        return $item;
    }


    public static function findOne($id)
    {
        $userShift = UserShift::with(self::$withRelations)->where(['id' => $id])->withCount(self::$withCount)->first();

        if(!$userShift) {
            return null;
        }

        $userShift = self::addAllAttributes($userShift);

        return $userShift;
    }


    public static function delete(UserShift $userShift)
    {
        DB::transaction(function () use ($userShift) {

            $userShift->delete();
        });
    }


    public static function update(UserShiftUpdateDto $userShiftUpdateDto)
    {
        $input = [
            'shift_id' => $userShiftUpdateDto->getShiftId(),
            'user_id' => $userShiftUpdateDto->getUserId(),
        ];

        $userShift = UserShift::find($userShiftUpdateDto->getId());

        $userShift->update($input);

        $userShift = self::addAllAttributes($userShift);

        return $userShift;
    }


    public static function store(UserShiftStoreDto $userShiftStoreDto)
    {

        $userShift = UserShift::create([
            'shift_id' => $userShiftStoreDto->getShiftId(),
            'user_id' => $userShiftStoreDto->getUserId(),
        ]);

        $userShift = UserShift::find($userShift->id);

        $userShift = self::addAllAttributes($userShift);

        return $userShift;
    }

}
