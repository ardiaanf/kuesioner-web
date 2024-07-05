<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'students';

    protected $fillable = [
        'name',
        'reg_number',
        'email',
        'password',
        'semester',
        'major_id',
        'study_program_id',
        'student_class_id',
    ];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class);
    }
}
