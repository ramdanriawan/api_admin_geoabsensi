<?php

namespace Tests\Feature\Api\V1\Mobile\Employee;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Shift;
use App\Models\Title;
use App\Models\User;
use App\Models\UserShift;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecapeControllerTest extends TestCase
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
    public function test_store_works(): void
    {
        $this->assertTrue(true); // TODO: test store
    }
    public function test_show_works(): void
    {
        $this->assertTrue(true); // TODO: test show
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

        $shift = Shift::factory()->createFromService();

        $userShift = UserShift::factory()->createFromService([
            'user_id' => $user->id,
            'shift_id' => $shift->id,
        ]);

        $title = Title::factory()->createFromService();

        $employee = Employee::factory()->createFromService([
            'user_id' => $user->id,
            'title_id' => $title->id,
        ]);

        $attendance = Attendance::factory()->createFromService($user);

        $response = $this->actingAs($user)->get(route('api.v1.mobile.employee.recape.findLastByUserId'));

        $response->assertStatus(200);
    }

}
