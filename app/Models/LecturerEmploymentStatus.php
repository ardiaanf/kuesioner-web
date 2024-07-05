<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerEmploymentStatus extends Model
{
    use HasFactory;

    protected $table = 'lecturer_employment_statuses';

    public function lecturers()
    {
        return $this->hasMany(Lecturer::class);
    }
}
