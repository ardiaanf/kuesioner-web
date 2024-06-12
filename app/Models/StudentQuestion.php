<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentQuestion extends Model
{
    use HasFactory;

    protected $table = 'student_questions';

    protected $fillable = [
        'question',
        'min_range',
        'max_range',
        'label',
        'student_element_id'
    ];

    public function studentElement()
    {
        return $this->belongsTo(StudentElement::class);
    }
}
