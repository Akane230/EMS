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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('term_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('course_code');
            $table->foreignId('section_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('schedule_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('year_level');
            $table->timestamps();
            $table->foreign('course_code')->references('course_code')->on('courses')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
