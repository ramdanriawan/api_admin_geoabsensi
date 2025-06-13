<?php

namespace Tests\Feature\Api\V1\Mobile\Employee;

use App\Models\Dtos\UserAdminStoreDto;
use App\Models\Dtos\UserStoreDto;
use App\Models\Trip;
use App\Models\User;
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

        $password = fake()->password;
        $user = User::factory()->createFromService([
            'password' => $password
        ]);

        $response = $this->actingAs($user)->get(('api/v1/application/info'), [

        ]);

        $this->assertTrue($response->json('success'));
    }

}
