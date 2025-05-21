<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Department;
use App\Models\Course;
use App\Models\Section;

class Program extends Model
{
    use HasFactory;
    protected $fillable = [
        'program_name',
        'program_description',
        'department_id'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
    public function isGeneralEducation(): bool
    {
        return $this->program_name === 'General Education';
    }
    public static function getGeneralEducationId()
    {
        return static::where('program_name', 'General Education')->value('id');
    }
}
