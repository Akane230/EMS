<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Student;
use App\Models\Instructor;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
        'last_login',
        'failed_attempts'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login' => 'datetime',
        ];
    }
    
    /**
     * Get role badge class based on user role
     *
     * @return string
     */
    public function getRoleBadgeClass(): string
    {
        return match($this->role) {
            'Admin' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            'Instructor' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'Student' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
        };
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }
    
    public function instructors()
    {
        return $this->hasMany(Instructor::class);
    }
}