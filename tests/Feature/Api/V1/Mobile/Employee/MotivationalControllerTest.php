<?php

namespace Tests\Feature\Api\V1\Mobile\Employee;

use App\Models\Motivational;
use App\Models\User;
use Database\Factories\UserFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MotivationalControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_index_works(): void
    {
        $this->assertTrue(true);
    }
    public function test_store_works(): void
    {
        $this->assertTrue(true); // TODO: test store
    }
    public function test_show_works(): void
    {
        $this->assertTrue(true); // TODO: test show
    }
    public function test_update_works(): void
    {
        $this->assertTrue(true); // TODO: test update
    }
    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }
    public function test_last_works(): void
    {
        $user = User::factory()->createFromService();

        $motivational = Motivational::factory()->createFromService();

        $response = $this->actingAs($user)->get(route('api.v1.mobile.employee.motivational.last'));

        $response->assertStatus(200);
    }

}
