<?php

namespace Tests\Feature\Web\Admin;

use App\Models\PaySlip;
use App\Models\Title;
use App\Models\User;
use App\Services\ServiceImpl\UserServiceImpl;
use Database\Factories\UserFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAdminPaySlipControllerTest extends TestCase
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

        $response = $this->actingAs($admin)->get(route('web.admin.paySlip.index'));

        $response->assertStatus(200);
    }

    public function test_create_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $response = $this->actingAs($admin)->get(route('web.admin.paySlip.create'));

        $response->assertStatus(200);
    }

    public function test_store_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $user = User::factory()->createFromService([]);

        $title = Title::factory()->createFromService([]);

        $response = $this->actingAs($admin)->post(route('web.admin.paySlip.index'), [
            'user_id' => $user->id,
            'period_start' => now()->addDays(-30)->toDateString(),
            'period_end' => now()->toDateString(),
            'date' => date("Y-m-d"),
            'basic_salary' => $title->basic_salary,
            'meal_allowance' => fake()->numberBetween(30000, 100000),
            'transport_allowance' => fake()->numberBetween(30000, 100000),
            'overTime_pay' => $title->overTime_pay_per_hours * fake()->numberBetween(1, 10),
            'bonus' => fake()->numberBetween(200000, 300000),
            'deduction_bpjs_kesehatan' => fake()->numberBetween(200000, 500000),
            'deduction_bpjs_ketenagakerjaan' => fake()->numberBetween(200000, 400000),
            'deduction_pph21' => fake()->numberBetween(300000, 1000000),
            'deduction_late_or_leave' => $title->penalty_per_late * fake()->numberBetween(1, 10),
            'note' => fake()->words(20, true),
            'status' => 'agreed',
        ]);

        $response->assertRedirect(route('web.admin.paySlip.index'));
    }

    public function test_show_works(): void
    {
        $this->assertTrue(true); // TODO: test show
    }

    public function test_edit_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $user = User::factory()->createFromService([]);

        $title = Title::factory()->createFromService([]);

        $paySlip = PaySlip::factory()->createFromService([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($admin)->get(route('web.admin.paySlip.edit', $paySlip->id));

        $response->assertStatus(200);

    }

    public function test_update_works(): void
    {
        $admin = UserServiceImpl::findAdmin();

        $user = User::factory()->createFromService([]);

        $title = Title::factory()->createFromService([]);

        $paySlip = PaySlip::factory()->createFromService([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($admin)->post(route('web.admin.paySlip.update', $paySlip->id), [
            '_method' => 'PUT',
            'id' => $paySlip->id,
            'user_id' => $user->id,
            'period_start' => now()->addDays(-30)->toDateString(),
            'period_end' => now()->toDateString(),
            'date' => date("Y-m-d"),
            'basic_salary' => $title->basic_salary,
            'meal_allowance' => fake()->numberBetween(30000, 100000),
            'transport_allowance' => fake()->numberBetween(30000, 100000),
            'overTime_pay' => $title->overTime_pay_per_hours * fake()->numberBetween(1, 10),
            'bonus' => fake()->numberBetween(200000, 300000),
            'deduction_bpjs_kesehatan' => fake()->numberBetween(200000, 500000),
            'deduction_bpjs_ketenagakerjaan' => fake()->numberBetween(200000, 400000),
            'deduction_pph21' => fake()->numberBetween(300000, 1000000),
            'deduction_late_or_leave' => $title->penalty_per_late * fake()->numberBetween(1, 10),
            'note' => fake()->words(20, true),
            'status' => 'agreed',
        ]);

        $response->assertRedirect(route('web.admin.paySlip.index'));
    }

    public function test_destroy_works(): void
    {
        $this->assertTrue(true); // TODO: test destroy
    }

}
