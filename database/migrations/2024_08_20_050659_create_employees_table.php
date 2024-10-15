<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->uuid('user_id');
            $table->string('company_name');
            $table->text('company_description');
            $table->string('industry');
            $table->string('website')->nullable();
            $table->string('location');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
