<?php

namespace App\Services\ServiceImpl;

use App\Models\Dtos\OrganizationStoreDto;
use App\Models\Dtos\OrganizationUpdateDto;
use App\Models\Employee;
use App\Models\NotificationSetting;
use App\Models\Organization;
use App\Services\JwtToken\JwtTokenService;
use App\Services\OrganizationService;
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

class OrganizationServiceImpl
{
    private static $withRelations = [];
    private static $withCount = [];
    public static $columnOrder = [
        'id',
        'name',
        'logo',
        'description',
        'lat',
        'lng',
        'is_active',
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

            $data = Organization::limit($length);
        } else {

            $data = Organization::limit($length)->offset($start);
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

    public static function store(OrganizationStoreDto $organizationStoreDto)
    {
        $logo = null;
        if ($organizationStoreDto->getLogo()) {

            $logo = $organizationStoreDto->getLogo()->store('images', 'public');
        }

        $organization = Organization::create([
            'name' => $organizationStoreDto->getName(),
            'logo' => $logo,
            'description' => $organizationStoreDto->getDescription(),
            'lat' => $organizationStoreDto->getLat(),
            'lng' => $organizationStoreDto->getLng(),
            'is_active' => $organizationStoreDto->getIsActive(),
        ]);

        $organization = Organization::find($organization->id);

        if ($organizationStoreDto->getIsActive()) {

            Organization::where('id', '>', '0')->update([
                'is_active' => 0
            ]);

            $organization = Organization::find($organization->id);

            $organization->update([
                'is_active' => true,
            ]);
        }

        $organization = self::addAllAttributes($organization);

        return $organization;
    }

    public static function update(OrganizationUpdateDto $organizationUpdateDto)
    {
        $logo = null;
        if ($organizationUpdateDto->getLogo()) {

            $logo = $organizationUpdateDto->getLogo()->store('images', 'public');
        }

        $input = [
            'name' => $organizationUpdateDto->getName(),
            'logo' => $logo,
            'description' => $organizationUpdateDto->getDescription(),
            'lat' => $organizationUpdateDto->getLat(),
            'lng' => $organizationUpdateDto->getLng(),
            'is_active' => $organizationUpdateDto->getIsActive(),
        ];

        // kalo g ada logo maka g usah d update
        if (!$organizationUpdateDto->getLogo()) {
            unset($input['logo']);
        }

        if ($organizationUpdateDto->getIsActive()) {
            Organization::where('id', '>', '0')->update([
                'is_active' => 0
            ]);
        }

        $organization = Organization::find($organizationUpdateDto->getId());

        $organization->update($input);

        $organization = self::addAllAttributes($organization);

        return $organization;
    }

    public static function delete(Organization $organization)
    {
        DB::transaction(function () use ($organization) {

            $organization->delete();
        });
    }

    public static function findOne($id)
    {

        $data = Organization::with(self::$withRelations)->where(['id' => $id])->withCount(self::$withCount)->first();

        if(!$data){
            return null;
        }

        $data = self::addAllAttributes($data);


        return $data;
    }

    public static function findActive()
    {

        $data = Organization::with(self::$withRelations)->where(['is_active' => 1])->withCount(self::$withCount)->first();

        if(!$data) {
            return null;
        }

        $data = self::addAllAttributes($data);

        return $data;
    }

    // parameter organization belum saya pakai
    public static function addAllAttributes(Organization|Builder|Model|array $item): Organization|Model|stdClass|null
    {
        if (is_array($item)) {
            $item = json_decode(json_encode($item));
        }

        if (!$item) {
            return null;
        }

        $item->isCanDelete = $item->is_active ? 0 : 1;


        $item->logoUrl = null;
        if ($item->logo != null) {
            $item->logoUrl = url(Storage::url($item->logo));
        } else {
            $item->logoUrl = Avatar::create($item->name)->toBase64();
        }

        $item->logoHtml = "<style>
table tr td img {
    all: initial;
}
</style> <img src='{$item->logoUrl}'
    style='display:inline-block; width:60px !important; height:60px !important;
    border-radius:50% !important; object-fit:cover !important; overflow:hidden;'>";

        $item->createdAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->created_at);
        $item->updatedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->updated_at);
        $item->deletedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->deleted_at);


        return $item;
    }
}
