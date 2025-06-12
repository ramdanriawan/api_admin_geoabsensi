<?php

namespace Database\Seeders;

use App\Models\Dtos\UserAdminStoreDto;
use App\Models\Dtos\UserStoreDto;
use App\Models\User;
use App\Services\ServiceImpl\UserServiceImpl;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        UserServiceImpl::storeAdmin(UserAdminStoreDto::fromJson([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => 'admin@gmail.com',
            'remember_token' => null,
            'profile_picture' => null,
            'level' => 'admin',
            'status' => 'active',
        ]));
    }
}
