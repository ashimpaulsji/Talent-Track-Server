<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedJobsTable extends Migration
{
    public function up()
    {
        Schema::create('saved_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_seeker_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['job_seeker_id', 'job_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('saved_jobs');
    }
}
