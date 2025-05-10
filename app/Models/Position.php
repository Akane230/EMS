<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\InstructorPosition;

class Position extends Model
{
    use HasFactory;
    protected $fillable = [
        'position_name',
    ];

    public function instructorPosition(){
        return $this->hasMany(InstructorPosition::class);
    }
}
