<?php

namespace Tests\Feature\Web\Admin;

use App\Models\TripType;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAdminTripTypeControllerTest extends TestCase
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

        $response = $this->actingAs($admin)->get(route('web.admin.tripType.index'));

        $response->assertOk();
        $response->assertViewIs('web.admin.tripType.index');
    }
    public function test_create_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('web.admin.tripType.create'));

        $response->assertOk();
        $response->assertViewIs('web.admin.tripType.create');
    }
    public function test_store_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->post(route('web.admin.tripType.store'), [
            'name' => fake()->name,
        ]);

        $response->assertRedirect(route('web.admin.tripType.index'));

    }
    public function test_show_works(): void
    {
        $this->assertTrue(true); // TODO: test show
    }
    public function test_edit_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $tripType = TripType::factory()->createFromService();

        $response = $this->actingAs($admin)->get(route('web.admin.tripType.edit', ['tripType' => $tripType->id]));

        $response->assertOk();
    }
    public function test_update_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $tripType = TripType::factory()->createFromService();

        $response = $this->actingAs($admin)->post(route('web.admin.tripType.update', $tripType->id), [
            '_method' => 'PUT',
            'name' => fake()->name,
        ]);

        $response->assertRedirect(route('web.admin.tripType.index'));
    }
    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }

}
