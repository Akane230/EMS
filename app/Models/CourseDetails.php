<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Course;
use App\Models\Program;

class CourseDetails extends Model
{
    use HasFactory;
    protected $primaryKey = 'course_details_id';
    protected $fillable = [
        'course_id',
        'program_id',
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }
    
    public function program(){
        return $this->belongsTo(Program::class);
    }
}
