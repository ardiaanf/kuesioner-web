<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerAnswer extends Model
{
    use HasFactory;

    protected $table = 'lecturer_answers';

    protected $fillable = [
        'answer',
        'lecturer_id',
        'lecturer_questionnaire_id',
        'lecturer_element_id',
        'lecturer_question_id'
    ];

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function lecturerQuestionnaire()
    {
        return $this->belongsTo(lecturerQuestionnaire::class);
    }

    public function lecturerElement()
    {
        return $this->belongsTo(lecturerElement::class);
    }

    public function lecturerQuestion()
    {
        return $this->belongsTo(lecturerQuestion::class);
    }
}
