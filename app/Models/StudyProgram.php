<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    use HasFactory;

    protected $table = 'study_programs';

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
