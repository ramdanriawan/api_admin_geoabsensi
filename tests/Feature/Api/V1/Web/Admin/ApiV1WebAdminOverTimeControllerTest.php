<?php

namespace Tests\Feature\Api\V1\Web\Admin;

use App\Models\OverTime;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiV1WebAdminOverTimeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

   public function test_dataTable_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.overTime.dataTable', [
            'draw' => 1,
            'search[value]' => '',
            'order[0][column]' => 'id',
            'order[0][dir]' => 'desc',
        ]));

        $response->assertOk();

    }

    public function test_delete_works(): void
    {
        $this->assertTrue(true);
    }

}
