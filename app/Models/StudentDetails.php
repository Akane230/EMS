<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Student;
use App\Models\Program;
use App\Models\YearLevel;

class StudentDetails extends Model
{
    use HasFactory;
    protected $primaryKey = 'student_details_id';
    protected $fillable = [
        'student_id',
        'program_id',
        'year_level_id',
    ];
    
    public function student(){
        return $this->belongsTo(Student::class);
    }
    public function program(){
        return $this->belongsTo(Program::class);
    }
    public function yearLevel(){
        return $this->belongsTo(YearLevel::class);
    }
}
