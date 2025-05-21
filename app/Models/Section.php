<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Program;
use App\Models\Enrollment;
use App\Models\Schedule;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_name',
        'program_id',
    ];

    public function program(){
        return $this->belongsTo(Program::class);
    }
    public function enrollments(){
        return $this->hasMany(Enrollment::class);
    }
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
}
