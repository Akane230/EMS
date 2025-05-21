<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\InstructorPosition;
use App\Models\Department;

class Position extends Model
{
    use HasFactory;
    protected $fillable = [
        'position_name',
        'department_id'
    ];

    public function instructorPosition(){
        return $this->hasMany(InstructorPosition::class);
    }
    public function department(){
        return $this->belongsTo(Department::class);
    }
}
