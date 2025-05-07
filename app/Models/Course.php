<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CourseDetails;

class Course extends Model
{
    use HasFactory;
    protected $primaryKey = 'course_id';
    protected $fillable = [
        'course_code',
        'course_name',
        'credits',
        'description'
    ];

    public function courseDetails(){
        return $this->hasMany(CourseDetails::class);
    }
}
