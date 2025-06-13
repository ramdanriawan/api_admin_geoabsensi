<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\User;
use App\Services\ServiceImpl\AttendanceServiceImpl;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
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

    public function createFromService(User $user): Attendance
    {
        return AttendanceServiceImpl::store(
            $user,
            UploadedFile::fake()->create('large.jpg', 2048, 'image/jpeg'),
            $this->faker->latitude,
            $this->faker->longitude,
        );
    }
}
