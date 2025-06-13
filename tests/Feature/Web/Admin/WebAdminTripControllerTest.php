<?php

namespace Tests\Feature\Web\Admin;

use App\Models\Trip;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAdminTripControllerTest extends TestCase
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

        $response = $this->actingAs($admin)->get(route('web.admin.trip.index'));

        $response->assertOk();
    }
    public function test_create_works(): void
    {
        $this->assertTrue(true);
    }
    public function test_store_works(): void
    {
        $this->assertTrue(true);
    }
    public function test_show_works(): void
    {
        $this->assertTrue(true); // TODO: test show
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
