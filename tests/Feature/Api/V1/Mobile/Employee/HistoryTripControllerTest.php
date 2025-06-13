<?php

namespace Tests\Feature\Api\V1\Mobile\Employee;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Shift;
use App\Models\Title;
use App\Models\Trip;
use App\Models\TripType;
use App\Models\User;
use App\Models\UserShift;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HistoryTripControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_findAllByCurrentUser_works(): void
    {
        $user = User::factory()->createFromService();

        $shift =  Shift::factory()->createFromService();

        $userShift = UserShift::factory()->createFromService([
            'user_id' => $user->id,
            'shift_id' => $shift->id,
        ]);

        $title = Title::factory()->createFromService();

        $employee = Employee::factory()->createFromService([
            'user_id' => $user->id,
            'title_id' => $title->id
        ]);

        $attendance = Attendance::factory()->createFromService($user);

        $tripType = TripType::factory()->createFromService();

        $trip = Trip::factory()->createFromService([
            'employee_id' => $employee->id,
            'trip_type_id' => $tripType->id,
        ]);

        $response = $this->actingAs($user)->get(route('api.v1.mobile.employee.offDay.history.findAllByCurrentUser'));

        $response->assertOk();
    }

}
