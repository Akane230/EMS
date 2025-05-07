<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Program;

class Department extends Model
{
    use HasFactory;
    protected $primaryKey = 'department_id';
    protected $fillable = [
        'department_name',
        'description',
    ];

    public function program(){
        return $this->hasMany(Program::class);
    }
}
