<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Pastikan ini diimpor
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Tambahkan ini

class Lecturer extends Authenticatable // Pastikan model ini mengextends Authenticatable
{
    use Notifiable, HasApiTokens; // Tambahkan HasApiTokens di sini

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

    public function lecturerCourses()
    {
        return $this->hasMany(LecturerCourse::class, 'lecturer_id');
    }
}
