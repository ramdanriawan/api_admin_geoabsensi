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
        Schema::table('trip_attendances', function (Blueprint $table) {
            $table->foreign(['trip_id'], 'trip_attendances_ibfk_2')->references(['id'])->on('trips')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trip_attendances', function (Blueprint $table) {
            $table->dropForeign('trip_attendances_ibfk_2');
        });
    }
};
