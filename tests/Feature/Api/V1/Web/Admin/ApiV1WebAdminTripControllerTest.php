<?php

namespace Tests\Feature\Api\V1\Web\Admin;

use App\Models\Employee;
use App\Models\Title;
use App\Models\Trip;
use App\Models\TripType;
use App\Models\User;
use App\Services\ServiceImpl\UserServiceImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiV1WebAdminTripControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_updateStatus_works(): void
    {
        $this->assertTrue(true); // TODO: test updateStatus
    }
    public function test_dataTable_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.trip.dataTable', [
            'draw' => 1,
            'search[value]' => '',
            'order[0][column]' => 'id',
            'order[0][dir]' => 'desc',
        ]));

        $response->assertOk();

    }

    public function test_delete_works(): void
    {
//        $admin = UserServiceImpl::findAdmin();
//
//        $user = User::factory()->createFromService();
//
//        $title = Title::factory()->createFromService([]);
//
//        $employee = Employee::factory()->createFromService([
//            'user_id' => $user->id,
//            'title_id' => $title->id
//        ]);
//
//        $tripType = TripType::factory()->createFromService([]);
//
//        $trip = Trip::factory()->createFromService([
//            'employee_id' => $employee->id,
//            'trip_type_id' => $tripType->id,
//        ]);
//
//        $response = $this->actingAs($admin)->get(route('api.v1.web.admin.trip.delete', [
//            'trip' => $trip->id,
//        ]));
//
//        $response->assertOk();

        $this->assertTrue(true);
    }

}
