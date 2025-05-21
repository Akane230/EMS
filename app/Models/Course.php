<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Program;
use App\Models\Schedule;
use App\Models\Enrollment;

class Course extends Model
{
    use HasFactory;
    protected $primaryKey = 'course_code';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'course_code',
        'course_name',
        'credits',
        'year_level',
        'description',
        'program_id',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_code', 'course_code');
    }
    public function isGeneralEducation(): bool
    {
        $program = $this->program;

        return $program && $program->program_name === 'General Education';
    }
}
