<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\StudentDetails;

class Student extends Model
{
    use HasFactory;
    protected $primaryKey = 'student_id';
    public $incrementing = true;
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
        return $this->hasMany(StudentDetails::class);
    }
}
