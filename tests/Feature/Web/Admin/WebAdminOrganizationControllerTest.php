<?php

namespace Tests\Feature\Web\Admin;

use App\Models\Organization;
use App\Services\ServiceImpl\OrganizationServiceImpl;
use App\Services\ServiceImpl\UserServiceImpl;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAdminOrganizationControllerTest extends TestCase
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

        $response = $this->actingAs($admin)->get(route('web.admin.organization.index'));

        $response->assertOk();
    }
    public function test_create_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('web.admin.organization.create'));

        $response->assertOk();
    }
    public function test_store_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->post(route('web.admin.organization.store'), [
            'name' => fake()->name(),
            'logo' => UploadedFile::fake()->create('logo.png', 2048),
            'description' => fake()->words(100, true),
            'lat' => fake()->latitude,
            'lng' => fake()->longitude,
            'is_active' => fake()->numberBetween(0,1)
        ]);

        $response->assertRedirect(route('web.admin.organization.index'));
    }
    public function test_show_works(): void
    {
        $this->assertTrue(true); // TODO: test show
    }
    public function test_edit_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $organization = Organization::factory()->createFromService();

        $response = $this->actingAs($admin)->get(route('web.admin.organization.edit', $organization->id));

        $response->assertOk();
    }
    public function test_update_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $organization = Organization::factory()->createFromService();

        $response = $this->actingAs($admin)->post(route('web.admin.organization.update', $organization->id), [
            '_method' => 'PUT',
            'name' => fake()->name(),
            'logo' => UploadedFile::fake()->create('logo.png', 2048),
            'description' => fake()->words(100, true),
            'lat' => fake()->latitude,
            'lng' => fake()->longitude,
            'is_active' => fake()->numberBetween(0,1)
        ]);

        $response->assertRedirect(route('web.admin.organization.index'));
    }
    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }

}
