<?php

namespace Database\Factories;

use App\Models\Dtos\EmployeeStoreDto;
use App\Models\Employee;
use App\Services\ServiceImpl\EmployeeServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
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

    public function createFromService($attributes = []): Employee
    {
        return EmployeeServiceImpl::store(EmployeeStoreDto::fromJson([
            ...$attributes
        ]));
    }
}
