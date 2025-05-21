<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Course;
use App\Models\Section;
use App\Models\Instructor;
use App\Models\Room;
use App\Models\Enrollment;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'starting_time',
        'ending_time',
        'day',
        'course_code',
        'section_id',
        'instructor_id',
        'room_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code', 'course_code');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
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
