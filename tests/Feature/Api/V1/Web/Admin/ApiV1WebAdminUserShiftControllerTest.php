<?php

namespace Tests\Feature\Api\V1\Web\Admin;

use App\Models\Shift;
use App\Models\User;
use App\Models\UserShift;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiV1WebAdminUserShiftControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_getUserSelect2_works(): void
    {
        $this->assertTrue(true); // TODO: test getUserSelect2
    }
    public function test_getShiftSelect2_works(): void
    {
        $this->assertTrue(true); // TODO: test getShiftSelect2
    }
public function test_dataTable_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.userShift.dataTable', [
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

        $user = User::factory()->createFromService();

        $shift = Shift::factory()->createFromService();

        $userShift = UserShift::factory()->createFromService([
            'user_id' => $user->id,
            'shift_id' => $shift->id,
        ]);

        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.userShift.delete', [
            'userShift' => $userShift->id,
        ]));

        $response->assertOk();
    }

}
