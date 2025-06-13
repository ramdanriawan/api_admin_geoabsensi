<?php

namespace Tests\Feature\Web\Admin;

use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAdminBreakTimeControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_index_works(): void
    {
        $response = $this->actingAs(UserServiceImpl::findAdmin())->get(route('web.admin.breakTime.index'));

        $response->assertStatus(200);
    }
    public function test_create_works(): void
    {
        $response = $this->actingAs(UserServiceImpl::findAdmin())->get(route('web.admin.breakTime.create'));

        $response->assertStatus(200);
    }
    public function test_store_works(): void
    {
        $this->assertTrue(true); // TODO: test store
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
        $this->assertTrue(true); // TODO: test update
    }
    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }

}
