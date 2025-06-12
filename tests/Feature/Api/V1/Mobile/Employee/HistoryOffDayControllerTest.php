<?php

namespace Tests\Feature\Api\V1\Mobile\Employee;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HistoryOffDayControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_findAllByCurrentUser_works(): void
    {
        $this->assertTrue(true); // TODO: test findAllByCurrentUser
    }

}