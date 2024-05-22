<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'id_role';
    public $timestamps = true;

    public function users()
    {
        return $this->hasMany(User::class, 'id_role');
    }
    public function kuesioners()
    {
        return $this->hasOne(kuesioner::class, 'id_role');
    }
}
