<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'term_id',
        'course_code',
        'section_id',
        'schedule_id',
        'year_level'
    ];

    protected $casts = [
        'year_level' => 'integer',
    ];

    /**
     * Get the student that owns the enrollment
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the term for this enrollment
     */
    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    /**
     * Get the course for this enrollment
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code', 'course_code');
    }

    /**
     * Get the section for this enrollment
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the schedule for this enrollment
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Scope to filter by current term
     */
    public function scopeCurrentTerm($query)
    {
        return $query->whereHas('term', function ($q) {
            $q->where('status', 'active');
        });
    }

    /**
     * Scope to filter by student
     */
    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Scope to filter by year level
     */
    public function scopeYearLevel($query, $yearLevel)
    {
        return $query->where('year_level', $yearLevel);
    }

    /**
     * Get year level display text
     */
    public function getYearLevelTextAttribute()
    {
        $yearTexts = [
            1 => '1st Year',
            2 => '2nd Year', 
            3 => '3rd Year',
            4 => '4th Year',
            5 => '5th Year'
        ];

        return $yearTexts[$this->year_level] ?? $this->year_level . 'th Year';
    }

    /**
     * Check if enrollment is for current active term
     */
    public function isCurrentTerm()
    {
        return $this->term && $this->term->status === 'active';
    }

    /**
     * Get the program through the course relationship
     */
    public function getProgram()
    {
        return $this->course ? $this->course->program : null;
    }
}