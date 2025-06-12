<?php

namespace Database\Seeders;

use App\Models\Dtos\PlatformStoreDto;
use App\Services\ServiceImpl\ApplicationServiceImpl;
use App\Services\ServiceImpl\PlatformServiceImpl;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlatformTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $application = ApplicationServiceImpl::findActive();

        PlatformServiceImpl::store(PlatformStoreDto::fromJson([
            'application_id' => $application->id,
            'name' => 'android',
        ]));

        PlatformServiceImpl::store(PlatformStoreDto::fromJson([
            'application_id' => $application->id,
            'name' => 'ios',
        ]));

        PlatformServiceImpl::store(PlatformStoreDto::fromJson([
            'application_id' => $application->id,
            'name' => 'web',
        ]));
    }
}
