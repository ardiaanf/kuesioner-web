<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerStudyProgram extends Model
{
    use HasFactory;

    protected $table = 'lecturer_study_programs';

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }
}
