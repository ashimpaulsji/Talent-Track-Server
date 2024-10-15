<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employer_id');
            $table->string('title');
            $table->text('description');
            $table->text('requirements');
            $table->text('responsibilities');
            $table->string('location');
            $table->string('salary_range');
            $table->string('employment_type');
            $table->string('experience_level');
            $table->timestamps();

            $table->foreign('employer_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
