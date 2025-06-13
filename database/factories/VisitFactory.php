<?php

namespace Database\Factories;

use App\Models\Dtos\VisitTypeStoreDto;
use App\Models\Visit;
use App\Models\VisitType;
use App\Services\ServiceImpl\ApplicationServiceImpl;
use App\Services\ServiceImpl\VisitServiceImpl;
use App\Services\ServiceImpl\VisitTypeServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use RamdanRiawan\Geolocator;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visit>
 */
class VisitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function createFromService($attributes = []): Visit
    {
        $application = ApplicationServiceImpl::findActive();

        $coords = Geolocator::generateNearbyCoordinates($application->lat, $application->lng, 30);
        $picture = UploadedFile::fake()->create('picture.jpg', 5048);

        $user = $attributes['user'];
        $visitType = $attributes['visitType'];
        $lat = $coords['latitude'];
        $lng = $coords['longitude'];

        return VisitServiceImpl::store(
            $user, $picture, $lat, $lng, $visitType->id,
        );
    }
}
