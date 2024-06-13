<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcadStaffQuestionnaire extends Model
{
    use HasFactory;

    protected $table = 'acad_staff_questionnaires';

    protected $fillable = [
        'name',
        'description',
        'admin_id',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function acadstaffElements()
    {
        return $this->hasMany(AcadStaffElement::class);
    }
}
