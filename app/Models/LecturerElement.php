<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerElement extends Model
{
    use HasFactory;

    protected $table = 'lecturer_elements';

    protected $fillable = [
        'name',
        'description',
        'lecturer_questionnaire_id',
    ];

    public function lecturerQuestionnaire()
    {
        return $this->belongsTo(LecturerQuestionnaire::class);
    }

    public function lecturerQuestions()
    {
        return $this->hasMany(lecturerQuestion::class);
    }
}
