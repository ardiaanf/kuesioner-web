<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcadStaffWorkUnit extends Model
{
    use HasFactory;

    protected $table = 'acad_staff_work_units';

    public function acadStaff()
    {
        return $this->hasMany(AcadStaff::class);
    }
}
