<?php

namespace Database\Factories;

use App\Models\OffDay;
use App\Services\ServiceImpl\OffDayServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OffDay>
 */
class OffDayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date'   => now()->addDays(12)->toDateString(),
        ];
    }

    public function createFromService($attributes = []):  OffDay
    {
        $employeeId = $attributes['employee_id'];
        $offTypeId = $attributes['off_type_id'];

        return OffDayServiceImpl::store(
            $employeeId,
            $offTypeId,
            $this->definition()['start_date'],
            $this->definition()['end_date']
        );
    }
}
