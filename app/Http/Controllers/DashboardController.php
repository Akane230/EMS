<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Course;
use App\Models\Program;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getStats()
    {
        // Enrollment data by month for current year
        $enrollmentData = $this->getEnrollmentStats();
        
        // Course distribution by program
        $courseDistribution = $this->getCourseDistribution();
        
        return response()->json([
            'enrollment' => $enrollmentData,
            'courseDistribution' => $courseDistribution
        ]);
    }

    protected function getEnrollmentStats()
    {
        $currentYear = date('Y');
        $enrollments = Enrollment::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthNames = [];
        $monthCounts = array_fill(0, 11, 0); // Initialize all months with 0

        foreach ($enrollments as $enrollment) {
            $monthIndex = $enrollment->month - 1;
            $monthNames[$monthIndex] = Carbon::create()->month($enrollment->month)->format('M');
            $monthCounts[$monthIndex] = $enrollment->count;
        }

        // Fill in missing month names
        for ($i = 0; $i < 12; $i++) {
            if (!isset($monthNames[$i])) {
                $monthNames[$i] = Carbon::create()->month($i + 1)->format('M');
            }
        }

        return [
            'labels' => $monthNames,
            'data' => $monthCounts
        ];
    }

    protected function getCourseDistribution()
    {
        $programs = Program::withCount('courses')->get();
        
        $labels = [];
        $data = [];
        
        foreach ($programs as $program) {
            $labels[] = $program->program_name;
            $data[] = $program->courses_count;
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}