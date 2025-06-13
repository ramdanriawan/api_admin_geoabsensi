<?php

namespace Tests\Feature\Web\Admin;

use App\Models\Employee;
use App\Models\Shift;
use App\Models\Title;
use App\Models\User;
use App\Models\UserShift;
use App\Services\ServiceImpl\EmployeeServiceImpl;
use App\Services\ServiceImpl\UserServiceImpl;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAdminEmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_index_works(): void
    {
        $response = $this->actingAs(UserServiceImpl::findAdmin())->get(route('web.admin.employee.index'));

        $response->assertStatus(200);
    }

    public function test_create_works(): void
    {
        $response = $this->actingAs(UserServiceImpl::findAdmin())->get(route('web.admin.employee.create'));

        $response->assertStatus(200);
    }

    public function test_store_works(): void
    {
        $user = User::factory()->createFromService();

        $shift = Shift::first();

        $userShift = UserShift::factory()->createFromService([
            'user_id' => $user->id,
            'shift_id' => $shift->id,
        ]);

        $title = Title::factory()->createFromService([]);

        $response = $this->actingAs(UserServiceImpl::findAdmin())->post(route('web.admin.employee.store', [
            'title_id' => $title->id,
            'user_id' => $user->id,
        ]));

        $response->assertRedirect(route('web.admin.employee.index'));
    }

    public function test_show_works(): void
    {
        $user = User::factory()->createFromService();

        $title = Title::factory()->createFromService([]);

        $employee = Employee::factory()->createFromService([
            'title_id' => $title->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs(UserServiceImpl::findAdmin())->get(route('web.admin.employee.show', $employee->id));

        $response->assertStatus(200);
    }

    public function test_edit_works(): void
    {
        $user = User::factory()->createFromService();

        $title = Title::factory()->createFromService([]);

        $employee = Employee::factory()->createFromService([
            'title_id' => $title->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs(UserServiceImpl::findAdmin())->get(route('web.admin.employee.edit', $employee->id));

        $response->assertStatus(200);
    }

    public function test_update_works(): void
    {
        $user = User::factory()->createFromService();

        $title = Title::factory()->createFromService([]);

        $employee = Employee::factory()->createFromService([
            'title_id' => $title->id,
            'user_id' => $user->id,
        ]);

        $title = Title::factory()->createFromService([]);

        $response = $this->actingAs(UserServiceImpl::findAdmin())->post(route('web.admin.employee.update', $employee->id), [
            '_method' => 'PUT',
            'title_id' => $title->id,
            'user_id' => $user->id,
        ]);

        $response->assertRedirect(route('web.admin.employee.index'));
    }

    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }

}
