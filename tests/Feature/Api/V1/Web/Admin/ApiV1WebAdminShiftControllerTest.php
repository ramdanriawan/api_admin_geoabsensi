<?php

namespace Tests\Feature\Api\V1\Web\Admin;

use App\Models\Shift;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiV1WebAdminShiftControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_select2_works(): void
    {
        $this->assertTrue(true); // TODO: test select2
    }
    public function test_dataTable_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.shift.dataTable', [
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

        $shift = Shift::factory()->createFromService([]);

        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.shift.delete', [
            'shift' => $shift->id,
        ]));

        $response->assertOk();
    }

}
