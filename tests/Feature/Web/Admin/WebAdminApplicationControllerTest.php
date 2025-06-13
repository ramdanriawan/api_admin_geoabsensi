<?php

namespace Tests\Feature\Web\Admin;

use App\Models\Application;
use App\Models\Dtos\UserStoreDto;
use App\Services\ServiceImpl\ApplicationServiceImpl;
use App\Services\ServiceImpl\UserServiceImpl;
use Faker\Guesser\Name;
use Faker\Provider\Company;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAdminApplicationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_index_works(): void
    {
        $user = UserServiceImpl::findAdmin();

        $response = $this->actingAs($user)->get(route('web.admin.application.index'));

        $response->assertStatus(200);
    }

    public function test_create_works(): void
    {
        $user = UserServiceImpl::findAdmin();

        $response = $this->actingAs($user)->get(route('web.admin.application.create'));

        $response->assertStatus(200);
    }

    public function test_store_works(): void
    {
        $user = UserServiceImpl::findAdmin();

        $response = $this->actingAs($user)
            ->post(route('web.admin.application.store', [
                'version' => '1.0.0',
                'name' => 'Geoabsensi',
                'phone' => '6288287642532',
                'email' => 'geoabsensi@gmail.com',
                'developer_name' => 'ramdan riawan',
                'brand' => 'Bikin Aplikasi Dev',
                'website' => 'https://bikinaplikasi.dev',
                'release_date' => now()->format('Y-m-d'),
                'last_update' => now()->format('Y-m-d'),
                'terms_url' => 'https://bikinaplikasi.dev/terms',
                'privacy_policy_url' => 'https://bikinaplikasi.dev/privacy-policy',
                'maximum_radius_in_meters' => 30,
                'minimum_visit_in_minutes' => 3,
                'is_active' => false,
            ]));

//        dd($response->content());

        $response->assertRedirectToRoute('web.admin.application.index');
    }

    public function test_show_works(): void
    {
        $user = UserServiceImpl::findAdmin();

        $response = $this->actingAs($user)
            ->post(route('web.admin.application.store'), [
                'version' => '1.0.0',
                'name' => 'Geoabsensi',
                'phone' => '6288287642532',
                'email' => 'geoabsensi@gmail.com',
                'developer_name' => 'ramdan riawan',
                'brand' => 'Bikin Aplikasi Dev',
                'website' => 'https://bikinaplikasi.dev',
                'release_date' => now()->format('Y-m-d'),
                'last_update' => now()->format('Y-m-d'),
                'terms_url' => 'https://bikinaplikasi.dev/terms',
                'privacy_policy_url' => 'https://bikinaplikasi.dev/privacy-policy',
                'maximum_radius_in_meters' => 30,
                'minimum_visit_in_minutes' => 3,
                'is_active' => false,
            ]);

        $application = Application::orderByDesc('id')->first();

        $application = ApplicationServiceImpl::findOne($application->id);

        $response = $this->actingAs($user)
            ->get(route('web.admin.application.show', $application->id));

        $response->assertStatus(200);
    }

    public function test_edit_works(): void
    {
        $user = UserServiceImpl::findAdmin();

        $response = $this->actingAs($user)
            ->post(route('web.admin.application.store'), [
                'version' => '1.0.0',
                'name' => 'Geoabsensi',
                'phone' => '6288287642532',
                'email' => 'geoabsensi@gmail.com',
                'developer_name' => 'ramdan riawan',
                'brand' => 'Bikin Aplikasi Dev',
                'website' => 'https://bikinaplikasi.dev',
                'release_date' => now()->format('Y-m-d'),
                'last_update' => now()->format('Y-m-d'),
                'terms_url' => 'https://bikinaplikasi.dev/terms',
                'privacy_policy_url' => 'https://bikinaplikasi.dev/privacy-policy',
                'maximum_radius_in_meters' => 30,
                'minimum_visit_in_minutes' => 3,
                'is_active' => false,
            ]);

        $application = Application::orderByDesc('id')->first();

        $application = ApplicationServiceImpl::findOne($application->id);

        $response = $this->actingAs($user)
            ->get(route('web.admin.application.edit', $application->id));

        $response->assertStatus(200);
    }

    public function test_update_works(): void
    {
        $user = UserServiceImpl::findAdmin();

        $response = $this->actingAs($user)
            ->post(route('web.admin.application.store'), [
                'version' => '1.0.0',
                'name' => 'Geoabsensi',
                'phone' => '6288287642532',
                'email' => 'geoabsensi@gmail.com',
                'developer_name' => 'ramdan riawan',
                'brand' => 'Bikin Aplikasi Dev',
                'website' => 'https://bikinaplikasi.dev',
                'release_date' => now()->format('Y-m-d'),
                'last_update' => now()->format('Y-m-d'),
                'terms_url' => 'https://bikinaplikasi.dev/terms',
                'privacy_policy_url' => 'https://bikinaplikasi.dev/privacy-policy',
                'maximum_radius_in_meters' => 30,
                'minimum_visit_in_minutes' => 3,
                'is_active' => false,
            ]);

        $application = Application::orderByDesc('id')->first();

        $application = ApplicationServiceImpl::findOne($application->id);

        $response = $this->actingAs($user)
            ->followingRedirects()->post(route('web.admin.application.update', $application->id), [
                '_method' => 'PUT',
                'id' => $application->id,
                'version' => '1.0.0',
                'name' => 'Geoabsensi',
                'phone' => '6288287642532',
                'email' => 'geoabsensi@gmail.com',
                'developer_name' => 'ramdan riawan',
                'brand' => 'Bikin Aplikasi Dev',
                'website' => 'https://bikinaplikasi.dev',
                'release_date' => now()->format('Y-m-d'),
                'last_update' => now()->format('Y-m-d'),
                'terms_url' => 'https://bikinaplikasi.dev/terms',
                'privacy_policy_url' => 'https://bikinaplikasi.dev/privacy-policy',
                'maximum_radius_in_meters' => 30,
                'minimum_visit_in_minutes' => 3,
                'is_active' => false,
            ]);

        $response->assertStatus(200);
    }

    public function test_destroy_works(): void
    {
        $user = UserServiceImpl::findAdmin();

        $response = $this->actingAs($user)
            ->post(route('web.admin.application.store'), [
                'version' => '1.0.0',
                'name' => 'Geoabsensi',
                'phone' => '6288287642532',
                'email' => 'geoabsensi@gmail.com',
                'developer_name' => 'ramdan riawan',
                'brand' => 'Bikin Aplikasi Dev',
                'website' => 'https://bikinaplikasi.dev',
                'release_date' => now()->format('Y-m-d'),
                'last_update' => now()->format('Y-m-d'),
                'terms_url' => 'https://bikinaplikasi.dev/terms',
                'privacy_policy_url' => 'https://bikinaplikasi.dev/privacy-policy',
                'maximum_radius_in_meters' => 30,
                'minimum_visit_in_minutes' => 3,
                'is_active' => false,
            ]);

        $application = Application::orderByDesc('id')->first();

        $application = ApplicationServiceImpl::findOne($application->id);

        $response = $this->actingAs($user)
            ->followingRedirects()->get(route('api.v1.web.admin.application.delete', $application->id));

        $response->assertStatus(200);
    }

}
