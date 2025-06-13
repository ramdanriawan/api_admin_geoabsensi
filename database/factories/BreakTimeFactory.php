<?php

namespace Database\Factories;

use App\Models\BreakTime;
use App\Services\ServiceImpl\BreakTimeServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BreakTime>
 */
class BreakTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

        ];
    }

    public function createFromService($attributes = []): BreakTime
    {
        $user = $attributes['user'];
        $breakType = $attributes['breakType'];

        return BreakTimeServiceImpl::store($user, $breakType);
    }
}
