<?php

namespace Tests\Feature\Web\Admin\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PasswordResetLinkControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_create_works(): void
    {
        $this->assertTrue(true); // TODO: test create
    }
    public function test_store_works(): void
    {
        $this->assertTrue(true); // TODO: test store
    }

}