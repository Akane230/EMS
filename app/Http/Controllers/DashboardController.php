<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Enrollment;
use App\Models\Program;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get enrollment data for charts
        $enrollmentData = $this->getEnrollmentData();
        $courseDistribution = $this->getCourseDistribution();

        return view('dashboard', compact('enrollmentData', 'courseDistribution'));
    }

    private function getEnrollmentData()
    {
        // Monthly data for the last 12 months
        $monthlyData = $this->getMonthlyEnrollments();
        
        // Quarterly data for the last 4 quarters
        $quarterlyData = $this->getQuarterlyEnrollments();
        
        // Yearly data for the last 5 years
        $yearlyData = $this->getYearlyEnrollments();

        return [
            'monthly' => $monthlyData,
            'quarterly' => $quarterlyData,
            'yearly' => $yearlyData
        ];
    }

    private function getMonthlyEnrollments()
    {
        $months = [];
        $enrollments = [];
        
        // Get last 12 months
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $count = Enrollment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $enrollments[] = $count;
        }

        return [
            'labels' => $months,
            'values' => $enrollments
        ];
    }

    private function getQuarterlyEnrollments()
    {
        $quarters = [];
        $enrollments = [];
        
        // Get last 4 quarters
        for ($i = 3; $i >= 0; $i--) {
            $date = Carbon::now()->subQuarters($i);
            $quarter = ceil($date->month / 3);
            $quarters[] = "Q{$quarter} {$date->year}";
            
            $startMonth = ($quarter - 1) * 3 + 1;
            $endMonth = $quarter * 3;
            
            $count = Enrollment::whereYear('created_at', $date->year)
                ->whereBetween(DB::raw('MONTH(created_at)'), [$startMonth, $endMonth])
                ->count();
            
            $enrollments[] = $count;
        }

        return [
            'labels' => $quarters,
            'values' => $enrollments
        ];
    }

    private function getYearlyEnrollments()
    {
        $years = [];
        $enrollments = [];
        
        // Get last 5 years
        for ($i = 4; $i >= 0; $i--) {
            $year = Carbon::now()->subYears($i)->year;
            $years[] = $year;
            
            $count = Enrollment::whereYear('created_at', $year)->count();
            $enrollments[] = $count;
        }

        return [
            'labels' => $years,
            'values' => $enrollments
        ];
    }

    private function getCourseDistribution()
    {
        // Get courses grouped by program
        $coursesByProgram = Course::select('programs.program_name', DB::raw('count(*) as course_count'))
            ->leftJoin('programs', 'courses.program_id', '=', 'programs.id')
            ->groupBy('programs.program_name', 'programs.id')
            ->orderBy('course_count', 'desc')
            ->get();

        $labels = [];
        $values = [];

        foreach ($coursesByProgram as $program) {
            $labels[] = $program->program_name ?? 'No Program';
            $values[] = $program->course_count;
        }

        // If no data, provide sample data
        if (empty($labels)) {
            $labels = ['General Education', 'Computer Science', 'Business Administration', 'Engineering', 'Arts & Sciences'];
            $values = [15, 12, 8, 10, 5];
        }

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }

    /**
     * Get dashboard statistics for API calls (if needed)
     */
    public function getStats()
    {
        return response()->json([
            'total_students' => Student::count(),
            'total_courses' => Course::count(),
            'total_instructors' => Instructor::count(),
            'active_enrollments' => Enrollment::currentTerm()->count(),
            'recent_enrollments' => Enrollment::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
        ]);
    }

    /**
     * Get enrollment trend data for AJAX calls
     */
    public function getEnrollmentTrend(Request $request)
    {
        $period = $request->get('period', 'monthly');
        
        switch ($period) {
            case 'yearly':
                $data = $this->getYearlyEnrollments();
                break;
            case 'quarterly':
                $data = $this->getQuarterlyEnrollments();
                break;
            default:
                $data = $this->getMonthlyEnrollments();
                break;
        }

        return response()->json($data);
    }

    /**
     * Get additional dashboard metrics
     */
    public function getMetrics()
    {
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        $currentMonthEnrollments = Enrollment::whereYear('created_at', $currentMonth->year)
            ->whereMonth('created_at', $currentMonth->month)
            ->count();

        $lastMonthEnrollments = Enrollment::whereYear('created_at', $lastMonth->year)
            ->whereMonth('created_at', $lastMonth->month)
            ->count();

        $enrollmentGrowth = $lastMonthEnrollments > 0 
            ? (($currentMonthEnrollments - $lastMonthEnrollments) / $lastMonthEnrollments) * 100 
            : 0;

        // Get year level distribution
        $yearLevelDistribution = Enrollment::select('year_level', DB::raw('count(*) as count'))
            ->groupBy('year_level')
            ->orderBy('year_level')
            ->get()
            ->pluck('count', 'year_level')
            ->toArray();

        // Get enrollment status
        $activeEnrollments = Enrollment::currentTerm()->count();
        $totalEnrollments = Enrollment::count();

        return response()->json([
            'enrollment_growth' => round($enrollmentGrowth, 1),
            'current_month_enrollments' => $currentMonthEnrollments,
            'year_level_distribution' => $yearLevelDistribution,
            'active_enrollments' => $activeEnrollments,
            'total_enrollments' => $totalEnrollments,
        ]);
    }
}