<?php

namespace Database\Seeders;

use App\Models\Dtos\OrganizationStoreDto;
use App\Models\Organization;
use App\Services\ServiceImpl\OrganizationServiceImpl;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        OrganizationServiceImpl::store(OrganizationStoreDto::fromJson([
            'name' => 'Bikin Aplikasi Dev',
            'logo' => null,
            'description' => "Best profesional software development team",
            'lat' => -6.864365650728728,
            'lng' => 107.5758099951166,
            'is_active' => true,
        ]));
    }
}
