<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pay_slips', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->date('date')->useCurrent();
            $table->date('period_start');
            $table->date('period_end');
            $table->double('basic_salary')->nullable()->default(0);
            $table->double('meal_allowance')->nullable()->default(0);
            $table->double('transport_allowance')->nullable()->default(0);
            $table->double('overTime_pay')->nullable()->default(0);
            $table->double('bonus')->nullable()->default(0);
            $table->double('total_earnings')->nullable()->storedAs('`basic_salary` + `meal_allowance` + `transport_allowance` + `overTime_pay` + `bonus`');
            $table->double('deduction_bpjs_kesehatan')->nullable()->default(0);
            $table->double('deduction_bpjs_ketenagakerjaan')->nullable()->default(0);
            $table->double('deduction_pph21')->nullable()->default(0);
            $table->double('deduction_late_or_leave')->nullable()->default(0);
            $table->double('total_deductions')->nullable()->storedAs('`deduction_bpjs_kesehatan` + `deduction_bpjs_ketenagakerjaan` + `deduction_pph21` + `deduction_late_or_leave`');
            $table->double('net_salary')->nullable()->storedAs('`total_earnings` - `total_deductions`');
            $table->string('note')->nullable();
            $table->enum('status', ['agreed', 'disagreed', 'waiting'])->default('waiting');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_slips');
    }
};
