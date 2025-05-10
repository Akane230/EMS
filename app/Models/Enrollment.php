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

    public function students(){
        return $this->belongsTo(Student::class);
    }

    public function terms(){
        return $this->belongsTo(Term::class);
    }

    public function courses(){
        return $this->belongsTo(Course::class);
    }

    public function sections(){
        return $this->belongsTo(Section::class);
    }
    
    public function schedules(){
        return $this->belongsTo(Schedule::class);
    }
}
