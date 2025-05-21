<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Schedule;
use App\Models\InstructorPosition;

class Instructor extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'gender',
        'date_of_birth',
        'contact_number',
        'country',
        'province',
        'city',
        'street',
        'zipcode',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
    public function instructorPosition(){
        return $this->hasMany(InstructorPosition::class);
    }
}
