<?php

namespace Tests\Feature\Web\Admin;

use App\Models\Shift;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAdminShiftControllerTest extends TestCase
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

        $response = $this->actingAs($admin)->get(route('web.admin.shift.index'));

        $response->assertOk();
    }
    public function test_create_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('web.admin.shift.create'));

        $response->assertOk();
    }
    public function test_store_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->post(route('web.admin.shift.store'), [
            'name' => fake()->title,
            'start_time' => now()->setHour(8)->format('H:i'),
            'end_time' => now()->setHour(16)->format('H:i'),
            'description' => fake()->words(20, true)
        ]);

        $response->assertRedirect(route('web.admin.shift.index'));
    }
    public function test_show_works(): void
    {
        $this->assertTrue(true); // TODO: test show
    }
    public function test_edit_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $shift = Shift::factory()->createFromService();

        $response = $this->actingAs($admin)->get(route('web.admin.shift.edit', ['shift' => $shift->id]));

        $response->assertOk();
    }
    public function test_update_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $shift = Shift::factory()->createFromService();

        $response = $this->actingAs($admin)->put(route('web.admin.shift.update', ['shift' => $shift->id]), [
            'name' => fake()->title,
            'start_time' => now()->setHour(8)->format('H:i'),
            'end_time' => now()->setHour(16)->format('H:i'),
            'description' => fake()->words(20, true)
        ]);

        $response->assertRedirect(route('web.admin.shift.index'));
    }
    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }

}
