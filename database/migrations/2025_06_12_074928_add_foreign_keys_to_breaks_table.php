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
        Schema::table('breaks', function (Blueprint $table) {
            $table->foreign(['attendance_id'], 'breaks_ibfk_1')->references(['id'])->on('attendances')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('breaks', function (Blueprint $table) {
            $table->dropForeign('breaks_ibfk_1');
        });
    }
};
