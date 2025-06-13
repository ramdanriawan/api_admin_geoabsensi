<?php

namespace Tests\Feature\Api\V1\Mobile\Employee;

use App\Models\Attendance;
use App\Models\Shift;
use App\Models\User;
use App\Models\UserShift;
use App\Services\ServiceImpl\ApplicationServiceImpl;
use App\Services\ServiceImpl\AttendanceServiceImpl;
use App\Services\ServiceImpl\OrganizationServiceImpl;
use App\Services\ServiceImpl\UserServiceImpl;
use Illuminate\Http\UploadedFile;
use RamdanRiawan\Geolocator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttendanceControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_index_works(): void
    {
        $this->assertTrue(true); // TODO: test index
    }

    public function test_create_works(): void
    {
        $this->assertTrue(true); // TODO: test create
    }

    public function test_store_works(): void
    {
        $user = User::factory()->createFromService();

        $shift = Shift::first();

        $userShift = UserShift::factory()->createFromService([
            'user_id' => $user->id,
            'shift_id' => $shift->id,
        ]);

        $file = UploadedFile::fake()->create('large.jpg', 2048, 'image/jpeg'); // 10 MB

        $organization = OrganizationServiceImpl::findActive();

        $coords = Geolocator::generateNearbyCoordinates($organization->lat, $organization->lng, 50);

        $response = $this->actingAs($user)->post(route('api.v1.mobile.employee.attendance.store'), [
            'lat' => $coords['latitude'],
            'lng' => $coords['longitude'],
            'picture' => UploadedFile::fake()->create('image.png', 5048)
        ]);

        $response->assertStatus(200);
    }

    public function test_show_works(): void
    {
        $this->assertTrue(true);
    }

    public function test_edit_works(): void
    {
        $this->assertTrue(true); // TODO: test edit
    }

    public function test_update_works(): void
    {
        $this->assertTrue(true); // TODO: test update
    }

    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }

    public function test_findByUserId_works(): void
    {
        $user = User::factory()->createFromService();

        $shift = Shift::first();

        $userShift = UserShift::factory()->createFromService([
            'user_id' => $user->id,
            'shift_id' => $shift->id
        ]);

        $attendance = Attendance::factory()->createFromService($user);

        $response = $this->actingAs($user)->get(route('api.v1.mobile.employee.attendance.findByUserId', $attendance->id));

        $response->assertOk();
    }

    public function test_endAttendance_works(): void
    {
        $user = User::factory()->createFromService();

        $shift = Shift::first();

        $userShift = UserShift::factory()->createFromService([
            'user_id' => $user->id,
            'shift_id' => $shift->id
        ]);

        $attendance = Attendance::factory()->createFromService($user);

        $organization = OrganizationServiceImpl::findActive();

        $coords = Geolocator::generateNearbyCoordinates($organization->lat, $organization->lng, 30);

        $response = $this->actingAs($user)->post(route('api.v1.mobile.employee.attendance.endAttendance', $attendance->id), [
            'lat' => $coords['latitude'],
            'lng' => $coords['longitude'],
            'picture' => UploadedFile::fake()->create('picture.png', 5048)
        ]);

        $response->assertOk();
    }



}
