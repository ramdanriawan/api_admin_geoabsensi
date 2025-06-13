<?php

namespace Tests\Feature\Api\V1\Web\Admin;

use App\Models\VisitType;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiV1WebAdminVisitTypeControllerTest extends TestCase
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

        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.visitType.dataTable', [
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

        $visitType = VisitType::factory()->createFromService();

        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.visitType.delete', [
            'visitType' => $visitType->id,
        ]));

        $response->assertOk();
    }

}
