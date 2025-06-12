<?php

namespace App\Services\ServiceImpl;

use App\Models\Dtos\TitleStoreDto;
use App\Models\Dtos\TitleUpdateDto;
use App\Models\Employee;
use App\Models\NotificationSetting;
use App\Models\Title;
use App\Services\JwtToken\JwtTokenService;
use App\Services\TitleService;
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
use RamdanRiawan\Accounting;
use stdClass;
use RamdanRiawan\DateTime;

class TitleServiceImpl
{
    private static $withRelations = [];
    private static $withCount = ['employees'];
    public static $columnOrder = [
        'id',
        'name',
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

            $data = Title::limit($length);
        } else {

            $data = Title::limit($length)->offset($start);
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

    public static function store(TitleStoreDto $titleStoreDto)
    {

        $title = Title::create([
            'name' => $titleStoreDto->getName(),
            'basic_salary' => $titleStoreDto->getBasicSalary(),
            'penalty_per_late' => $titleStoreDto->getPenaltyPerLate(),
            'meal_allowance_per_present' => $titleStoreDto->getMealAllowancePerPresent(),
            'transport_allowance_per_present' => $titleStoreDto->getTransportAllowancePerPresent(),
            'overTime_pay_per_hours' => $titleStoreDto->getOverTimePayPerHours(),
        ]);

        $title = Title::find($title->id);

        $title = self::addAllAttributes($title);

        return $title;
    }

    public static function update(TitleUpdateDto $titleUpdateDto)
    {
        $input = [
            'name' => $titleUpdateDto->getName(),
            'basic_salary' => $titleUpdateDto->getBasicSalary(),
            'penalty_per_late' => $titleUpdateDto->getPenaltyPerLate(),
            'meal_allowance_per_present' => $titleUpdateDto->getMealAllowancePerPresent(),
            'transport_allowance_per_present' => $titleUpdateDto->getTransportAllowancePerPresent(),
            'overTime_pay_per_hours' => $titleUpdateDto->getOverTimePayPerHours(),
        ];

        $title = Title::find($titleUpdateDto->getId());

        $title->update($input);

        $title = self::addAllAttributes($title);

        return $title;
    }

    public static function delete(Title $title)
    {
        DB::transaction(function () use ($title) {

            $title->delete();
        });
    }

    public static function findOne($id)
    {

        $data = Title::with(self::$withRelations)->where(['id' => $id])->withCount(self::$withCount)->first();

        if(!$data) {
            return null;
        }

        $data = self::addAllAttributes($data);

        return $data;
    }

    // parameter title belum saya pakai
    public static function addAllAttributes(Title|Builder|Model|array $item): Title|Model|stdClass
    {
        if (is_array($item)) {
            $item = json_decode(json_encode($item));
        }

        if (!$item) {
            return null;
        }

        $item->basicSalaryString = Accounting::formatRupiah($item->basic_salary);
        $item->penaltyPerLateString = Accounting::formatRupiah($item->penalty_per_late);
        $item->mealAllowancePerPresentString = Accounting::formatRupiah($item->meal_allowance_per_present);
        $item->transportAllowancePerPresentString = Accounting::formatRupiah($item->transport_allowance_per_present);
        $item->overTimePayPerHoursString = Accounting::formatRupiah($item->overTime_pay_per_hours);

        $item->isCanDelete = true;

        $item->createdAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->created_at);
        $item->updatedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->updated_at);
        $item->deletedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->deleted_at);


        return $item;
    }

    public static function findByName($name)
    {
        $title = Title::where([
            'name' => $name,
        ])->first();

        if (!$title) {
            return null;
        }

        $title = self::addAllAttributes($title);

        return $title;
    }

    public static function findAllByEmployees($limit = 10)
    {
        $title = Title::has('employees')->limit(100)->get();

        foreach ($title as $item) {
            $item = self::addAllAttributes($item);
        }

        return $title;
    }
}
