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
        Schema::table('offdays', function (Blueprint $table) {
            $table->foreign(['employee_id'], 'offdays_ibfk_2')->references(['id'])->on('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['off_type_id'], 'offdays_ibfk_3')->references(['id'])->on('off_types')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offdays', function (Blueprint $table) {
            $table->dropForeign('offdays_ibfk_2');
            $table->dropForeign('offdays_ibfk_3');
        });
    }
};
