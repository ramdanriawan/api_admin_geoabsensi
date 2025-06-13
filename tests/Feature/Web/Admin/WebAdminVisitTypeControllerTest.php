<?php

namespace Tests\Feature\Web\Admin;

use App\Models\VisitType;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAdminVisitTypeControllerTest extends TestCase
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

        $response = $this->actingAs($admin)->get(route('web.admin.visitType.index'));

        $response->assertOk();
    }
    public function test_create_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('web.admin.visitType.create'));

        $response->assertOk();
    }
    public function test_store_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->post(route('web.admin.visitType.store'), [
            'name' => fake()->name,
        ]);

        $response->assertRedirect(route('web.admin.visitType.index'));
    }
    public function test_show_works(): void
    {
        $this->assertTrue(true); // TODO: test show
    }
    public function test_edit_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $visitType = VisitType::factory()->createFromService();

        $response = $this->actingAs($admin)->get(route('web.admin.visitType.edit', $visitType->id));

        $response->assertOk();
    }
    public function test_update_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $visitType = VisitType::factory()->createFromService();

        $response = $this->actingAs($admin)->post(route('web.admin.visitType.update', $visitType->id), [
            '_method' => 'PUT',
            'name' => fake()->name,
        ]);

        $response->assertRedirect(route('web.admin.visitType.index'));
    }
    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }

}
