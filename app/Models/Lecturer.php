<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Lecturer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'lecturers';

    protected $fillable = [
        'name',
        'reg_number',
        'email',
        'password',
        'work_period',
    ];
}
