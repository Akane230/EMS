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
        Schema::create('staff_details', function (Blueprint $table) {
            $table->bigIncrements('staff_details_id');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('position_id');
            $table->foreign('staff_id')->references('staff_id')->on('staff')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('position_id')->references('position_id')->on('positions')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_details');
    }
};
