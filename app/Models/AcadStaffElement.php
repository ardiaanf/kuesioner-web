<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcadStaffElement extends Model
{
    use HasFactory;

    protected $table = 'acad_staff_elements';

    protected $fillable = [
        'name',
        'description',
        'acad_staff_questionnaire_id',
    ];

    public function acadstaffQuestionnaire()
    {
        return $this->belongsTo(AcadStaffQuestionnaire::class);
    }

    public function acadstaffQuestions()
    {
        return $this->hasMany(AcadStaffQuestion::class);
    }
}
