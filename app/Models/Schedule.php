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

    public function courses(){
        return $this->belongsTo(Course::class);
    }

    public function sections(){
        return $this->belongsTo(Section::class);
    }
    
    public function instructors(){
        return $this->belongsTo(Instructor::class);
    }

    public function rooms(){
        return $this->belongsTo(Room::class);
    }
    
    public function enrollments(){
        return $this->hasMany(Enrollment::class);
    }
}
