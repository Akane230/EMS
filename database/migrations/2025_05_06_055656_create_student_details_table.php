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
        Schema::create('student_details', function (Blueprint $table) {
            $table->bigIncrements('student_details_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('year_level_id');
            $table->foreign('student_id')->references('student_id')->on('students')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('program_id')->references('program_id')->on('programs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('year_level_id')->references('year_level_id')->on('year_levels')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_details');
    }
};
