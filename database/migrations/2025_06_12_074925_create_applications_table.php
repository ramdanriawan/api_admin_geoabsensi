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
        Schema::create('applications', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('version', 10);
            $table->string('name', 30);
            $table->string('phone', 15);
            $table->string('email', 50);
            $table->string('developer_name', 30);
            $table->string('brand', 30);
            $table->string('website', 30);
            $table->date('release_date');
            $table->date('last_update');
            $table->string('terms_url', 50);
            $table->string('privacy_policy_url', 50);
            $table->double('maximum_radius_in_meters')->default(50);
            $table->integer('minimum_visit_in_minutes')->default(3);
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
