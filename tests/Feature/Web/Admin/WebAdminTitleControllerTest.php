<?php

namespace Tests\Feature\Web\Admin;

use App\Models\Title;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAdminTitleControllerTest extends TestCase
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

        $response = $this->actingAs($admin)->get(route('web.admin.title.index'));

        $response->assertOk();
    }
    public function test_create_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('web.admin.title.create'));

        $response->assertOk();
    }
    public function test_store_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->post(route('web.admin.title.store'), [
            'name' => fake()->title,
            'basic_salary' => fake()->numberBetween(5000000, 10000000),
            'penalty_per_late' => fake()->numberBetween(50, 100) * 1000,
            'meal_allowance_per_present' => fake()->numberBetween(50, 100) * 1000,
            'transport_allowance_per_present' => fake()->numberBetween(50, 100) * 1000,
            'overTime_pay_per_hours' => fake()->numberBetween(50, 100) * 1000,
        ]);

        $response->assertRedirect(route('web.admin.title.index'));
    }
    public function test_show_works(): void
    {
        $this->assertTrue(true); // TODO: test show
    }
    public function test_edit_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $title = Title::factory()->createFromService();

        $response = $this->actingAs($admin)->get(route('web.admin.title.edit', ['title' => $title->id]));

        $response->assertOk();
    }
    public function test_update_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $title = Title::factory()->createFromService();

        $response = $this->actingAs($admin)->put(route('web.admin.title.update', ['title' => $title->id]), [
            'name' => fake()->title,
            'basic_salary' => fake()->numberBetween(5000000, 10000000),
            'penalty_per_late' => fake()->numberBetween(50, 100) * 1000,
            'meal_allowance_per_present' => fake()->numberBetween(50, 100) * 1000,
            'transport_allowance_per_present' => fake()->numberBetween(50, 100) * 1000,
            'overTime_pay_per_hours' => fake()->numberBetween(50, 100) * 1000,
        ]);

        $response->assertRedirect(route('web.admin.title.index'));
    }
    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }

}
