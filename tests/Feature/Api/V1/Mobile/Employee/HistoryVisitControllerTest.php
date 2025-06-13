<?php

namespace Tests\Feature\Api\V1\Mobile\Employee;

use App\Models\Employee;
use App\Models\Shift;
use App\Models\Title;
use App\Models\User;
use App\Models\UserShift;
use App\Models\Visit;
use App\Models\VisitType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HistoryVisitControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_findAllByCurrentUser_works(): void
    {
        $user = User::factory()->createFromService();

        $shift =  Shift::factory()->createFromService();

        $userShift = UserShift::factory()->createFromService([
            'user_id' => $user->id,
            'shift_id' => $shift->id,
        ]);

        $title = Title::factory()->createFromService();

        $employee = Employee::factory()->createFromService([
            'user_id' => $user->id,
            'title_id' => $title->id
        ]);

        $visitType = VisitType::factory()->createFromService();

        $visit = Visit::factory()->createFromService([
            'user' => $user,
            'visitType' => $visitType,
        ]);

        $response = $this->actingAs($user)->get(route('api.v1.mobile.employee.visit.history.findAllByCurrentUser'));

        $response->assertOk();
    }

}
