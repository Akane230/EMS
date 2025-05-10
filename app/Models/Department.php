<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Program;
use App\Models\Room;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'department_name',
        'description',
    ];

    public function programs(){
        return $this->hasMany(Program::class);
    }
    public function rooms(){
        return $this->hasMany(Program::class);
    }
}
