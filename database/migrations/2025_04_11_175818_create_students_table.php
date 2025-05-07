<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('students', function (Blueprint $table) {
        $table->bigIncrements('student_id'); // Student ID number
        $table->string('first_name', 100);
        $table->string('last_name', 100);
        $table->string('email', 100)->unique();
        $table->enum('gender', ['Male', 'Female', 'Other']);
        $table->date('date_of_birth');
        $table->string('contact_number')->nullable();
        $table->text('country')->nullable();
        $table->text('province')->nullable();
        $table->text('city')->nullable();
        $table->text('street')->nullable();
        $table->text('zipcode')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
