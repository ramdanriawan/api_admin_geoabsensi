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
        Schema::create('overtimes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('attendance_id')->index('attendance_id');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->date('date')->useCurrent();
            $table->smallInteger('duration_in_minutes')->nullable()->default(0);
            $table->enum('over_type', ['voluntary', 'mandatory'])->default('voluntary');
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
        Schema::dropIfExists('overtimes');
    }
};
