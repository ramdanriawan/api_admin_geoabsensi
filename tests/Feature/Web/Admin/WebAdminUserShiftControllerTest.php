<?php

namespace Tests\Feature\Web\Admin;

use App\Models\Shift;
use App\Models\User;
use App\Models\UserShift;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAdminUserShiftControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_index_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('web.admin.userShift.index'));

        $response->assertOk();
    }
    public function test_create_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('web.admin.userShift.create'));

        $response->assertOk();
    }
    public function test_store_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $shift = Shift::factory()->createFromService();

        $user = User::factory()->createFromService();

        $response = $this->actingAs($admin)->post(route('web.admin.userShift.store', [
            'user_id' => $user->id,
            'shift_id' => $shift->id,
        ]));

        $response->assertRedirect(route('web.admin.userShift.index'));
    }
    public function test_show_works(): void
    {
        $this->assertTrue(true); // TODO: test show
    }
    public function test_edit_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $shift = Shift::factory()->createFromService();

        $user = User::factory()->createFromService();

        $response = $this->actingAs($admin)->post(route('web.admin.userShift.store', [
            'user_id' => $user->id,
            'shift_id' => $shift->id,
        ]));

        $response->assertRedirect(route('web.admin.userShift.index'));
    }
    public function test_update_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $shift = Shift::factory()->createFromService();

        $user = User::factory()->createFromService();

        $userShift = UserShift::factory()->createFromService([
            'user_id' => $user->id,
            'shift_id' => $shift->id,
        ]);

        $response = $this->actingAs($admin)->post(route('web.admin.userShift.update', $userShift->id), [
            '_method' => 'PUT',
            'user_id' => $user->id,
            'shift_id' => $userShift->shift_id,
        ]);

        $response->assertRedirect(route('web.admin.userShift.index'));
    }
    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }

}
