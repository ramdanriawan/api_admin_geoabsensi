<?php

namespace Database\Seeders;

use App\Models\Dtos\ShiftStoreDto;
use App\Services\ServiceImpl\ShiftServiceImpl;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ShiftServiceImpl::store(ShiftStoreDto::fromJson([
            'name' => 'Morning',
            'start_time' => '08:00',
            'end_time' => '16:00',
            'description' => 'Monday - Friday',
        ]));

        ShiftServiceImpl::store(ShiftStoreDto::fromJson([
            'name' => 'Night',
            'start_time' => '16:00',
            'end_time' => '12:00',
            'description' => 'Monday - Friday',
        ]));
    }
}
