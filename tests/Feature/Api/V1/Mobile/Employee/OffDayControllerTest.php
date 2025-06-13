<?php

namespace Tests\Feature\Api\V1\Mobile\Employee;

use App\Models\Employee;
use App\Models\EmployeeOffDay;
use App\Models\OffDay;
use App\Models\OffType;
use App\Models\Title;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OffDayControllerTest extends TestCase
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
        $this->assertTrue(true); // TODO: test store
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
    public function test_findLastByUserId_works(): void
    {
        $user = User::factory()->createFromService();

        $title = Title::factory()->createFromService();

        $employee = Employee::factory()->createFromService([
            'title_id' => $title->id,
            'user_id' => $user->id
        ]);

        $offType =  OffType::factory()->createFromService([]);

        $employeeOffDay = EmployeeOffDay::factory()->createFromService([
            'employee_id' => $employee->id,
            'off_type_id' => $offType->id,
        ]);

        $response = $this->actingAs($user)->post(route('api.v1.mobile.employee.offDay.store'), [
            'off_type_id' => $offType->id,
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'end_date' => now()->addDays(10)->format('Y-m-d'),
        ]);

        $response->assertOk();

    }

}
