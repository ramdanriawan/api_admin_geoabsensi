<?php

namespace Tests\Feature\Api\V1\Mobile\Employee;

use App\Models\Employee;
use App\Models\Shift;
use App\Models\Title;
use App\Models\Visit;
use App\Models\visitType;
use App\Models\User;
use App\Models\UserShift;
use App\Services\ServiceImpl\OrganizationServiceImpl;
use Illuminate\Http\UploadedFile;
use RamdanRiawan\Geolocator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VisitControllerTest extends TestCase
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

        $shift = Shift::factory()->createFromService();

        $userShift = UserShift::factory()->createFromService([
            'user_id' => $user->id,
            'shift_id' => $shift->id,
        ]);

        $title = Title::factory()->createFromService();

        $employee = Employee::factory()->createFromService([
            'user_id' => $user->id,
            'title_id' => $title->id,
        ]);

        $visitType = visitType::factory()->createFromService();

        $startDate = now()->addDays(2)->toDateString();
        $endDate = now()->addDays(20)->toDateString();

        $organization = OrganizationServiceImpl::findActive();

        $coords = Geolocator::generateNearbyCoordinates($organization->lat, $organization->lng, 30);

        $picture = UploadedFile::fake()->create('picture.jpng', 5048, 'image/png');

        $response = $this->actingAs($user)->post(route('api.v1.mobile.employee.visit.store'), [
            'employee_id' => $user->employee->id,
            'visit_type_id' => $visitType->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'lat' => $coords['latitude'],
            'lng' => $coords['longitude'],
            'picture' => $picture,
        ]);

        $response->assertStatus(200);
    }

    public function test_show_works(): void
    {
        $this->assertTrue(true); // TODO: test show
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

        $shift = Shift::factory()->createFromService();

        $userShift = UserShift::factory()->createFromService([
            'user_id' => $user->id,
            'shift_id' => $shift->id,
        ]);

        $title = Title::factory()->createFromService();

        $employee = Employee::factory()->createFromService([
            'user_id' => $user->id,
            'title_id' => $title->id,
        ]);

        $visitType = visitType::factory()->createFromService();

        $startDate = now()->addDays(2)->toDateString();
        $endDate = now()->addDays(20)->toDateString();

        $organization = OrganizationServiceImpl::findActive();

        $coords = Geolocator::generateNearbyCoordinates($organization->lat, $organization->lng, 30);

        $picture = UploadedFile::fake()->create('picture.jpng', 5048, 'image/png');

        $visit = Visit::factory()->createFromService([
            'user' => $user,
            'visitType' => $visitType
        ]);

        $response = $this->actingAs($user)->get(route('api.v1.mobile.employee.visit.findByUserId'));

        $response->assertStatus(200);
    }

}
