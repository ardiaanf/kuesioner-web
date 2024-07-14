<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswerAc extends Model
{
    use HasFactory;

    protected $table = 'student_answer_acs';

    protected $fillable = [
        'answer',
        'student_id',
        'student_questionnaire_id',
        'student_element_id',
        'student_question_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function studentQuestionnaire()
    {
        return $this->belongsTo(StudentQuestionnaire::class);
    }

    public function studentElement()
    {
        return $this->belongsTo(StudentElement::class);
    }

    public function studentQuestion()
    {
        return $this->belongsTo(StudentQuestion::class);
    }
}
