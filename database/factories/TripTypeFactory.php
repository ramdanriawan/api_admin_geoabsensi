<?php

namespace Database\Factories;

use App\Models\Dtos\TripTypeStoreDto;
use App\Models\TripType;
use App\Services\ServiceImpl\TripServiceImpl;
use App\Services\ServiceImpl\TripTypeServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TripType>
 */
class TripTypeFactory extends Factory
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
            'name' => $this->faker->name,
        ];
    }

    public function createFromService($attributes = []): TripType
    {


        return TripTypeServiceImpl::store(TripTypeStoreDto::fromJson([
            ...$this->definition(),
            ...$attributes,
        ]));
    }
}
