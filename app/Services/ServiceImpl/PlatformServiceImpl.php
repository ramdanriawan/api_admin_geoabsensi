<?php

namespace App\Services\ServiceImpl;

use App\Models\Dtos\PlatformStoreDto;
use App\Models\Dtos\PlatformUpdateDto;
use App\Models\Employee;
use App\Models\NotificationSetting;
use App\Models\Platform;
use App\Services\JwtToken\JwtTokenService;
use App\Services\PlatformService;
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

class PlatformServiceImpl
{
    private static $withRelations = [];
    private static $withCount = [];
    public static $columnOrder = [
        'id',
        'application_id',
        'name',
        'created_at',
        'updated_at',
    ];

    public static function findAllNoFilter()
    {
        $platform = Platform::with(self::$withRelations)->withCount(self::$withCount)->get();

        foreach ($platform as $item) {
            $item = self::addAllAttributes($item);
        }

        return $platform;
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

            $data = Platform::limit($length);
        } else {

            $data = Platform::limit($length)->offset($start);
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

    public static function store(PlatformStoreDto $platformStoreDto)
    {

        $platform = Platform::create([
            'application_id' => $platformStoreDto->getApplicationId(),
            'name' => $platformStoreDto->getName(),
        ]);

        $platform = Platform::find($platform->id);

        $platform = self::addAllAttributes($platform);

        return $platform;
    }

    public static function update(PlatformUpdateDto $platformUpdateDto)
    {
        $input = [
            'id' => $platformUpdateDto->getId(),
            'application_id' => $platformUpdateDto->getApplicationId(),
            'name' => $platformUpdateDto->getName(),
        ];

        $platform = Platform::find($platformUpdateDto->getId());

        $platform->update($input);

        $platform = self::addAllAttributes($platform);

        return $platform;
    }

    public static function delete(Platform $platform)
    {
        DB::transaction(function () use ($platform) {

            $platform->delete();
        });
    }

    public static function findOne($id)
    {

        $data = Platform::with(self::$withRelations)->where(['id' => $id])->withCount(self::$withCount)->first();

        $data = self::addAllAttributes($data);

        return $data;
    }

    // parameter platform belum saya pakai
    public static function addAllAttributes(Platform|Builder|Model|array $item): Platform|Model|stdClass
    {
        if (is_array($item)) {
            $item = json_decode(json_encode($item));
        }

        if (!$item) {
            return null;
        }

        $item->isCanDelete = true;
        $item->isCanEdit = true;
        $item->isCanShow = true;

        $item->createdAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->created_at);
        $item->updatedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->updated_at);
        $item->deletedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->deleted_at);

        return $item;
    }

    public static function findByName($name)
    {
        $platform = Platform::where([
            'name' => $name,
        ])->first();

        if(!$platform) {
            return null;
        }

        $platform = self::addAllAttributes($platform);

        return $platform;
    }
}
