<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Enrollment;


class Term extends Model
{
    use HasFactory;
    protected $fillable = [
        'schoolyear_semester',
        'start_date',
        'end_date',
    ];

    public function enrollments(){
        return $this->hasMany(Enrollment::class);
    }
}
