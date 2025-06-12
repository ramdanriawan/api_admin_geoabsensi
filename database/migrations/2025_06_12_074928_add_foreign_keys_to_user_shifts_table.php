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
        Schema::table('user_shifts', function (Blueprint $table) {
            $table->foreign(['user_id'], 'user_shifts_ibfk_1')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['shift_id'], 'user_shifts_ibfk_2')->references(['id'])->on('shifts')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_shifts', function (Blueprint $table) {
            $table->dropForeign('user_shifts_ibfk_1');
            $table->dropForeign('user_shifts_ibfk_2');
        });
    }
};
