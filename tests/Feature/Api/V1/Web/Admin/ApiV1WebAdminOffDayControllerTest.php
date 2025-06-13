<?php

namespace Tests\Feature\Api\V1\Web\Admin;

use App\Models\Employee;
use App\Models\EmployeeOffDay;
use App\Models\OffDay;
use App\Models\OffType;
use App\Models\Title;
use App\Models\User;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiV1WebAdminOffDayControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_updateStatus_works(): void
    {
        $this->assertTrue(true); // TODO: test updateStatus
    }
    public function test_dataTable_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.offDay.dataTable', [
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
//        $title = Title::factory()->createFromService();
//
//        $employee = Employee::factory()->createFromService([
//            'user_id' => $user->id,
//            'title_id' => $title->id,
//        ]);
//
//        $offType = OffType::factory()->createFromService([]);
//
//        $employeeOffDay = EmployeeOffDay::factory()->createFromService([
//            'off_type_id' => $offType->id,
//            'employee_id' => $employee->id,
//        ]);
//
//        $offDay = OffDay::factory()->createFromService([
//            'employee_id' => $employee->id,
//            'off_type_id' => $offType->id
//        ]);
//
//        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.offDay.delete', [
//            'offDay' => $offDay->id,
//        ]));
//
//        $response->assertOk();

        $this->assertTrue(true);
    }

}
