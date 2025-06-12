<?php

namespace App\Services\ServiceImpl;

use App\Models\Dtos\ShiftStoreDto;
use App\Models\Dtos\ShiftUpdateDto;
use App\Models\Employee;
use App\Models\NotificationSetting;
use App\Models\Shift;
use App\Services\JwtToken\JwtTokenService;
use App\Services\ShiftService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Facade as Avatar;
use stdClass;
use RamdanRiawan\DateTime;

class ShiftServiceImpl
{
    private static $withRelations = [];
    private static $withCount = ['user_shifts'];
    public static $columnOrder = [
        'id',
        'name',
        'start_time',
        'end_time',
        'created_at',
        'updated_at',
    ];

    public static function findAllNoFilter()
    {
        $shift = Shift::with(self::$withRelations)->withCount(self::$withCount)->get();

        foreach ($shift as $item) {
            $item = self::addAllAttributes($item);
        }

        return $shift;
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

            $data = Shift::limit($length);
        } else {

            $data = Shift::limit($length)->offset($start);
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

    public static function store(ShiftStoreDto $shiftStoreDto)
    {

        $shift = Shift::create([
            'name' => $shiftStoreDto->getName(),
            'start_time' => $shiftStoreDto->getStartTime(),
            'end_time' => $shiftStoreDto->getEndTime(),
        ]);

        $shift = Shift::find($shift->id);

        $shift = self::addAllAttributes($shift);

        return $shift;
    }

    public static function update(ShiftUpdateDto $shiftUpdateDto)
    {
        $input = [
            'name' => $shiftUpdateDto->getName(),
            'start_time' => $shiftUpdateDto->getStartTime(),
            'end_time' => $shiftUpdateDto->getEndTime(),
        ];

        $shift = Shift::find($shiftUpdateDto->getId());

        $shift->update($input);

        $shift = self::addAllAttributes($shift);

        return $shift;
    }

    public static function delete(Shift $shift)
    {
        DB::transaction(function () use ($shift) {

            $shift->delete();
        });
    }

    public static function findOne($id)
    {

        $data = Shift::with(self::$withRelations)->where(['id' => $id])->withCount(self::$withCount)->first();

        if(!$data) {
            return null;
        }

        $data = self::addAllAttributes($data);

        return $data;
    }

    // parameter shift belum saya pakai
    public static function addAllAttributes(Shift|Builder|Model|array $item): Shift|Model|stdClass
    {
        if (is_array($item)) {
            $item = json_decode(json_encode($item));
        }

        if (!$item) {
            return null;
        }

        $item->isCanDelete = true;

        $item->startTimeDateTime = DateTime::getDetailFlexible($item->start_time);
        $item->endTimeDateTime = DateTime::getDetailFlexible($item->end_time);
        $item->createdAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->created_at);
        $item->updatedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->updated_at);
        $item->deletedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->deleted_at);


        return $item;
    }

    public static function findByName($name)
    {
        $shift = Shift::where([
            'name' => $name,
        ])->first();

        if(!$shift) {
            return null;
        }

        $shift = self::addAllAttributes($shift);

        return $shift;
    }

    public static function findAllByEmployees($limit = 10)
    {
        $shift = Shift::has('employees')->limit(100)->get();

        foreach ($shift as $item) {
            $item = self::addAllAttributes($item);
        }

        return $shift;
    }
}
