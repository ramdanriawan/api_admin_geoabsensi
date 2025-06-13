<?php

namespace Database\Factories;

use App\Models\Dtos\VisitTypeStoreDto;
use App\Models\VisitType;
use App\Services\ServiceImpl\ApplicationServiceImpl;
use App\Services\ServiceImpl\OrganizationServiceImpl;
use App\Services\ServiceImpl\VisitTypeServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use RamdanRiawan\Geolocator;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VisitType>
 */
class VisitTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' =>  $this->faker->unique()->word,
        ];
    }

    public function createFromService($attributes = []): VisitType
    {
        $organization = OrganizationServiceImpl::findActive();

        $coords = Geolocator::generateNearbyCoordinates($organization->lat, $organization->lng, 30);

        return VisitTypeServiceImpl::store(VisitTypeStoreDto::fromJson([
            ...$this->definition(),
            'lat' => $coords['latitude'],
            'lng' => $coords['longitude'],
            ...$attributes,
        ]));
    }
}
