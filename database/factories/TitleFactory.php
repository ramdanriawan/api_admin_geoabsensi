<?php

namespace Database\Factories;

use App\Models\Dtos\TitleStoreDto;
use App\Models\Title;
use App\Services\ServiceImpl\TitleServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Title>
 */
class TitleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->title,
            'basic_salary' => fake()->numberBetween(5000000, 10000000),
            'penalty_per_late' => fake()->numberBetween(50, 100) * 1000,
            'meal_allowance_per_present' => fake()->numberBetween(50, 100) * 1000,
            'transport_allowance_per_present' => fake()->numberBetween(50, 100) * 1000,
            'overTime_pay_per_hours' => fake()->numberBetween(50, 100) * 1000,
        ];
    }

    public function createFromService($attributes = []): Title
    {
        return TitleServiceImpl::store(TitleStoreDto::fromJson([
            ... $this->definition(),
            ... $attributes
        ]));
    }
}
