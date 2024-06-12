<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentElement extends Model
{
    use HasFactory;

    protected $table = 'student_elements';

    protected $fillable = [
        'name',
        'description',
        'student_questionnaire_id',
    ];

    public function studentQuestionnaire()
    {
        return $this->belongsTo(StudentQuestionnaire::class);
    }

    public function studentQuestions()
    {
        return $this->hasMany(StudentQuestion::class);
    }
}
