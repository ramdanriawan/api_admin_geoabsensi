<?php
namespace App\Services\ServiceImpl;

use App\Models\Organization;
use App\Models\Trip;
use App\Models\TripAttendance;
use App\Models\User;
use App\Services\TripService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use RamdanRiawan\DateTime;
use RamdanRiawan\Geolocator;

class TripAttendanceServiceImpl implements TripService
{

    public static function store(
        $tripId,
        $lat,
        $lng,
        UploadedFile $picture,
    ) {
        $organization = Organization::where(['is_active' => 1])->first();

        if(!$organization) {
            return null;
        }

        $distanceInKilometers = Geolocator::distanceBetween($organization->lat, $organization->lng, $lat, $lng);
        $picture = $picture->store('images', 'public');

        $tripAttendance = TripAttendance::create([
            'trip_id'       => $tripId,
            'check_in_time' => date("H:i:s"),
            'picture' => $picture,
            'lat' => $lat,
            'lng' => $lng,
            'distance_in_kilometers' => $distanceInKilometers,
        ]);

        // buat absensinya
        $tripAttendance = TripAttendance::find($tripAttendance->id);

        $tripAttendance = self::addAllAttributes($tripAttendance);

        return $tripAttendance;
    }

    public static function addAllAttributes(TripAttendance | Model $item)
    {
        $item->pictureUrl = url($item->picture);


        $item->created_at_human = Carbon::parse($item->created_at)->diffForHumans();
        $item->updated_at_human = Carbon::parse($item->updated_at)->diffForHumans();
        $item->deleted_at_human = Carbon::parse($item->deleted_at)->diffForHumans();

        $item->createdAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->created_at);
        $item->updatedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->updated_at);
        $item->deletedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->deleted_at);

        $item->startDateDateTime = DateTime::getDetail("Y-m-d", $item->start_date);
        $item->endDateDateTime   = DateTime::getDetail("Y-m-d", $item->end_date);
        $item->dateDateTime      = DateTime::getDetail("Y-m-d", $item->date);

        $item->isCanEdit = false;
        $item->isCanDelete = false;
        $item->isCanShow = true;

        return $item;
    }
}
