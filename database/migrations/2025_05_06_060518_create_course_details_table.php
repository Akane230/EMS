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
        Schema::create('course_details', function (Blueprint $table) {
            $table->bigIncrements('course_details_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('program_id');
            $table->foreign('course_id')->references('course_id')->on('courses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('program_id')->references('program_id')->on('programs')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_details');
    }
};
