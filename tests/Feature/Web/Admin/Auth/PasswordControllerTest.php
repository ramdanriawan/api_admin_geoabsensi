<?php

namespace Tests\Feature\Web\Admin\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_update_works(): void
    {
        $this->assertTrue(true); // TODO: test update
    }

}