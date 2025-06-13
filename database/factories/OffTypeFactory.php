<?php

namespace Database\Factories;

use App\Models\Dtos\OffTypeStoreDto;
use App\Models\OffType;
use App\Services\ServiceImpl\OffTypeServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OffType>
 */
class OffTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name
        ];
    }

    public function createFromService($attributes = []): OffType
    {
        return OffTypeServiceImpl::store(OffTypeStoreDto::fromJson([
            ...$this->definition(),
            ...$attributes
        ]));
    }
}
