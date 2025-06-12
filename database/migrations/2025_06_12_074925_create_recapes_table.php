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
        Schema::create('recapes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->date('date')->useCurrent();
            $table->date('start_date');
            $table->date('end_date');
            $table->smallInteger('present')->default(0);
            $table->smallInteger('sick')->default(0);
            $table->smallInteger('offday')->default(0);
            $table->smallInteger('trip')->default(0);
            $table->smallInteger('late')->default(0);
            $table->smallInteger('absent')->default(0);
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
        Schema::dropIfExists('recapes');
    }
};
