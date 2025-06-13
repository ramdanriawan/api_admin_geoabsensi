<?php

namespace Tests\Feature\Web\Admin;

use App\Models\Motivational;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAdminMotivationalControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_index_works(): void
    {
        $response = $this->actingAs(UserServiceImpl::findAdmin())->get(route('web.admin.motivational.index'));

        $response->assertStatus(200);
    }
    public function test_create_works(): void
    {
        $response = $this->actingAs(UserServiceImpl::findAdmin())->get(route('web.admin.motivational.create'));

        $response->assertStatus(200);
    }
    public function test_store_works(): void
    {
        $response = $this->actingAs(UserServiceImpl::findAdmin())->post(route('web.admin.motivational.store'), [
            'word' => fake()->words(20, true)
        ]);

        $response->assertRedirect(route('web.admin.motivational.index'));
    }
    public function test_show_works(): void
    {
        $this->assertTrue(true); // TODO: test show
    }
    public function test_edit_works(): void
    {
        $motivational = Motivational::factory()->createFromService([
            'word' => fake()->words(20, true)
        ]);

        $response = $this->actingAs(UserServiceImpl::findAdmin())->get(route('web.admin.motivational.edit', $motivational->id));

        $response->assertOk();
    }
    public function test_update_works(): void
    {
        $motivational = Motivational::factory()->createFromService([
            'word' => fake()->words(20, true)
        ]);

        $response = $this->actingAs(UserServiceImpl::findAdmin())->post(route('web.admin.motivational.update', $motivational->id), [
            '_method' => 'PUT',
            'word' => fake()->words(20, true),
        ]);

        $response->assertRedirect(route('web.admin.motivational.index'));
    }
    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }

}
