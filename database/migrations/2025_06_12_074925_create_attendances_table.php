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
        Schema::create('attendances', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->double('attendance_total_hours')->default(0);
            $table->date('date');
            $table->enum('status', ['present', 'late', 'not present', 'wfh'])->default('present');
            $table->string('picture', 100)->nullable();
            $table->string('picture_check_out', 100)->nullable();
            $table->string('lat', 20)->nullable();
            $table->string('lng', 20)->nullable();
            $table->double('distance_in_meters')->nullable();
            $table->double('distance_in_meters_check_out')->nullable();
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
        Schema::dropIfExists('attendances');
    }
};
