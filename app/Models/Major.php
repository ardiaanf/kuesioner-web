<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $table = 'majors';

    public function studyPrograms()
    {
        return $this->hasMany(StudyProgram::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
