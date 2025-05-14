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
    Schema::create('courses', function (Blueprint $table) {
        $table->string('course_code', 100)->unique();
        $table->string('course_name', 100);
        $table->integer('credits');
        $table->text('description')->nullable();
        $table->foreignId('program_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
