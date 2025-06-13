<?php

namespace Database\Factories;

use App\Models\Dtos\ShiftStoreDto;
use App\Models\Shift;
use App\Services\ServiceImpl\ShiftServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
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
            'start_time' => now()->setHour(8)->format('H:i'),
            'end_time' => now()->setHour(16)->format('H:i'),
            'description' => fake()->words(20, true)
        ];
    }

    public function createFromService($attributes = []): Shift
    {
        return ShiftServiceImpl::store(ShiftStoreDto::fromJson([
            ...$this->definition(),
            ...$attributes,
        ]));
    }
}
