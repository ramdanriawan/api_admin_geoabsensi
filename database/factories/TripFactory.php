<?php

namespace Database\Factories;

use App\Models\Trip;
use App\Services\ServiceImpl\TripServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_date'        => now()->addDays(1)->toDateString(),
            'end_date'          => now()->addDays(10)->toDateString(),
            'date'              => date("Y-m-d"),
            'lat'              => fake()->latitude(),
            'lng'              => fake()->longitude(),
            'picture'              => UploadedFile::fake()->create('picture.png', 5048),
        ];
    }

    public function createFromService($attributes = []): Trip
    {
        $employeeId = $attributes['employee_id'];
        $tripTypeId = $attributes['trip_type_id'];

        return TripServiceImpl::store(
            $employeeId,
            $tripTypeId,
            $this->definition()['start_date'],
            $this->definition()['end_date'],
            $this->definition()['lat'],
            $this->definition()['lng'],
            $this->definition()['picture'],
        );
    }
}
