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
        Schema::create('titles', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 30);
            $table->double('basic_salary')->default(0);
            $table->double('penalty_per_late')->nullable();
            $table->double('meal_allowance_per_present');
            $table->double('transport_allowance_per_present');
            $table->double('overTime_pay_per_hours');
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
        Schema::dropIfExists('titles');
    }
};
