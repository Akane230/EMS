<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Instructor;
use App\Models\Position;

class InstructorPosition extends Model
{
    use HasFactory;

    protected $table = 'instructorPosition';
    
    protected $fillable = [
        'instructor_id',
        'position_id',
    ];

    public function instructor(){
        return $this->belongsTo(Instructor::class);
    }
    
    public function position(){
        return $this->belongsTo(Position::class);
    }
}
