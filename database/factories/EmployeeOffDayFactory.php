<?php

namespace Database\Factories;

use App\Models\Dtos\EmployeeOffDayStoreDto;
use App\Models\EmployeeOffDay;
use App\Services\ServiceImpl\EmployeeOffDayServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeOffDay>
 */
class EmployeeOffDayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quota' => fake()->numberBetween(1, 10),
        ];
    }

    public function createFromService($attributes = []): EmployeeOffDay
    {
        return EmployeeOffDayServiceImpl::store(EmployeeOffDayStoreDto::fromJson([
            ...$this->definition(),
            ...$attributes,
        ]));
    }
}
