<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Enrollment;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id', 
        'first_name', 
        'last_name', 
        'email',
        'gender', 
        'date_of_birth', 
        'country', 
        'province', 
        'city', 
        'street', 
        'zipcode', 
        'contact_number'
    ];

    public function studentDetails(){
        return $this->hasMany(Enrollment::class);
    }
}
