<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerQuestionnaire extends Model
{
    use HasFactory;

    protected $table = 'lecturer_questionnaires';

    protected $fillable = [
        'name',
        'description',
        'admin_id',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function lecturerElements()
    {
        return $this->hasMany(LecturerElement::class);
    }
}
