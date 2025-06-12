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
        Schema::create('trips', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('employee_id')->index('employee_id');
            $table->integer('trip_type_id')->index('trips_ibfk_2');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('date')->useCurrent();
            $table->smallInteger('duration_in_hours')->nullable()->default(0);
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
        Schema::dropIfExists('trips');
    }
};
