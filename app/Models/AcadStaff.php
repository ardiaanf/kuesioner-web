<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class AcadStaff extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acad_staffs';

    protected $fillable = [
        'name',
        'reg_number',
        'email',
        'password',
        'work_period',
    ];
}
