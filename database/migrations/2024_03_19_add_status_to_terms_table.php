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
        Schema::table('terms', function (Blueprint $table) {
            // First add the status column after schoolyear_semester
            $table->enum('status', ['upcoming', 'active', 'completed'])->default('upcoming')->after('schoolyear_semester');
            
            // Then drop the is_active column if it exists
            if (Schema::hasColumn('terms', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('terms', function (Blueprint $table) {
            // Add back the is_active column
            $table->boolean('is_active')->default(true)->after('schoolyear_semester');
            
            // Drop the status column
            $table->dropColumn('status');
        });
    }
}; 