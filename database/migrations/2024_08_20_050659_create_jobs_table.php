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
            $table->text('description')->nullable();
            $table->boolean('is_recent')->default(true);
            $table->json('requirements')->nullable();
            $table->json('responsibilities')->nullable();
            $table->string('location')->nullable();
            $table->string('salary_range')->nullable();
            $table->string('employment_type')->nullable();
            $table->string('experience_level')->nullable();
            $table->string('category')->nullable();
            $table->json('tags')->nullable();
            $table->string('posted_time')->default(date(now()));
            $table->timestamps();

            $table->foreign('employer_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
