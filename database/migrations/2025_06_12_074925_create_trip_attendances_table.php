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
        Schema::create('trip_attendances', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('trip_id')->index('trip_id');
            $table->time('check_in_time');
            $table->string('picture', 100);
            $table->string('lat', 20);
            $table->string('lng', 20);
            $table->double('distance_in_kilometers');
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
        Schema::dropIfExists('trip_attendances');
    }
};
