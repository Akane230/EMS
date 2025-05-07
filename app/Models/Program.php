<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Department;
use App\Models\StudentDetails;
use App\Models\CourseDetails;

class Program extends Model
{
    use HasFactory;
    protected $primaryKey = 'program_id';
    protected $fillable = [
        'program_name',
        'program_description',
        'department_id'
    ];

    public function studentDetails(){
        return $this->hasMany(StudentDetails::class);
    }
    
    public function courseDetails(){
        return $this->hasMany(CourseDetails::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }
}
