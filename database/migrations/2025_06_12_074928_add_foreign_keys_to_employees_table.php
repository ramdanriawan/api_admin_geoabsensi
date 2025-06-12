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
        Schema::table('employees', function (Blueprint $table) {
            $table->foreign(['title_id'], 'employees_ibfk_1')->references(['id'])->on('titles')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['user_id'], 'employees_ibfk_2')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('employees_ibfk_1');
            $table->dropForeign('employees_ibfk_2');
        });
    }
};
