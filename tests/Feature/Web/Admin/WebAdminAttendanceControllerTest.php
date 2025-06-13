<?php

namespace Tests\Feature\Web\Admin;

use App\Http\Requests\Web\Admin\WebAdminAttendanceStoreRequest;
use App\Models\Attendance;
use App\Models\Dtos\UserShiftStoreDto;
use App\Models\Dtos\UserStoreDto;
use App\Models\Shift;
use App\Models\User;
use App\Models\UserShift;
use App\Services\ServiceImpl\AttendanceServiceImpl;
use App\Services\ServiceImpl\ShiftServiceImpl;
use App\Services\ServiceImpl\UserServiceImpl;
use App\Services\ServiceImpl\UserShiftServiceImpl;
use Database\Factories\UserShiftFactory;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;

class WebAdminAttendanceControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_index_works(): void
    {
        $user = UserServiceImpl::findAdmin();

        $response = $this->actingAs($user)->get(route('web.admin.attendance.index'));

        $response->assertStatus(200);
    }

    public function test_create_works(): void
    {
        $this->assertTrue(true);
    }

    public function test_store_works(): void
    {
        $this->assertTrue(true); // TODO: test store
    }

    public function test_show_works(): void
    {
        $user = User::factory()->createFromService();

        $shift = Shift::first();

        $userShift = UserShift::factory()->createFromService([
            'user_id' => $user->id,
            'shift_id' => $shift->id
        ]);

        $attendance = Attendance::factory()->createFromService($user);

        $response = $this->actingAs(UserServiceImpl::findAdmin())->get(route('web.admin.attendance.show', $attendance->id));

        $response->assertStatus(200);
    }

    public function test_edit_works(): void
    {
        $this->assertTrue(true);
    }

    public function test_update_works(): void
    {
        $this->assertTrue(true);
    }

    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }

}
