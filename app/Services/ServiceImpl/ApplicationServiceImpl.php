<?php

namespace App\Services\ServiceImpl;

use App\Models\Dtos\ApplicationStoreDto;
use App\Models\Dtos\ApplicationUpdateDto;
use App\Models\Employee;
use App\Models\NotificationSetting;
use App\Models\Application;
use App\Services\JwtToken\JwtTokenService;
use App\Services\ApplicationService;
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

class ApplicationServiceImpl
{
    private static $withRelations = [];
    private static $withCount = [];
    public static $columnOrder = [
        'id',
        'version',
        'name',
        'phone',
        'email',
        'developer_name',
        'brand',
        'website',
        'release_date',
        'last_update',
        'terms_url',
        'privacy_policy_url',
        'maximum_radius_in_meters',
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

            $data = Application::limit($length);
        } else {

            $data = Application::limit($length)->offset($start);
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

    public static function store(ApplicationStoreDto $applicationStoreDto)
    {
        // kalau aktif maka matikan yang lain
        if ($applicationStoreDto->getIsActive()) {
            Application::where('id', '>', '0')->update(['is_active' => '0']);
        }

        $application = Application::create([
            'version' => $applicationStoreDto->getVersion(),
            'name' => $applicationStoreDto->getName(),
            'phone' => $applicationStoreDto->getPhone(),
            'email' => $applicationStoreDto->getEmail(),
            'developer_name' => $applicationStoreDto->getDeveloperName(),
            'brand' => $applicationStoreDto->getBrand(),
            'website' => $applicationStoreDto->getWebsite(),
            'release_date' => $applicationStoreDto->getReleaseDate(),
            'last_update' => $applicationStoreDto->getLastUpdate(),
            'terms_url' => $applicationStoreDto->getTermsUrl(),
            'privacy_policy_url' => $applicationStoreDto->getPrivacyPolicyUrl(),
            'maximum_radius_in_meters' => $applicationStoreDto->getMaximumRadiusInMeters(),
            'minimum_visit_in_minutes' => $applicationStoreDto->getMinimumVisitInMinutes(),
            'is_active' => $applicationStoreDto->getIsActive(),
        ]);


        $application = Application::find($application->id);

        $application = self::addAllAttributes($application);

        return $application;
    }

    public static function update(ApplicationUpdateDto $applicationUpdateDto)
    {
        // kalau aktif maka matikan yang lain
        if ($applicationUpdateDto->getIsActive()) {
            Application::where('id', '>', '0')->update(['is_active' => '0']);
        }

        $input = [
            'version' => $applicationUpdateDto->getVersion(),
            'name' => $applicationUpdateDto->getName(),
            'phone' => $applicationUpdateDto->getPhone(),
            'email' => $applicationUpdateDto->getEmail(),
            'developer_name' => $applicationUpdateDto->getDeveloperName(),
            'brand' => $applicationUpdateDto->getBrand(),
            'website' => $applicationUpdateDto->getWebsite(),
            'release_date' => $applicationUpdateDto->getReleaseDate(),
            'last_update' => $applicationUpdateDto->getLastUpdate(),
            'terms_url' => $applicationUpdateDto->getTermsUrl(),
            'privacy_policy_url' => $applicationUpdateDto->getPrivacyPolicyUrl(),
            'maximum_radius_in_meters' => $applicationUpdateDto->getMaximumRadiusInMeters(),
            'minimum_visit_in_minutes' => $applicationUpdateDto->getMinimumVisitInMinutes(),
            'is_active' => $applicationUpdateDto->getIsActive(),
        ];

        $application = Application::find($applicationUpdateDto->getId());

        $application->update($input);

        $application = self::addAllAttributes($application);

        return $application;
    }

    public static function delete(Application $application)
    {
        DB::transaction(function () use ($application) {

            $application->delete();
        });
    }

    public static function findOne($id)
    {

        $data = Application::with(self::$withRelations)->where(['id' => $id])->withCount(self::$withCount)->first();

        if(!$data) {
            return null;
        }

        $data = self::addAllAttributes($data);

        return $data;
    }

    // parameter application belum saya pakai
    public static function addAllAttributes(Application|Builder|Model|array $item): Application|Model|stdClass
    {
        if (is_array($item)) {
            $item = json_decode(json_encode($item));
        }

        if (!$item) {
            return null;
        }

        $item->isCanDelete = $item->is_active ? 0 : 1;


        $item->createdAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->created_at);
        $item->updatedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->updated_at);
        $item->deletedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->deleted_at);


        return $item;
    }

    public static function findActive()
    {
        $application = Application::where(['is_active' => true])->first();

        if(!$application) {
            return null;
        }

        return $application;
    }
}
