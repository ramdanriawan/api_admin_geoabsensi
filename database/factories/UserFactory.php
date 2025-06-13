<?php

namespace Database\Factories;

use App\Models\Dtos\UserStoreDto;
use App\Models\User;
use App\Services\ServiceImpl\UserServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'password' => fake()->password(),
            'email' => fake()->email(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function createFromService(array $override = []): User
    {
        $data = array_merge($this->definition(), $override);

        return UserServiceImpl::store(UserStoreDto::fromJson($data));
    }
}
