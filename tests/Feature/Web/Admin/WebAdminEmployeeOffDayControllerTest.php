<?php

namespace Tests\Feature\Web\Admin;

use App\Models\Employee;
use App\Models\EmployeeOffDay;
use App\Models\OffType;
use App\Models\Title;
use App\Models\User;
use App\Models\UserShift;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAdminEmployeeOffDayControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_index_works(): void
    {
        $response = $this->actingAs(UserServiceImpl::findAdmin())->get(route('web.admin.employeeOffDay.index'));

        $response->assertStatus(200);
    }

    public function test_create_works(): void
    {


        $response = $this->actingAs(UserServiceImpl::findAdmin())->get(route('web.admin.employeeOffDay.create'));

        $response->assertStatus(200);
    }

    public function test_store_works(): void
    {
        $user = User::factory()->createFromService();

        $title = Title::factory()->createFromService();

        $employee = Employee::factory()->createFromService([
            'title_id' => $title->id,
            'user_id' => $user->id,
        ]);

        $offType = OffType::factory()->createFromService();

        $response = $this->actingAs(UserServiceImpl::findAdmin())->post(route('web.admin.employeeOffDay.store'), [
            'employee_id' => $employee->id,
            'off_type_id' => $offType->id,
            'quota' => fake()->numberBetween(1, 10),
        ]);

        $response->assertRedirect(route('web.admin.employeeOffDay.index'));
    }

    public function test_show_works(): void
    {
        $this->assertTrue(true); // TODO: test show
    }

    public function test_edit_works(): void
    {
        $user = User::factory()->createFromService();

        $title = Title::factory()->createFromService();

        $employee = Employee::factory()->createFromService([
            'title_id' => $title->id,
            'user_id' => $user->id,
        ]);

        $offType = OffType::factory()->createFromService();

        $employeeOffDay = EmployeeOffDay::factory()->createFromService([
            'employee_id' => $employee->id,
            'off_type_id' => $offType->id,
        ]);

        $response = $this->actingAs(UserServiceImpl::findAdmin())->get(route('web.admin.employeeOffDay.edit', $employeeOffDay->id));

        $response->assertStatus(200);
    }

    public function test_update_works(): void
    {
        $user = User::factory()->createFromService();

        $title = Title::factory()->createFromService();

        $employee = Employee::factory()->createFromService([
            'title_id' => $title->id,
            'user_id' => $user->id,
        ]);

        $offType = OffType::factory()->createFromService();

        $employeeOffDay = EmployeeOffDay::factory()->createFromService([
            'employee_id' => $employee->id,
            'off_type_id' => $offType->id,
        ]);

        $response = $this->actingAs(UserServiceImpl::findAdmin())->post(route('web.admin.employeeOffDay.update', $employeeOffDay->id), [
            '_method' => 'PUT',
            'employee_id' => $employee->id,
            'off_type_id' => $offType->id,
            'quota' => fake()->numberBetween(1, 10),
        ]);

        $response->assertRedirect(route('web.admin.employeeOffDay.index'));

    }

    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }

}
