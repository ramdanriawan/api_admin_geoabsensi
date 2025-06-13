<?php

namespace Tests\Feature\Api\V1\Web\Admin;

use App\Models\Employee;
use App\Models\Title;
use App\Models\User;
use App\Services\ServiceImpl\UserServiceImpl;
use Database\Factories\TitleFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiV1WebAdminEmployeeControllerTest extends TestCase
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

        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.employee.dataTable', [
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

        $title = Title::factory()->createFromService();

        $employee = Employee::factory()->createFromService([
            'user_id' => $user->id,
            'title_id' => $title->id,
        ]);

        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.employee.delete', [
            'employee' => $employee->id,
        ]));

        $response->assertOk();
    }

}
