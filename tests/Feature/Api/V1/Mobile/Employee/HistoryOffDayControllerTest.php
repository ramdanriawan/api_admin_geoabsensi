<?php

namespace Tests\Feature\Api\V1\Mobile\Employee;

use App\Models\Employee;
use App\Models\EmployeeOffDay;
use App\Models\OffType;
use App\Models\Title;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HistoryOffDayControllerTest extends TestCase
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

        $title = Title::factory()->createFromService();

        $employee = Employee::factory()->createFromService([
            'user_id' => $user->id,
            'title_id' => $title->id
        ]);

        $offType = OffType::factory()->createFromService();

        $employeeOffDay = EmployeeOffDay::factory()->createFromService([
            'employee_id' => $user->employee->id,
            'off_type_id' => $offType->id,
        ]);

        $response = $this->actingAs($user)->get(route('api.v1.mobile.employee.offDay.history.findAllByCurrentUser'));

        $response->assertOk();
    }

}
