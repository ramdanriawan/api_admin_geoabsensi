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
        Schema::table('trips', function (Blueprint $table) {
            $table->foreign(['employee_id'], 'trips_ibfk_1')->references(['id'])->on('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['trip_type_id'], 'trips_ibfk_2')->references(['id'])->on('trip_types')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropForeign('trips_ibfk_1');
            $table->dropForeign('trips_ibfk_2');
        });
    }
};
