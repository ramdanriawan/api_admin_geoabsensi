<?php

namespace Tests\Feature\Api\V1\Web\Admin;

use App\Models\Motivational;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiV1WebAdminMotivationalControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_dataTable_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.motivational.dataTable', [
            'draw' => 1,
            'search[value]' => '',
            'order[0][column]' => 'id',
            'order[0][dir]' => 'desc',
        ]));

        $response->assertOk();

    }

    public function test_delete_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $motivational = Motivational::factory()->createFromService([]);

        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.motivational.delete', [
            'motivational' => $motivational->id,
        ]));

        $response->assertOk();
    }

}
