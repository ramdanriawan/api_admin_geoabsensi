<?php

namespace Database\Factories;

use App\Models\Dtos\UserShiftStoreDto;
use App\Models\UserShift;
use App\Services\ServiceImpl\UserShiftServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserShift>
 */
class UserShiftFactory extends Factory
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

    public function createFromService($attributes = []): UserShift
    {
        return UserShiftServiceImpl::store(UserShiftStoreDto::fromJson([
            ... $this->definition(),
            ... $attributes,
        ]));
    }
}
