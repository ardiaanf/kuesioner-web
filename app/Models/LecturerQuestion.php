<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerQuestion extends Model
{
    use HasFactory;

    protected $table = 'lecturer_questions';

    protected $fillable = [
        'question',
        'min_range',
        'max_range',
        'label',
        'lecturer_element_id'
    ];

    public function lecturerElement()
    {
        return $this->belongsTo(lecturerElement::class);
    }
}
