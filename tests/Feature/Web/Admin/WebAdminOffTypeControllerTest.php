<?php

namespace Tests\Feature\Web\Admin;

use App\Models\Dtos\OffTypeStoreDto;
use App\Models\OffType;
use App\Services\ServiceImpl\OffTypeServiceImpl;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAdminOffTypeControllerTest extends TestCase
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

        $response = $this->actingAs($admin)->get(route('web.admin.offType.index'));

        $response->assertOk();
    }
    public function test_create_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('web.admin.offType.create'));

        $response->assertOk();
    }
    public function test_store_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->post(route('web.admin.offType.store'), [
            'name' => fake()->name
        ]);

        $response->assertRedirect(route('web.admin.offType.index'));
    }
    public function test_show_works(): void
    {
        $this->assertTrue(true); // TODO: test show
    }
    public function test_edit_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $offType = OffType::factory()->createFromService();

        $response = $this->actingAs($admin)->get(route('web.admin.offType.edit', $offType->id));

        $response->assertOk();
    }
    public function test_update_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $offType = OffType::factory()->createFromService();

        $response = $this->actingAs($admin)->post(route('web.admin.offType.update', $offType->id), [
            '_method' => 'PUT',
            'name' => fake()->name
        ]);

        $response->assertRedirect(route('web.admin.offType.index'));
    }
    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }

}
