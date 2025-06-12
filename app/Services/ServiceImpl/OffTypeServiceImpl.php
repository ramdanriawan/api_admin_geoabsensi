<?php

namespace App\Services\ServiceImpl;

use App\Models\Dtos\OffTypeStoreDto;
use App\Models\Dtos\OffTypeUpdateDto;
use App\Models\Employee;
use App\Models\NotificationSetting;
use App\Models\OffType;
use App\Services\JwtToken\JwtTokenService;
use App\Services\OffTypeService;
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

class OffTypeServiceImpl
{
    private static $withRelations = [];
    private static $withCount = ['employee_offDays'];
    public static $columnOrder = [
        'id',
        'name',
        'created_at',
        'updated_at',
    ];

    public static function findAllNoFilter()
    {
        $offType = OffType::with(self::$withRelations)->withCount(self::$withCount)->get();

        foreach ($offType as $item) {
            $item = self::addAllAttributes($item);
        }

        return $offType;
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

            $data = OffType::limit($length);
        } else {

            $data = OffType::limit($length)->offset($start);
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

    public static function store(OffTypeStoreDto $offTypeStoreDto)
    {

        $offType = OffType::create([
            'name' => $offTypeStoreDto->getName(),
        ]);

        $offType = OffType::find($offType->id);

        $offType = self::addAllAttributes($offType);

        return $offType;
    }

    public static function update(OffTypeUpdateDto $offTypeUpdateDto)
    {
        $input = [
            'name' => $offTypeUpdateDto->getName(),
        ];

        $offType = OffType::find($offTypeUpdateDto->getId());

        $offType->update($input);

        $offType = self::addAllAttributes($offType);

        return $offType;
    }

    public static function delete(OffType $offType)
    {
        DB::transaction(function () use ($offType) {

            $offType->delete();
        });
    }

    public static function findOne($id)
    {

        $data = OffType::with(self::$withRelations)->where(['id' => $id])->withCount(self::$withCount)->first();

        $data = self::addAllAttributes($data);

        return $data;
    }

    // parameter offType belum saya pakai
    public static function addAllAttributes(OffType|Builder|Model|array $item): OffType|Model|stdClass
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
        $offType = OffType::where([
            'name' => $name,
        ])->first();

        if(!$offType) {
            return null;
        }

        $offType = self::addAllAttributes($offType);

        return $offType;
    }

    public static function findAllByEmployees($limit = 10)
    {
        $offType = OffType::has('employee_offDays')->limit(100)->get();

        foreach ($offType as $item) {
            $item = self::addAllAttributes($item);
        }

        return $offType;
    }
}
