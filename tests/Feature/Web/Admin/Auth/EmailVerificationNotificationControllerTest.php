<?php

namespace Tests\Feature\Web\Admin\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailVerificationNotificationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_store_works(): void
    {
        $this->assertTrue(true); // TODO: test store
    }

}