<?php

namespace Tests\Feature\Api\V1\Mobile\Employee;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OverTimeControllerTest extends TestCase
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
    public function test_create_works(): void
    {
        $this->assertTrue(true); // TODO: test create
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
        $this->assertTrue(true); // TODO: test edit
    }
    public function test_update_works(): void
    {
        $this->assertTrue(true); // TODO: test update
    }
    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }
    public function test_findByAttendanceId_works(): void
    {
        $this->assertTrue(true); // TODO: test findByAttendanceId
    }
    public function test_findByUserId_works(): void
    {
        $this->assertTrue(true); // TODO: test findByUserId
    }
    public function test_end_works(): void
    {
        $this->assertTrue(true); // TODO: test end
    }

}