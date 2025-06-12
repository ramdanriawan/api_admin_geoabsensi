<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Dtos\ApplicationStoreDto;
use App\Services\ServiceImpl\ApplicationServiceImpl;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ApplicationServiceImpl::store(ApplicationStoreDto::fromJson([
                'version' => '1.0.0',
                'name' => 'Geoabsensi',
                'phone' => '6288287642532',
                'email' => 'bikinaplikasidev@gmail.com',
                'developer_name' => 'Ramdan Riawan',
                'brand' => 'Bikin Aplikasi Dev',
                'website' => 'http://bikinaplikasi.dev',
                'release_date' => '2025-06-12',
                'last_update' => '2020-06-12',
                'terms_url' => 'http://bikinaplikasi.dev/terms',
                'privacy_policy_url' => 'http://bikinaplikasi.dev/privacy',
                'maximum_radius_in_meters' => 50,
                'minimum_visit_in_minutes' => 3,
                'is_active' => true,
            ]
        ));
    }
}
