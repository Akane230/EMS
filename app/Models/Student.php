<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Enrollment;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
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
        'status',
        'contact_number'
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
