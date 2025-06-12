<?php

namespace App\Services\ServiceImpl;

use App\Models\Dtos\TripTypeStoreDto;
use App\Models\Dtos\TripTypeUpdateDto;
use App\Models\Employee;
use App\Models\NotificationSetting;
use App\Models\TripType;
use App\Services\JwtToken\JwtTokenService;
use App\Services\TripTypeService;
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

class TripTypeServiceImpl
{
    private static $withRelations = [];
    private static $withCount = ['trips'];
    public static $columnOrder = [
        'id',
        'name',
        'created_at',
        'updated_at',
    ];

    public static function findAllNoFilter()
    {
        $tripType = TripType::with(self::$withRelations)->withCount(self::$withCount)->get();

        foreach ($tripType as $item) {
            $item = self::addAllAttributes($item);
        }

        return $tripType;
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

            $data = TripType::limit($length);
        } else {

            $data = TripType::limit($length)->offset($start);
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

    public static function store(TripTypeStoreDto $tripTypeStoreDto)
    {

        $tripType = TripType::create([
            'name' => $tripTypeStoreDto->getName(),
        ]);

        $tripType = TripType::find($tripType->id);

        $tripType = self::addAllAttributes($tripType);

        return $tripType;
    }

    public static function update(TripTypeUpdateDto $tripTypeUpdateDto)
    {
        $input = [
            'name' => $tripTypeUpdateDto->getName(),
        ];

        $tripType = TripType::find($tripTypeUpdateDto->getId());

        if(!$tripType) {
            return null;
        }

        $tripType->update($input);

        $tripType = self::addAllAttributes($tripType);

        return $tripType;
    }

    public static function delete(TripType $tripType)
    {
        DB::transaction(function () use ($tripType) {

            $tripType->delete();
        });
    }

    public static function findOne($id)
    {

        $data = TripType::with(self::$withRelations)->where(['id' => $id])->withCount(self::$withCount)->first();

        $data = self::addAllAttributes($data);

        return $data;
    }

    // parameter tripType belum saya pakai
    public static function addAllAttributes(TripType|Builder|Model|array $item): TripType|Model|stdClass
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
        $tripType = TripType::where([
            'name' => $name,
        ])->first();

        if(!$tripType) {
            return null;
        }

        $tripType = self::addAllAttributes($tripType);

        return $tripType;
    }
}
