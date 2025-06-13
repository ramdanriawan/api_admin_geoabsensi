<?php

namespace Tests\Feature\Api\V1\Mobile\Employee;

use App\Models\Attendance;
use App\Models\BreakTime;
use App\Models\Shift;
use App\Models\UserShift;
use http\Client\Curl\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HistoryBreakTimeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_findAllByCurrentUser_works(): void
    {
        $user = \App\Models\User::factory()->createFromService();

        $shift = Shift::factory()->createFromService();

        $userShift = UserShift::factory()->createFromService([
            'user_id' => $user->id,
            'shift_id' => $shift->id
        ]);

        $attendance = Attendance::factory()->createFromService($user);

        $breakTime = BreakTime::factory()->createFromService([
            'user' => $user,
            'breakType' => 'lunch'
        ]);

        $response = $this->actingAs($user)->get(route('api.v1.mobile.employee.breakTime.history.findAllByCurrentUser'));

        $response->assertOk();
    }

}
