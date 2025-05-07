<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Program;

class Section extends Model
{
    use HasFactory;
    protected $primaryKey = 'section_id';
    protected $fillable = [
        'section_name',
        'program_id',
    ];

    public function program(){
        return $this->belongsTo(Program::class);
    }
}
