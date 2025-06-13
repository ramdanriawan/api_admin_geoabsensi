<?php

namespace Database\Factories;

use App\Models\Dtos\PaySlipStoreDto;
use App\Models\PaySlip;
use App\Services\ServiceImpl\PaySlipServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaySlip>
 */
class PaySlipFactory extends Factory
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

    public function createFromService($attributes = []): PaySlip
    {
        return PaySlipServiceImpl::store(PaySlipStoreDto::fromJson([
            ...$this->definition(),
            'period_start' => now()->addDays(-30)->toDateString(),
            'period_end' => now()->toDateString(),
            'date' => date("Y-m-d"),
            'basic_salary' => fake()->numberBetween(30000, 100000),
            'meal_allowance' => fake()->numberBetween(30000, 100000),
            'transport_allowance' => fake()->numberBetween(30000, 100000),
            'overTime_pay' => fake()->numberBetween(30000, 100000),
            'bonus' => fake()->numberBetween(200000, 300000),
            'deduction_bpjs_kesehatan' => fake()->numberBetween(200000, 500000),
            'deduction_bpjs_ketenagakerjaan' => fake()->numberBetween(200000, 400000),
            'deduction_pph21' => fake()->numberBetween(300000, 1000000),
            'deduction_late_or_leave' => fake()->numberBetween(30000, 100000),
            'note' => fake()->words(20, true),
            'status' => 'agreed',
            ...$attributes
        ]));
    }
}
