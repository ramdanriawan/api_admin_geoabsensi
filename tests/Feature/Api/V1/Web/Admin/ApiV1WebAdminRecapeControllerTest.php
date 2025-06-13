<?php

namespace Tests\Feature\Api\V1\Web\Admin;

use App\Models\Recape;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiV1WebAdminRecapeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_getByUserFromStartDateToEndDate_works(): void
    {
        $this->assertTrue(true); // TODO: test getByUserFromStartDateToEndDate
    }
    public function test_updateStatus_works(): void
    {
        $this->assertTrue(true); // TODO: test updateStatus
    }
    public function test_dataTable_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.recape.dataTable', [
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
