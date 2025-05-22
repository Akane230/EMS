<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'country',
        'province',
        'city',
        'street',
        'zipcode',
        'contact_number',
        'email',
        'status'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the user that owns the student record
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all enrollments for this student
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the student's current enrollment (active term)
     */
    public function currentEnrollment()
    {
        return $this->hasMany(Enrollment::class)
            ->whereHas('term', function ($query) {
                $query->where('status', 'active');
            });
    }

    /**
     * Get the student's latest enrollment
     */
    public function latestEnrollment()
    {
        return $this->hasOne(Enrollment::class)->latest();
    }

    /**
     * Get the student's current program based on latest enrollment
     */
    public function getCurrentProgram()
    {
        $latestEnrollment = $this->latestEnrollment()->with('course.program')->first();
        return $latestEnrollment ? $latestEnrollment->course->program : null;
    }

    /**
     * Get the student's current year level based on latest enrollment
     */
    public function getCurrentYearLevel()
    {
        $latestEnrollment = $this->latestEnrollment()->first();
        return $latestEnrollment ? $latestEnrollment->year_level : 1;
    }

    /**
     * Check if student is a freshman (no previous enrollments)
     */
    public function isFreshman()
    {
        return $this->enrollments()->count() === 0;
    }

    /**
     * Get student's full name
     */
    public function getFullNameAttribute()
    {
        $middleInitial = $this->middle_name ? strtoupper(substr($this->middle_name, 0, 1)) . '.' : '';
        return trim("{$this->first_name} {$middleInitial} {$this->last_name}");
    }

    /**
     * Get student's formal name (Last, First Middle)
     */
    public function getFormalNameAttribute()
    {
        $middleInitial = $this->middle_name ? strtoupper(substr($this->middle_name, 0, 1)) . '.' : '';
        return trim("{$this->last_name}, {$this->first_name} {$middleInitial}");
    }

    /**
     * Get enrollments grouped by term
     */
    public function getEnrollmentsByTerm()
    {
        return $this->enrollments()
            ->with(['term', 'course', 'section', 'schedule.room', 'schedule.instructor'])
            ->get()
            ->groupBy('term_id')
            ->map(function ($enrollments) {
                return [
                    'term' => $enrollments->first()->term,
                    'enrollments' => $enrollments,
                    'total_units' => $enrollments->sum('course.credits'),
                    'year_level' => $enrollments->first()->year_level
                ];
            })
            ->sortByDesc(function ($item) {
                return $item['term']->created_at;
            });
    }
}