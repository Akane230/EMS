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
        'status',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    /**
     * Scope a query to only include active terms.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include current terms.
     */
    public function scopeCurrent($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include upcoming terms.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming');
    }

    /**
     * Scope a query to only include completed terms.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Check if the term is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if the term is current
     */
    public function isCurrent()
    {
        return $this->status === 'active';
    }

    /**
     * Check if the term is upcoming
     */
    public function isUpcoming()
    {
        return $this->status === 'upcoming';
    }

    /**
     * Check if the term is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function enrollments(){
        return $this->hasMany(Enrollment::class);
    }
}
