<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerAnswer extends Model
{
    use HasFactory;

    protected $table = 'acad_staff_answers';

    protected $fillable = [
        'answer',
        'lecturer_id',
        'lecturer_questionnaire_id',
        'lecturer_element_id',
        'lecturer_question_id'
    ];

    public function acadStaff()
    {
        return $this->belongsTo(AcadStaff::class);
    }

    public function acadStaffQuestionnaire()
    {
        return $this->belongsTo(AcadStaffQuestionnaire::class);
    }

    public function acadStaffElement()
    {
        return $this->belongsTo(AcadStaffElement::class);
    }

    public function acadStaffQuestion()
    {
        return $this->belongsTo(AcadStaffQuestion::class);
    }
}
