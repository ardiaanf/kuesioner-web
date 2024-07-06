<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswerDetailTlp extends Model
{
    use HasFactory;

    protected $table = 'student_answer_detail_tlps';

    protected $fillable = [
        'major_id',
        'study_program_id',
        'student_class_id',
        'course_id',
        'lecturer_id',
        'student_id',
    ];

    public function studentAnswerTlp()
    {
        return $this->hasMany(StudentAnswerTlp::class);
    }
}
