<?php

namespace Tests\Feature\Api\V1\Web\Admin;

use App\Models\OffType;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiV1WebAdminOffTypeControllerTest extends TestCase
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

        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.offType.dataTable', [
            'draw' => 1,
            'search[value]' => '',
            'order[0][column]' => 'id',
            'order[0][dir]' => 'desc',
        ]));

        $response->assertOk();

    }

    public function test_delete_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $offType = OffType::factory()->createFromService();

        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.offType.delete', [
            'offType' => $offType->id,
        ]));

        $response->assertOk();
    }

}
