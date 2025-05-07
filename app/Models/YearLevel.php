<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\StudentDetails;

class YearLevel extends Model
{
    use HasFactory;
    protected $primaryKey = 'year_level_id';
    protected $fillable = [
        'year_level',
    ];

    public function studentDetails(){
        return $this->hasMany(StudentDetails::class);
    }
}
