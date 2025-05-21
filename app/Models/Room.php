<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Department;
use App\Models\Schedule;

class Room extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'roomname',
        'department_id',
    ];

    public function department(){
        return $this->belongsTo(Department::class);
    }
    
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
}
