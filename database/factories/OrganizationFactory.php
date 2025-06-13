<?php

namespace Database\Factories;

use App\Models\Dtos\OrganizationStoreDto;
use App\Services\ServiceImpl\OrganizationServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
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

    public function createFromService($attributes = [])
    {
        return OrganizationServiceImpl::store(OrganizationStoreDto::fromJson([
            ...$this->definition(),
            'name' => fake()->name(),
            'logo' => UploadedFile::fake()->create('logo.png', 5048),
            'description' => fake()->words(100, true),
            'lat' => fake()->latitude,
            'lng' => fake()->longitude,
            'is_active' => fake()->numberBetween(0,1)
        ]));
    }
}
