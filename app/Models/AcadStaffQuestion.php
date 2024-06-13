<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcadStaffQuestion extends Model
{
    use HasFactory;

    protected $table = 'acad_staff_questions';

    protected $fillable = [
        'question',
        'min_range',
        'max_range',
        'label',
        'acad_staff_element_id'
    ];

    public function acadstaffElement()
    {
        return $this->belongsTo(AcadStaffElement::class);
    }
}
