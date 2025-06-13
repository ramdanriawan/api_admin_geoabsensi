<?php

namespace Tests\Feature\Web\Admin;

use App\Models\User;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAdminUserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_index_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('web.admin.user.index'));

        $response->assertOk();
    }

    public function test_create_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('web.admin.user.create'));

        $response->assertOk();
    }

    public function test_store_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $password = fake()->password;

        $response = $this->actingAs($admin)->post(route('web.admin.user.store'), [
            'name' => fake()->name,
            'email' => fake()->email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertRedirect(route('web.admin.user.index'));
    }

    public function test_show_works(): void
    {
        $this->assertTrue(true); // TODO: test show
    }

    public function test_edit_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $user = User::factory()->createFromService();

        $response = $this->actingAs($admin)->get(route('web.admin.user.edit', ['user' => $user->id]));

        $response->assertOk();
    }

    public function test_update_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $password = fake()->password;

        $user = User::factory()->createFromService();

        $response = $this->actingAs($admin)->put(route('web.admin.user.update', $user->id), [
            '_method' => 'PUT',
            'name' => fake()->name,
            'email' => fake()->email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertRedirect(route('web.admin.user.index'));
    }

    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }

}
