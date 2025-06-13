<?php

namespace Database\Factories;

use App\Models\Dtos\MotivationalStoreDto;
use App\Models\Motivational;
use App\Services\ServiceImpl\MotivationalServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Motivational>
 */
class MotivationalFactory extends Factory
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
            'word' => fake()->words(20, true)

        ];
    }

    public function createFromService($attributes = []): Motivational
    {
        return MotivationalServiceImpl::store(MotivationalStoreDto::fromJson([
            ...$this->definition(),
            ...$attributes
        ]));
    }
}
