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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->time('starting_time');
            $table->time('ending_time');
            $table->enum('day', ['Sunday','Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']);
            $table->string('course_code');
            $table->foreignId('section_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('instructor_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->foreign('course_code')->references('course_code')->on('courses')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
