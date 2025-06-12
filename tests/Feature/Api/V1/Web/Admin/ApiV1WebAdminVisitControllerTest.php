<?php

namespace Tests\Feature\Api\V1\Web\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiV1WebAdminVisitControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_updateStatus_works(): void
    {
        $this->assertTrue(true); // TODO: test updateStatus
    }
    public function test_dataTable_works(): void
    {
        $this->assertTrue(true); // TODO: test dataTable
    }

}