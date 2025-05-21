<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Student;
use App\Models\Term;
use App\Models\Course;
use App\Models\Section;
use App\Models\Schedule;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'term_id',
        'course_code',
        'section_id',
        'schedule_id',
        'year_level',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code', 'course_code');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Get the program through the course relationship
     */
    public function program()
    {
        return $this->course->program();
    }

    public function getFormattedStartTimeAttribute(): string
    {
        if (!$this->starting_time) {
            return 'N/A';
        }

        return date('h:i A', strtotime($this->starting_time));
    }

    /**
     * Format the ending time
     * 
     * @return string
     */
    public function getFormattedEndTimeAttribute(): string
    {
        if (!$this->ending_time) {
            return 'N/A';
        }

        return date('h:i A', strtotime($this->ending_time));
    }

    /**
     * Get the formatted schedule display
     * 
     * @return string
     */
    public function getScheduleDisplayAttribute(): string
    {
        $day = $this->day ?: 'Unspecified Day';
        $startTime = $this->formatted_start_time;
        $endTime = $this->formatted_end_time;
        $instructorName = $this->instructor ?
            trim($this->instructor->last_name . ', ' . $this->instructor->first_name) :
            'No Instructor';
        $roomName = $this->room ? $this->room->name : 'No Room';

        return "{$day}: {$startTime}-{$endTime} | {$instructorName} | {$roomName}";
    }
}
