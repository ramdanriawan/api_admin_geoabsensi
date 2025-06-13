<?php

namespace Tests\Feature\Web\Admin;

use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAdminDashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_index_works(): void
    {
        $response = $this->actingAs(UserServiceImpl::findAdmin())->get(route('web.admin.dashboard.index'));

        $response->assertStatus(200);
    }

}
