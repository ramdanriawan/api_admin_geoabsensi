<?php

namespace App\Services\ServiceImpl;

use App\Models\Dtos\MotivationalStoreDto;
use App\Models\Dtos\MotivationalUpdateDto;
use App\Models\Employee;
use App\Models\NotificationSetting;
use App\Models\Motivational;
use App\Services\JwtToken\JwtTokenService;
use App\Services\MotivationalService;
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

class MotivationalServiceImpl
{
    private static $withRelations = [];
    private static $withCount = [];
    public static $columnOrder = [
        'id',
        'word',
        'created_at',
        'updated_at',
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

            $data = Motivational::limit($length);
        } else {

            $data = Motivational::limit($length)->offset($start);
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
    public static function store(MotivationalStoreDto $motivationalStoreDto)
    {

        $motivational = Motivational::create([
            'word' => $motivationalStoreDto->getWord(),
        ]);

        $motivational = Motivational::find($motivational->id);

        $motivational = self::addAllAttributes($motivational);

        return $motivational;
    }

    public static function update(MotivationalUpdateDto $motivationalUpdateDto)
    {
        $input = [
            'word' => $motivationalUpdateDto->getWord(),
        ];

        $motivational = Motivational::find($motivationalUpdateDto->getId());

        $motivational->update($input);

        $motivational = self::addAllAttributes($motivational);

        return $motivational;
    }

    public static function delete(Motivational $motivational)
    {
        DB::transaction(function () use ($motivational) {

            $motivational->delete();
        });
    }

    public static function findOne($id)
    {

        $data = Motivational::with(self::$withRelations)->where(['id' => $id])->withCount(self::$withCount)->first();

        if(!$data) {
            return null;
        }

        $data = self::addAllAttributes($data);

        return $data;
    }

    // parameter motivational belum saya pakai
    public static function addAllAttributes(Motivational|Builder|Model|array $item): Motivational|Model|stdClass
    {
        if (is_array($item)) {
            $item = json_decode(json_encode($item));
        }

        if (!$item) {
            return null;
        }

        $item->isCanDelete = true;

        $item->createdAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->created_at);
        $item->updatedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->updated_at);
        $item->deletedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->deleted_at);


        return $item;
    }
}
