<?php

namespace Database\Factories;

use App\Models\BreakTime;
use App\Models\OverTime;
use App\Services\ServiceImpl\OverTimeServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OverTime>
 */
class OverTimeFactory extends Factory
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

    public function createFromService($attributes = []): OverTime
    {
        $user = $attributes['user'];
        $overType = $attributes['overType'];

        return OverTimeServiceImpl::store($user, $overType);
    }
}
