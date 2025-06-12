<?php

namespace Tests\Feature\Web\Admin;

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
        $this->assertTrue(true); // TODO: test index
    }

}