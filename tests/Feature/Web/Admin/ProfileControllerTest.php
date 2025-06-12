<?php

namespace Tests\Feature\Web\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
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

}