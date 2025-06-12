<?php

namespace Tests\Feature\Api\V1\Mobile\Employee;

use App\Models\Dtos\UserAdminStoreDto;
use App\Models\Dtos\UserStoreDto;
use App\Services\ServiceImpl\UserServiceImpl;
use Illuminate\Support\Uri;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApplicationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_info_works(): void
    {
        $user = UserServiceImpl::store(UserStoreDto::fromJson([
            'name' => 'employee',
            'email' => 'employee@gmail.com',
            'password' => 'employee@gmail.com',
        ]));

        $response = $this->actingAs($user)->get("api/v1/user/login?email={$user->email}&password={$user->email}");

        $response->assertStatus(200);

//        $this->get('api/v1/application/info', [
//            'Authorization' => 'Bearer '
//        ])->assertOk();
//
//        $this->assertTrue(true); // TODO: test info
    }

}
