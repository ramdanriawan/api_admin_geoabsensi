<?php

namespace App\Services\ServiceImpl;

use App\Models\Application;
use App\Models\Attendance;
use App\Models\Organization;
use App\Models\User;
use App\Models\Visit;
use App\Services\VisitService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RamdanRiawan\DateTime;
use RamdanRiawan\Geolocator;

class VisitServiceImpl implements VisitService
{

    private static $withRelations = ['user', 'visit_type'];
    private static $withCount = [];
    public static $columnOrder = [
        'id',
        'user_id',
        'visit_type_id',
        'check_in_time',
        'date',
        'status',
        'picture',
        'lat',
        'lng',
        'distance_in_kilometers',
        'created_at',
        'updated_at',
        'deleted_at',
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

            $data = Visit::limit($length);
        } else {

            $data = Visit::limit($length)->offset($start);
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

    public static function findAllByUserId(User $user, $start = 0, $end = 100)
    {
        $trip = Visit::orderByDesc('id')->where(['user_id' => $user->id])->with(['visit_type'])->offset($start)->limit($end)->get();

        foreach ($trip as $key => $item) {
            $trip[$key] = self::addAllAttributes($item);
        }

        return $trip;
    }

    public static function getDistanceFromOrganization($lat, $lng)
    {
        $organization = Organization::where(['is_active' => 1])->first();

        $distanceInMeters = Geolocator::distanceBetween($lat, $lng, $organization->lat, $organization->lng);

        return $distanceInMeters;
    }

    public static function addAllAttributes(Visit|Model $item)
    {
        $application = ApplicationServiceImpl::findActive();

        if(!$application) {
            return null;
        }

        $item->pictureUrl = url($item->picture);

        $item->checkInTimeDateTime = DateTime::getDetail($item->check_in_time);
        $item->dateDateTime = DateTime::getDetail($item->date);

        $item->isTooFaster = abs(Carbon::createFromFormat("H:i:s", $item->check_in_time)->diffInMinutes(now())) <= $application->minimum_visit_in_minutes;

        $item->isPresent = $item->status == "Present";
        $item->isCheckIn = $item->check_in_time != null;


        $item->isCanDelete = false;
        $item->isCanEdit = false;
        $item->isCanShow = true;

        $item->dateDateTime = DateTime::getDetail('Y-m-d', $item->date);

        $item->created_at_human = Carbon::parse($item->created_at)->diffForHumans();
        $item->updated_at_human = Carbon::parse($item->updated_at)->diffForHumans();
        $item->deleted_at_human = Carbon::parse($item->deleted_at)->diffForHumans();

        $item->createdAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->created_at);
        $item->updatedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->updated_at);
        $item->deletedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->deleted_at);


        return $item;
    }

    public static function store(User $user, UploadedFile $picture, $lat, $lng, $visitTypeId)
    {
        $picturePath = $picture->store('images', 'public');

        $distanceInKilometers = self::getDistanceFromOrganization($lat, $lng);

        $visit = Visit::create([
            'user_id' => $user->id,
            'visit_type_id' => $visitTypeId,
            'check_in_time' => date('H:i:s'),
            'date' => date('Y-m-d'),
            'picture' => Storage::url($picturePath),
            'distance_in_kilometers' => round($distanceInKilometers, 2),
            'lat' => $lat,
            'lng' => $lng,
        ]);

        $visit = Visit::find($visit->id);
        $visit = self::addAllAttributes($visit);

        return $visit;
    }

    public static function findByUserId(int $userId)
    {
        $visit = Visit::orderByDesc('id')->where(['user_id' => $userId, 'date' => date('Y-m-d')])->first();

        if (!$visit) {
            return null;
        }

        $visit = self::addAllAttributes($visit);

        return $visit;
    }
}
