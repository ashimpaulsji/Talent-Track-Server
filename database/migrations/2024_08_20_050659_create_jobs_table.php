<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id(); // This will create a bigint auto-incrementing primary key
            $table->unsignedBigInteger('employer_id'); // Change this to match the employees table
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->string('salary');
            $table->timestamps();

            $table->foreign('employer_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}