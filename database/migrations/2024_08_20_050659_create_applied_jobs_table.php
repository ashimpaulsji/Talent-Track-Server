<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('applied_jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('job_seeker_id');
            $table->timestamp('application_date');
            $table->timestamps();
        });

        // Add foreign keys only if the referenced tables exist
        if (Schema::hasTable('jobs') && Schema::hasTable('job_seekers')) {
            Schema::table('applied_jobs', function (Blueprint $table) {
                $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
                $table->foreign('job_seeker_id')->references('id')->on('job_seekers')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('applied_jobs');
    }
};
