<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswerTlp extends Model
{
    use HasFactory;

    protected $table = 'student_answer_tlps';

    protected $fillable = [
        'answer',
        'student_answer_detail_tlp_id',
        'student_questionnaire_id',
        'student_element_id',
        'student_question_id',
    ];

    public function studentAnswerDetailTlp()
    {
        return $this->belongsTo(StudentAnswerDetailTlp::class);
    }
}
