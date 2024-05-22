<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prodi extends Model
{
    use HasFactory;
    protected $table = 'prodis';
    protected $primaryKey = 'id_prodi';
    public $timestamps = true;

    public function user()
    {
        return $this->hasMany(User::class, 'id_prodi');
    }
}
