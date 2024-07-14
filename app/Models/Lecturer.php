<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Lecturer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'lecturers';

    protected $fillable = [
        'name',
        'reg_number',
        'email',
        'password',
        'gender',
        'work_period',
        'lecturer_employment_status_id',
    ];

    public function lecturerEmploymentStatus()
    {
        return $this->belongsTo(LecturerEmploymentStatus::class);
    }

    public function studyPrograms()
    {
        return $this->belongsToMany(StudyProgram::class, 'lecturer_study_programs');
    }
}
