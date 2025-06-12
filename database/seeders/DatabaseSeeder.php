<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminUserTableSeeder::class);
        $this->call(RoleTableSeeder::class);

        $this->call(ApplicationTableSeeder::class);
        $this->call(OrganizationTableSeeder::class);
        $this->call(PlatformTableSeeder::class);

        $this->call(ShiftTableSeeder::class);
    }
}
