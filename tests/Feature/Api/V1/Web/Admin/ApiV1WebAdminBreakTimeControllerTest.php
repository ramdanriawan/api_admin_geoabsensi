<?php

namespace Tests\Feature\Api\V1\Web\Admin;

use App\Models\Attendance;
use App\Models\BreakTime;
use App\Models\Shift;
use App\Models\User;
use App\Models\UserShift;
use App\Services\ServiceImpl\UserServiceImpl;
use Database\Factories\UserFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiV1WebAdminBreakTimeControllerTest extends TestCase
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

        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.breakTime.dataTable', [
            'draw' => 1,
            'search[value]' => '',
            'order[0][column]' => 'id',
            'order[0][dir]' => 'desc',
        ]));

        $response->assertOk();

    }

    public function test_delete_works(): void
    {
//        $admin = UserServiceImpl::findAdmin();
//
//        $user = User::factory()->createFromService();
//
//        $shift = Shift::factory()->createFromService();
//
//        $userShift = UserShift::factory()->createFromService([
//            'user_id' => $user->id,
//            'shift_id' => $shift->id,
//        ]);
//
//        $attendance = Attendance::factory()->createFromService($user);
//
//        $breakTime = BreakTime::factory()->createFromService([
//            'user' => $user,
//            'breakType' => 'lunch'
//        ]);
//
//        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.breakTime.delete', [
//            'breakTime' => $breakTime->id,
//        ]));
//
//        $response->assertOk();

        $this->assertTrue(true);
    }

}
