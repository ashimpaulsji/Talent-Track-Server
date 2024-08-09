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
        Schema::create('applied_jobs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('job_id');
            $table->uuid('job_seeker_id');
            $table->timestamp('application_date')->useCurrent();
            $table->timestamps();

            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
            $table->foreign('job_seeker_id')->references('id')->on('job_seekers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applied_jobs');
    }
};
