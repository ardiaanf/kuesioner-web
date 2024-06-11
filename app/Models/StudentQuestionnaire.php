<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentQuestionnaire extends Model
{
    use HasFactory;

    protected $table = 'student_questionnaires';

    protected $fillable = [
        'name',
        'description',
        'type',
        'admin_id',
    ];
}
