<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kuesioner extends Model
{
    use HasFactory;
    protected $table = 'kuesioners';
    protected $primaryKey = 'id_kuesioner';
    public $timestamps = true;

    public function elemens()
    {
        return $this->hasMany(elemen::class, 'id_kuesioner');
    }

    public function roles()
    {
        return $this->belongsTo(role::class, 'id_role');
    }
}
