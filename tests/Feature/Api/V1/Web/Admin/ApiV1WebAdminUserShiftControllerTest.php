<?php

namespace Tests\Feature\Api\V1\Web\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiV1WebAdminUserShiftControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_getUserSelect2_works(): void
    {
        $this->assertTrue(true); // TODO: test getUserSelect2
    }
    public function test_getShiftSelect2_works(): void
    {
        $this->assertTrue(true); // TODO: test getShiftSelect2
    }
    public function test_dataTable_works(): void
    {
        $this->assertTrue(true); // TODO: test dataTable
    }
    public function test_delete_works(): void
    {
        $this->assertTrue(true); // TODO: test delete
    }

}