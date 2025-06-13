<?php

namespace Tests\Feature\Api\V1\Mobile\Employee;

use App\Models\Attendance;
use App\Models\OverTime;
use App\Models\Shift;
use App\Models\User;
use App\Models\UserShift;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OverTimeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_index_works(): void
    {
        $this->assertTrue(true); // TODO: test index
    }
    public function test_create_works(): void
    {
        $this->assertTrue(true); // TODO: test create
    }
    public function test_store_works(): void
    {
        $user = User::factory()->createFromService();

        $shift = Shift::factory()->createFromService();

        $userShift = UserShift::factory()->createFromService([
            'user_id' => $user->id,
            'shift_id' => $shift->id,
        ]);

        $attendance = Attendance::factory()->createFromService($user);

        $response = $this->actingAs($user)->post(route('api.v1.mobile.employee.overTime.store'), [
            'over_type' => 'mandatory'
        ]);

        $response->assertStatus(200);
    }
    public function test_show_works(): void
    {
        $this->assertTrue(true); // TODO: test show
    }
    public function test_edit_works(): void
    {
        $this->assertTrue(true); // TODO: test edit
    }
    public function test_update_works(): void
    {
        $this->assertTrue(true); // TODO: test update
    }
    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }
    public function test_findByAttendanceId_works(): void
    {
        $user = User::factory()->createFromService();

        $shift = Shift::factory()->createFromService();

        $userShift = UserShift::factory()->createFromService([
            'user_id' => $user->id,
            'shift_id' => $shift->id,
        ]);

        $attendance = Attendance::factory()->createFromService($user);

        $overTime = OverTime::factory()->createFromService([
            'user' => $user,
            'overType' => 'mandatory',
        ]);

        $response = $this->actingAs($user)->get(route('api.v1.mobile.employee.overTime.findByAttendanceId', $attendance->id));

        $response->assertStatus(200);
    }
    public function test_findByUserId_works(): void
    {
        $user = User::factory()->createFromService();

        $shift = Shift::factory()->createFromService();

        $userShift = UserShift::factory()->createFromService([
            'user_id' => $user->id,
            'shift_id' => $shift->id,
        ]);

        $attendance = Attendance::factory()->createFromService($user);

        $overTime = OverTime::factory()->createFromService([
            'user' => $user,
            'overType' => 'mandatory',
        ]);

        $response = $this->actingAs($user)->get(route('api.v1.mobile.employee.overTime.findByUserId'));

        $response->assertStatus(200);
    }
    public function test_end_works(): void
    {
        $user = User::factory()->createFromService();

        $shift = Shift::factory()->createFromService();

        $userShift = UserShift::factory()->createFromService([
            'user_id' => $user->id,
            'shift_id' => $shift->id,
        ]);

        $attendance = Attendance::factory()->createFromService($user);

        $overTime = OverTime::factory()->createFromService([
            'user' => $user,
            'overType' => 'mandatory',
        ]);

        $response = $this->actingAs($user)->get(route('api.v1.mobile.employee.overTime.end'));

        $response->assertStatus(200);
    }

}
