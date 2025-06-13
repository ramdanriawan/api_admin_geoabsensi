<?php

namespace Tests\Feature\Web\Admin\Auth;

use App\Models\Dtos\UserAdminStoreDto;
use App\Models\Dtos\UserStoreDto;
use App\Models\User;
use App\Services\ServiceImpl\UserServiceImpl;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AuthenticatedSessionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('web.admin.login'));

        $response->assertOk();
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = UserServiceImpl::findAdmin();

        $response = $this->post(route('web.admin.login.store'), [
            'email' => $user->email,
            'password' => $user->email,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('web.admin.dashboard.index', absolute: false));
    }

    public function test_users_can_not_authenticate_when_not_admin(): void
    {
        $user = UserServiceImpl::storeAdmin(UserAdminStoreDto::fromJson([
            'name' => 'employee 1',
            'email' => 'employee1@gmail.com',
            'email_verified_at' => now(),
            'password' => 'employee1@gmail.com',
            'remember_token' => null,
            'profile_picture' => null,
            'level' => 'employee',
            'status' => 'active',
        ]));

        $response = $this->followingRedirects()->post(route('web.admin.login.store'), [
            'email' => $user->email,
            'password' => $user->email,
        ]);

        $response->assertForbidden();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = UserServiceImpl::findAdmin();

        $this->post(route('web.admin.login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_not_access_admin_page_when_not_authenticate(): void
    {
        $response = $this->get(route('web.admin.dashboard.index'));

        $response->assertRedirect();
    }

    public function test_user_admin_should_not_be_deleted()
    {
        $user = UserServiceImpl::findAdmin();

        $response = $this->actingAs($user)->get(route('api.v1.web.admin.user.delete', ['user' => $user->id]));

        $response->assertBadRequest();

        $user = UserServiceImpl::findAdmin();

        $this->assertNotNull($user);
    }

    public function test_users_can_logout(): void
    {
        $user = UserServiceImpl::findAdmin();

        $response = $this->actingAs($user)->get(route('web.admin.logout'));

        $this->assertGuest();
        $response->assertRedirect(route('web.admin.login'));
    }
}
